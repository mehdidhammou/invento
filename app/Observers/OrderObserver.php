<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Invoice;
use App\Enums\OrderStatusEnum;
use App\Models\BL;
use App\Services\OrderService;
use Filament\Notifications\Notification;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        // create invoice
        Invoice::factory(1)->create([
            'order_id' => $order->id,
            'number' => 0
        ]);
        
        // create bl
        BL::factory(1)->create([
            'order_id' => $order->id,
            'number' => 0
        ]);

        Notification::make()
        ->success()
        ->title('Invoice and BL created')
        ->send();
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        if ($order->isDirty('delivered')) {
            if ($order->delivered) {
                Orderservice::resetTotalPrice($order);
                OrderService::addProductsToStock($order);
                OrderService::addBalanceToSupplier($order);
            }
        }

        if ($order->isDirty('total_paid')) {
            if ($order->total_paid == $order->total_price) {
                $order->status = OrderStatusEnum::PAID->name;
                Notification::make()
                    ->success()
                    ->title('Congrats!, Order has been fully paid')
                    ->send();
            } else {
                $order->status = OrderStatusEnum::UNPAID->name;
            }
            $order->saveQuietly();
        }
    }

    /**
     * Handle the Order "deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function restored(Order $order)
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function forceDeleted(Order $order)
    {
        //
    }
}
