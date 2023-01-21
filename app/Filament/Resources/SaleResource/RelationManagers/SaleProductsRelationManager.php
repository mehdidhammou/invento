<?php

namespace App\Filament\Resources\SaleResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\DeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class SaleProductsRelationManager extends RelationManager
{
    protected static string $relationship = 'saleProducts';

    protected static ?string $recordTitleAttribute = 'created_at';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->label('Product')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $product = Product::where('id', $state)->first();
                        $set('unit_price', $product->latest_price);
                    }),
                TextInput::make('quantity')
                    ->required()
                    ->reactive()
                    ->default(0)
                    ->disabled(fn (string $context) => $context === 'create')
                    ->numeric()
                    ->maxValue(fn (callable $get) => $get('product_id') ? Product::find($get('product_id'))->total_quantity : 0)
                    ->minValue(0),
                TextInput::make('unit_price')
                    ->numeric()
                    ->required()
                    ->disabled()
                    ->minValue(0),
                TextInput::make('sale_price')
                    ->numeric()
                    ->minValue(0)
                    ->required()
                    ->disabled(
                        fn (string $context) => $context === 'create'
                    )
                    ->default(0)
                    ->minValue(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->sortable(),
                Tables\Columns\TextColumn::make('unit_price')
                    ->sortable(),
                Tables\Columns\TextColumn::make('sale_price')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
