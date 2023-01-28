<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Enums\OrderStatusEnum;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
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
                Tables\Columns\TextColumn::make('supplier.name')
                    ->sortable()
                    ->searchable()
                    ->label('Supplier'),
                Tables\Columns\TextColumn::make('total_price')
                    ->money('DZD', true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_paid')
                    ->money('DZD', true)
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->sortable(),
                IconColumn::make('delivered')
                    ->options([
                        'heroicon-o-check-circle' => 1,
                        'heroicon-o-x-circle' => 0,
                    ])
                    ->colors([
                        'success' => 1,
                        'warning' => 0,
                    ]),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors(OrderStatusEnum::enumColors())
                    ->sortable(),
            ])
            ->filters([
                //
            ]);
    }
}
