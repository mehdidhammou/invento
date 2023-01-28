<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Enums\OrderStatusEnum;
use Filament\Resources\Resource;
use App\Models\SupplierSettlement;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SupplierSettlementResource\Pages;
use App\Filament\Resources\SupplierSettlementResource\RelationManagers;
use App\Filament\Resources\SupplierSettlementResource\Pages\ManageSupplierSettlements;

class SupplierSettlementResource extends Resource
{
    protected static ?string $model = SupplierSettlement::class;

    protected static ?string $navigationGroup = 'Settlements';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-check';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('order.date')
                    ->date()
                    ->label('Order Date')
                    ->sortable(),
                BadgeColumn::make('order.status')
                    ->label('Order Status')
                    ->colors(OrderStatusEnum::enumColors())
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('DZD', true)
                    ->sortable(),
                TextColumn::make('date')
                    ->date()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since(),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->filters([
                TernaryFilter::make('Order Status')
                    ->placeholder('All')
                    ->trueLabel('Paid')
                    ->falseLabel('Unpaid')
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('order', fn ($query) => $query->where('status', OrderStatusEnum::PAID->name)),
                        false: fn (Builder $query) => $query->whereHas('order', fn ($query) => $query->where('status', OrderStatusEnum::UNPAID->name)),
                    )

            ])
            ->actions([
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSupplierSettlements::route('/'),
        ];
    }
}
