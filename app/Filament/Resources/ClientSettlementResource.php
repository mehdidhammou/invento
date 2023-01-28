<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Sale;
use Filament\Tables;
use App\Models\Order;
use Filament\Resources\Form;
use App\Enums\SaleStatusEnum;
use Filament\Resources\Table;
use App\Enums\OrderStatusEnum;
use App\Models\ClientSettlement;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ClientSettlementResource\Pages;
use App\Filament\Resources\ClientSettlementResource\RelationManagers;
use App\Filament\Resources\ClientSettlementResource\Pages\ManageClientSettlements;

class ClientSettlementResource extends Resource
{
    protected static ?string $model = ClientSettlement::class;

    protected static ?string $navigationGroup = 'Settlements';


    protected static ?string $navigationIcon = 'heroicon-o-clipboard-check';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sale.date')
                    ->date()
                    ->label('Sale Date')
                    ->sortable(),
                BadgeColumn::make('sale.status')
                    ->label('Sale Status')
                    ->colors(SaleStatusEnum::enumColors())
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
                TernaryFilter::make('Sale Status')
                    ->placeholder('All')
                    ->trueLabel('Paid')
                    ->falseLabel('Unpaid')
                    ->queries(
                        true: fn (Builder $query) => $query->whereHas('sale', fn ($query) => $query->where('status', SaleStatusEnum::PAID->name)),
                        false: fn (Builder $query) => $query->whereHas('sale', fn ($query) => $query->where('status', SaleStatusEnum::UNPAID->name)),
                    )

            ])
            ->actions([
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageClientSettlements::route('/'),
        ];
    }
}
