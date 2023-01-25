<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StockValue extends BaseWidget
{
    protected function getCards(): array
    {
        $purchase_total = Product::all()->sum(fn ($product) => $product->latest_unit_price * $product->total_quantity);
        $sale_total = Product::all()->sum(fn ($product) => $product->latest_sale_price * $product->total_quantity);
        $profit = $sale_total - $purchase_total;
        $percentage = $purchase_total > 0 ? round($profit / $purchase_total * 100) : 0 ;
        $icon = $profit > 0 ? 'heroicon-o-trending-up' : 'heroicon-o-trending-down';
        $color = $profit > 0 ? 'success' : 'warning';

        return [
            Card::make('Purchase Total', money($purchase_total, 'DZD', true)),
            Card::make('Sale Total', money($sale_total, 'DZD', true)),
            Card::make('Profit', money($profit, 'DZD', true))
                ->description($percentage . '%')
                ->descriptionIcon($icon)
                ->color($color),
        ];
    }
}
