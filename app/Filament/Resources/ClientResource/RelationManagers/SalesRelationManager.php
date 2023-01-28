<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use App\Enums\SaleStatusEnum;
use Filament\Resources\Table;
use App\Enums\OrderStatusEnum;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SalesRelationManager extends RelationManager
{
    protected static string $relationship = 'sales';

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
                IconColumn::make('purchased')
                    ->options(['heroicon-o-check-circle' => 1, 'heroicon-o-x-circle' => 0])
                    ->colors(['success' => 1, 'warning' => 0]),
                BadgeColumn::make('status')
                    ->colors(OrderStatusEnum::enumColors())
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(SaleStatusEnum::enumOptions())
                    ->label('Payment Status')
                    ->placeholder('All Statuses'),
                Filter::make('purchased')
                    ->label('Sale Status')
                    ->query(fn (Builder $query) => $query->where('purchased', 1))
                    ->toggle()
            ]);
    }
}
