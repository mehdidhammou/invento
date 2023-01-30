<?php

namespace App\Filament\Widgets;

use App\Services\WidgetService;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\PieChartWidget;

class TopSuppliers extends PieChartWidget
{
    protected static ?string $heading = 'Top suppliers';

    protected function getData(): array
    {
        $suppliers = DB::table('orders')->join('suppliers', 'orders.supplier_id', '=', 'suppliers.id')->selectRaw('suppliers.name, sum(orders.total_paid) as total')->groupBy('suppliers.name')->get();

        $data = [];
        $labels = [];

        foreach ($suppliers as $client) {
            $data[] = $client->total;
            $labels[] = $client->name;
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
