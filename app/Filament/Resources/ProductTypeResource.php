<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\ProductType;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\ProductTypeResource\Pages;
use App\Filament\Resources\ProductTypeResource\RelationManagers;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;

class ProductTypeResource extends Resource
{
    protected static ?string $model = ProductType::class;

    protected static ?string $navigationGroup = 'Inventory';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->unique()
                    ->maxLength(255),
                Forms\Components\TextInput::make('quantity')
                    ->disabled()
                    ->placeholder(
                        function (string $context, Model | null $record) {
                            if ($context == 'create') {
                                return 'Quantity will be calculated automatically';
                            }
                            return $record->products()->sum('total_quantity') ?? 0;
                        }
                    ),
                Select::make('products')
                    ->relationship('products', 'name')
                    ->multiple()
                    ->searchable()
                    ->placeholder('Select products...'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            'products' => RelationManagers\ProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductTypes::route('/'),
            'create' => Pages\CreateProductType::route('/create'),
            'edit' => Pages\EditProductType::route('/{record}/edit'),
        ];
    }
}
