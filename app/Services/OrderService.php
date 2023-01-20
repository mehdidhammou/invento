<?php

namespace App\Services;

class OrderService
{
    public static function getOrderFilename($order)
    {
        return 'order_' . $order->id . '_' . $order->date . '.pdf';
    }
}