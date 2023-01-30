<?php

namespace App\Filament\Pages;

use Illuminate\Contracts\View\View;
use App\Filament\Widgets\TopClients;
use Filament\Pages\Dashboard as BasePage;
use App\Filament\Widgets\BestSellingProducts;
use App\Filament\Widgets\YearlyAnalysisWidget;
use App\Filament\Widgets\CurrentYearAnalysisWidget;
use App\Filament\Widgets\CurrentYearOrdersAnalysisWidget;
use App\Filament\Widgets\MostOrderedProducts;
use App\Filament\Widgets\TopSuppliers;

class Dashboard extends BasePage
{
    protected static string $view = 'filament.pages.dashboard';


    protected function getHeader(): View
    {
        return view('filament.dashboard-header');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CurrentYearAnalysisWidget::class,
            YearlyAnalysisWidget::class,
            BestSellingProducts::class,
            TopClients::class
        ];
    }

    protected function getFooterWidgets(): array
    {
        return [
            MostOrderedProducts::class,
            TopSuppliers::class,
            CurrentYearOrdersAnalysisWidget::class,
        ];
    }
}
