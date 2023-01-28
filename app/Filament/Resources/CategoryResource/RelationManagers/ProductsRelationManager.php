<?php

namespace App\Filament\Resources\CategoryResource\RelationManagers;

use Filament\Tables;
use Filament\Resources\Table;
use Filament\Resources\RelationManagers\RelationManager;

class ProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'products';

    protected static ?string $recordTitleAttribute = 'name';


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('total_quantity'),

            ]);
    }
}
