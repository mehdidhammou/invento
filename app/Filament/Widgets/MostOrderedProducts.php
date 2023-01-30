<?php

namespace App\Filament\Widgets;

use App\Services\WidgetService;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\PieChartWidget;

class MostOrderedProducts extends PieChartWidget
{
    protected static ?string $heading = 'Most ordered products';

    protected function getData(): array
    {
        $products = DB::table('order_product')->join('products', 'order_product.product_id', '=', 'products.id')->selectRaw('products.id, products.name, sum(order_product.quantity) as total')->groupBy(['products.id', 'products.name'])->get();
        $data = [];
        $labels = [];
        foreach ($products as $product) {
            $data[] = $product->total;
            $labels[] = $product->name;
        }

        $colors = WidgetService::generateRandomColors(count($data));
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $data,
                    'backgroundColor' => $colors,
                ],
            ],
            'labels' => $labels
        ];
    }
}
