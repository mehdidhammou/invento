<?php

namespace App\Filament\Widgets;

use Filament\Widgets\PieChartWidget;
use Psy\CodeCleaner\LabelContextPass;

class ProductsChart extends PieChartWidget
{

    protected static ?string $heading = 'Products';

    protected function getData(): array
    {
        return [
            'lables' => ['Product 1', 'Product 2', 'Product 3'],
        ];
    }
}
