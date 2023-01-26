<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Sale;
use Filament\Tables;
use App\Models\Product;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Enums\SaleStatusEnum;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\SaleResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SaleResource\Pages\EditSale;
use App\Filament\Resources\SaleResource\Pages\ListSales;
use App\Filament\Resources\SaleResource\Pages\CreateSale;
use App\Filament\Resources\SaleResource\RelationManagers;
use App\Filament\Resources\SaleResource\RelationManagers\SaleProductsRelationManager;

class SaleResource extends Resource
{
    protected static ?string $model = Sale::class;

    protected static ?string $navigationIcon = 'heroicon-o-cash';

    protected static ?string $navigationGroup = 'Transactions';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Sale Details')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('client_id')
                                ->searchable()
                                ->relationship('client', 'name')
                                ->disabledOn('edit')
                                ->preload()
                                ->required(),
                            TextInput::make('total_price')
                                ->required()
                                ->numeric()
                                ->disabled()
                                ->default(0),
                            TextInput::make('total_paid')
                                ->disabledOn('create')
                                ->numeric()
                                ->placeholder('modifiable after creating the sale')
                                ->lte('total_price')
                                ->required()
                                ->default(0),
                            DatePicker::make('date')
                                ->default(now())
                                ->required(),
                            Select::make('status')
                                ->options(SaleStatusEnum::enumOptions())
                                ->default(SaleStatusEnum::UNPAID->name)
                                ->disabledOn('create')
                                ->required(),
                        ])
                    ]),

                Repeater::make('saleProducts')
                    ->relationship()
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(4)->schema([
                            Select::make('product_id')
                                ->relationship('product', 'name', function (Builder $query) {
                                    $query->where('total_quantity', '>', 0);
                                })
                                ->preload()
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $product = Product::where('id', $state)->first();
                                    $set('unit_price', $product->latest_unit_price);
                                    $set('sale_price', $product->latest_sale_price);
                                }),
                            TextInput::make('quantity')
                                ->required()
                                ->reactive()
                                ->numeric()
                                ->placeholder(
                                    function (callable $get) {
                                        if ($get('product_id')) {
                                            return 'max: ' . Product::where('id', $get('product_id'))->first()->total_quantity;
                                        }
                                        return 'max: 0';
                                    }
                                )
                                ->maxValue(fn (callable $get) => $get('product_id') ? Product::where('id', $get('product_id'))->first()->total_quantity : 0)
                                ->minValue(0),
                            TextInput::make('unit_price')
                                ->numeric()
                                ->required()
                                ->disabled()
                                ->minValue(0),
                            TextInput::make('sale_price')
                                ->numeric()
                                ->disabled()
                                ->required()
                                ->gte('unit_price')
                                ->minValue(0),
                        ])
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_paid')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors(SaleStatusEnum::enumColors())
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->multiple()
                    ->options(SaleStatusEnum::enumOptions())
                    ->placeholder('All Statuses'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('export')
                    ->icon('heroicon-o-download')
                    ->url(fn ($record) => route('export.sale', $record->id)),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            SaleProductsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSales::route('/'),
            'create' => Pages\CreateSale::route('/create'),
            'edit' => Pages\EditSale::route('/{record}/edit'),
        ];
    }
}
