<?php

namespace App\Filament\Widgets;

use App\Models\Sale;
use Filament\Widgets\LineChartWidget;

class CurrentYearAnalysisWidget extends LineChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getHeading(): string
    {
        return now()->year. ' Income';
    }

    protected function getData(): array
    {
        $data = [];
        $data[] = Sale::whereMonth('date', 1)->whereYear('date', now()->year)->sum('total_price');
        for ($i = 1; $i < 12; $i++) {
                $data[] = $data[$i-1] + Sale::whereMonth('date', $i+1)->whereYear('date', now()->year)->sum('total_price');
        }
        return [
            'datasets' => [
                [
                    'label' => 'Income Evolution',
                    'data' => $data,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }
}
