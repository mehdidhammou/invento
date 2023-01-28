<?php


namespace App\Services;

use App\Models\Sale;
use Filament\Notifications\Notification;

class SaleService
{
    public static function generatesaleFileName($sale)
    {
        return 'sale_' . $sale->id . '_' . $sale->date . '.pdf';
    }

    public static function resetTotalPrice(Sale $sale)
    {
        $new_total_price = 0;
        foreach ($sale->saleProducts as $saleProduct) {
            $new_total_price += $saleProduct->sale_price * $saleProduct->quantity;
        }
        $sale->total_price = $new_total_price;
        $sale->saveQuietly();
    }

    public static function destockProducts(Sale $sale)
    {
        foreach ($sale->saleProducts as $saleProduct) {
            $saleProduct->product->total_quantity -= $saleProduct->quantity;
            $saleProduct->product->saveQuietly();
        }
        Notification::make()
            ->success()
            ->title('Prodcuts removed from stock')
            ->send();
    }

    public static function addBalanceToClient(Sale $sale)
    {
        $sale->client->balance += $sale->total_price;
        $sale->client->saveQuietly();
        Notification::make()
            ->success()
            ->title('Balance added to ' . $sale->client->name)
            ->send();
    }
}
