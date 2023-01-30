<?php

namespace App\Filament\Resources\SupplierResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use App\Enums\SaleStatusEnum;
use Filament\Resources\Table;
use App\Enums\OrderStatusEnum;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class OrdersRelationManager extends RelationManager
{
    protected static string $relationship = 'orders';

    protected static ?string $recordTitleAttribute = 'date';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('total_price')
                    ->money('DZD', true)
                    ->sortable(),
                TextColumn::make('total_paid')
                    ->money('DZD', true)
                    ->sortable(),
                TextColumn::make('date')
                    ->sortable(),
                IconColumn::make('delivered')
                    ->options(['heroicon-o-check-circle' => 1, 'heroicon-o-x-circle' => 0])
                    ->colors(['success' => 1, 'warning' => 0]),
                BadgeColumn::make('status')
                    ->colors(SaleStatusEnum::enumColors())
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(SaleStatusEnum::enumOptions())
                    ->label('Payment Status')
                    ->placeholder('All Statuses'),
                Filter::make('Delivered')
                    ->label('Delivered')
                    ->query(fn (Builder $query) => $query->where('delivered', 1))
                    ->toggle()
            ])
            ->headerActions([])
            ->actions([])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
