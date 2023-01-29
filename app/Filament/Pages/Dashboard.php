<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\BestSellingProducts;
use App\Filament\Widgets\CurrentYearAnalysisWidget;
use App\Filament\Widgets\TopClients;
use App\Filament\Widgets\YearlyAnalysisWidget;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    protected static string $view = 'filament.pages.dashboard';


    protected function getHeaderWidgets(): array
    {
        return [
            CurrentYearAnalysisWidget::class,
            YearlyAnalysisWidget::class,
            BestSellingProducts::class,
            TopClients::class
        ];
    }
}
