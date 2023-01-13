<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ProductsOverview extends BaseWidget
{
    protected function getCards(): array
    {

        $products = Product::select('price', 'total_quantity')->get();
        $total_earnings = 0;
        foreach ($products as $product) {
            $total_earnings += $product->price * $product->total_quantity;
        }

        return [
            Card::make('Total Earnings', money($total_earnings, 'DZD',true))
                ->color('primary')
                ->chart([9, 5, 3, 7, 5, 10, 3, 5, 4, 10, 6, 9]),
            Card::make('Bounce rate', '21%'),
            Card::make('Average time on page', '3:12'),
        ];
    }
}
