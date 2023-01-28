<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Sale;
use Filament\Widgets\LineChartWidget;

class YearlyAnalysisWidget extends LineChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getHeading(): string
    {
        return 'All Time Income';
    }

    protected function getData(): array
    {
        // // get the minimum and maximum year of the sales
        // $minYear = Carbon::parse(Sale::min('date'))->year;
        // $maxYear = Carbon::parse(Sale::max('date'))->year;

        // // get the number of steps
        // $steps = floor(($maxYear - $minYear) / 12);
        
        // // data array
        // $data = [];

        // // labels array
        // $labels = [];

        // $data[] = Sale::whereYear('date', $minYear)->sum('total_price');
        // $i = 1;

        // while ($minYear < $maxYear) {
        //     $data[] = $data[$i-1] + Sale::whereYear('date', $minYear + $steps)->sum('total_price');
        //     $i++;
        //     $minYear += $steps;
        // }
        // labels
        return [
            'datasets' => [
                [
                    'label' => 'Income Evolution',
                    'data' => [],
                ],
            ],
            'labels' => [],
        ];
    }
}
