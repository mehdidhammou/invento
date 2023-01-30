<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\LineChartWidget;

class CurrentYearOrdersAnalysisWidget extends LineChartWidget
{

    protected function getHeading(): string
    {
        return now()->year . ' Order Evolution';
    }

    protected function getData(): array
    {
        $monthlyIncomes = [];

        for ($i = 1; $i <= 12; $i++) {
            $monthlyIncomes[] = Order::whereBetween('date', [today()->startOfYear(), today()->startOfYear()->addMonths($i - 1)->endOfMonth()])->sum('total_price');
        }

        return [
            'datasets' => [
                [
                    'label' => 'Income Evolution',
                    'data' => $monthlyIncomes,
                    'borderColor' => '#38bdf8',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
