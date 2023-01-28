<?php

namespace App\Services;

use App\Models\Order;

class OrderService
{
    public static function generateOrderFileName($order)
    {
        return 'order_' . $order->id . '_' . $order->date . '.pdf';
    }

    public static function resetTotalPrice(Order $order){
        $new_total_price = 0;
        foreach ($order->orderProducts as $orderProduct) {
            $new_total_price += $orderProduct->unit_price * $orderProduct->quantity;
        }
        $order->total_price = $new_total_price;
        $order->saveQuietly();

    }

    public static function addProductsToStock(Order $order){
        foreach ($order->orderProducts as $orderProduct) {
            $orderProduct->product->total_quantity += $orderProduct->quantity;
            $orderProduct->product->saveQuietly();
        }
    }
}
