<?php

namespace App\Filament\Pages;

use Filament\Tables;
use App\Models\Product;
use Filament\Pages\Page;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

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
            Tables\Columns\TextColumn::make('category.name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('name')
                ->sortable()
                ->searchable(),
            Tables\Columns\TextColumn::make('total_quantity')
                ->sortable(),
            Tables\Columns\TextColumn::make('latest_unit_price')
                ->label('Unit Price')
                ->money('DZD', true)
                ->sortable(),
            Tables\Columns\TextColumn::make('latest_sale_price')
                ->label('Sale Price')
                ->money('DZD', true)
                ->sortable(),
            Tables\Columns\TextColumn::make('latest_order_id')
                ->label('Order ID')
                ->sortable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->since(),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->since(),
        ];
    }

    public function getTableFilters(): array
    {
        return [
            SelectFilter::make('category_id')
                ->relationship('category', 'name')
                ->label('Categoies')
                ->multiple(),
            Filter::make('has an Order')
                ->query(fn (Builder $query) => $query->whereHas('orders'))
                ->toggle(),
            Filter::make('without Order')
                ->query(fn (Builder $query) => $query->whereDoesntHave('orders'))
                ->toggle(),
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
