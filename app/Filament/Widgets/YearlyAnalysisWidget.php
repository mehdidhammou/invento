<?php

namespace App\Filament\Widgets;

use Carbon\Carbon;
use App\Models\Sale;
use App\Models\Order;
use Filament\Widgets\LineChartWidget;

class YearlyAnalysisWidget extends LineChartWidget
{
    protected static ?string $heading = 'All time income';


    protected function getData(): array
    {
        // $year_range = Order::selectRaw('max(date) as maxYear, min(date) as minYear')->get();
        // $minYear = Carbon::parse($year_range[0]->minYear);
        // $maxYear = Carbon::parse($year_range[0]->maxYear);

        // // divide the range into 12 steps
        // $steps = $maxYear->diffInYears($minYear) / 12;
        // $data = [];
        // $labels = [];
        // $data[] = Sale::whereBetween('date', [$maxYear->subYears($steps), $maxYear])->sum('total_price');
        // $labels[] = $minYear;
        // for($i = 1; $i < 11; $i++) {
        //     $data[] = $data[$i - 1] + Sale::whereBetween('date', [Carbon::parse($minYear)->addYears($i * $steps), Carbon::parse($minYear)->addYears(($i + 1) * $steps)])->sum('total_price');
        //     $labels[] = $minYear + $i * $steps;
        // }

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
