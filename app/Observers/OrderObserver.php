<?php

namespace App\Observers;

use App\Enums\OrderStatusEnum;
use App\Models\Order;

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
        //
    }

    /**
     * Handle the Order "updated" event.
     *
     * @param  \App\Models\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        if ($order->isDirty('status')) {
            if ($order->getOriginal('status') == OrderStatusEnum::PENDING->name && in_array($order->status, [OrderStatusEnum::PAID->name, OrderStatusEnum::RECEIVED->name])) {
                foreach ($order->orderProducts()->with('product')->get() as $orderProduct) {
                    $orderProduct->product->total_quantity += $orderProduct->quantity;
                    $orderProduct->product->save();
                }
            }

            if ($order->isDirty('discount')) {
                $total = 0;
                foreach ($order->saleProducts as $saleProduct) {
                    $total += $saleProduct->sale_price * $saleProduct->quantity;
                }
                $order->total_price = $total - ($total * $order->discount / 100);
            }
        }
        $order->saveQuietly();
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
