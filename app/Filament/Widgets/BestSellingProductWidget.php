<?php

namespace App\Filament\Widgets;

use App\Services\ProductTypeService;
use Filament\Widgets\BarChartWidget;
use Filament\Widgets\Widget;

class BestSellingProductWidget extends BarChartWidget
{

    protected static ?string $heading = 'Best Selling Products';

    protected $bestSellingProducts;

    public function __construct()
    {
        $this->bestSellingProducts = ProductTypeService::getBestSellingProducts();
    }


    protected function getData(): array
    {
        return [
            'labels' => $this->bestSellingProducts->pluck('name')->toArray(),
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $this->bestSellingProducts->pluck('quantity')->toArray(),
                    'backgroundColor' => ['#f56565', '#4299e1', '#48bb78', '#ed8936', '#ed64a6', '#a0aec0', '#38b2ac', '#667eea', '#9f7aea', '#ed64a6', '#f56565', '#4299e1', '#48bb78', '#ed8936', '#ed64a6', '#a0aec0', '#38b2ac', '#667eea', '#9f7aea', '#ed64a6'],
                ],
            ],
        ];
    }

}
