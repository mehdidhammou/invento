<?php

namespace App\Observers;

use App\Models\OrderProduct;
use App\Services\OrderService;
use Filament\Notifications\Notification;

class OrderProductObserver
{
    /**
     * Handle the OrderProduct "created" event.
     *
     * @param  \App\Models\OrderProduct  $orderProduct
     * @return void
     */
    public function created(OrderProduct $orderProduct)
    {
        OrderService::updateConnectedAttributes($orderProduct->order);
    }

    /**
     * Handle the OrderProduct "updated" event.
     *
     * @param  \App\Models\OrderProduct  $orderProduct
     * @return void
     */
    public function updated(OrderProduct $orderProduct)
    {
        OrderService::updateConnectedAttributes($orderProduct->order);
    }
    
    /**
     * Handle the OrderProduct "deleted" event.
     *
     * @param  \App\Models\OrderProduct  $orderProduct
     * @return void
     */
    public function deleted(OrderProduct $orderProduct)
    {
        OrderService::updateConnectedAttributes($orderProduct->order);
    }

    /**
     * Handle the OrderProduct "restored" event.
     *
     * @param  \App\Models\OrderProduct  $orderProduct
     * @return void
     */
    public function restored(OrderProduct $orderProduct)
    {
        //
    }

    /**
     * Handle the OrderProduct "force deleted" event.
     *
     * @param  \App\Models\OrderProduct  $orderProduct
     * @return void
     */
    public function forceDeleted(OrderProduct $orderProduct)
    {
        //
    }
}
