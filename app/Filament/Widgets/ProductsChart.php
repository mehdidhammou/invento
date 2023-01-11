<?php

namespace App\Filament\Widgets;

use App\Services\ProductTypeService;
use Filament\Widgets\PieChartWidget;
use Illuminate\Database\Eloquent\Collection;
use PhpParser\ErrorHandler\Collecting;
use Psy\CodeCleaner\LabelContextPass;

class ProductsChart extends PieChartWidget
{

    protected static ?string $heading = 'Best Selling Product Types';

    protected int | string | array $columnSpan = '2';

    protected $bestSellingProducts;


    public function __construct()
    {
        $this->bestSellingProducts = ProductTypeService::getBestSellingTypes();
    }

    protected function getData(): array
    {
        return [
            'labels' => $this->bestSellingProducts->pluck('product_type_name')->toArray(),
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