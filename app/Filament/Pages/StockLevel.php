<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\TestWidget;
use Filament\Tables;
use App\Models\Product;
use Livewire\Component;
use Filament\Pages\Page;
use Tables\Contracts\HasTable;
use Illuminate\Contracts\View\View;
use PhpParser\ErrorHandler\Collecting;
use Filament\Tables\Actions\BulkAction;
use Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Filament\Tables\Actions\DeleteBulkAction;

class StockLevel extends Page implements Tables\Contracts\HasTable

{
    use Tables\Concerns\InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.stock-level';

    public $products;
    
    public function mount()
    {
        $this->products = count($this->getSelectedTableRecords()) ? $this->getSelectedTableRecords() : Product::all();
    }

    protected function getTableQuery(): Builder
    {
        return Product::query();
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('name'),
            Tables\Columns\TextColumn::make('total_quantity'),
            Tables\Columns\TextColumn::make('latest_unit_price')->money('DZD', true),
            Tables\Columns\TextColumn::make('latest_sale_price')->money('DZD', true),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [
            BulkAction::make('Update Selection')
                ->action(function (Collection $records) {
                    $this->products = $records;
                    return $records;
                })
                ->requiresConfirmation(),
        ];
    }
}
