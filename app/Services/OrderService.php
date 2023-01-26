<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    public static function getOrderFilename($order)
    {
        return 'order_' . $order->id . '_' . $order->date . '.pdf';
    }

    public static function updateConnectedAttributes(Order $order)
    {
        // update total price
        $new_total_price = 0;
        foreach ($order->orderProducts as $orderProduct) {
            $new_total_price += $orderProduct->unit_price * $orderProduct->quantity;
        }
        $order->total_price = $new_total_price;
        $old_amount_owed = $order->getOriginal('total_price') - $order->getOriginal('total_paid');
        $new_amount_owed = $order->total_price - $order->total_paid;
        $order->supplier->balance += $old_amount_owed - $new_amount_owed;
        $order->supplier->save();
        $order->saveQuietly();
    }
}
