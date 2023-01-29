<?php

namespace App\Filament\Widgets;

use App\Models\OrderProduct;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\PieChartWidget;
use App\Services\WidgetService;

class BestSellingProducts extends PieChartWidget
{
    protected static ?string $heading = 'Best Selling Products';

    protected function getData(): array
    {
        // this is a pie chart from chart js , each product is a slice of the pie , the value is the quantity sold
        $products = DB::table('order_product')->join('products', 'order_product.product_id', '=', 'products.id')->selectRaw('products.name, sum(order_product.quantity) as total')->groupBy('products.name')->get();
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
