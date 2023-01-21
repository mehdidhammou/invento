<?php

namespace App\Filament\Resources\BLResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Enums\OrderStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class OrderRelationManager extends RelationManager
{
    protected static string $relationship = 'order';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier.name'),
                Tables\Columns\TextColumn::make('total_price')->money('DZD'),
                Tables\Columns\TextColumn::make('total_paid')->money('DZD'),
                Tables\Columns\TextColumn::make('discount')
                    ->formatStateUsing(fn (string $state): string => __("{$state}%")),
                Tables\Columns\TextColumn::make('order_products_count')
                    ->counts('orderProducts')
                    ->label('Products'),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors(OrderStatusEnum::enumColors()),
            ]);
    }
}
