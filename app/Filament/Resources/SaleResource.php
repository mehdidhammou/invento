<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\Sale;
use Filament\Tables;
use App\Models\Product;
use Filament\Resources\Form;
use App\Enums\SaleStatusEnum;
use Filament\Resources\Table;
use App\Enums\OrderStatusEnum;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\SaleResource\Pages;
use App\Filament\Resources\SaleResource\RelationManagers\ClientRelationManager;
use App\Filament\Resources\SaleResource\RelationManagers\SettlementsRelationManager;
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
                Grid::make(3)->schema([
                    Section::make('Sale Details')
                        ->columnSpan(2)
                        ->schema([
                            Select::make('client_id')
                                ->searchable()
                                ->relationship('client', 'name')
                                ->disabledOn('edit')
                                ->preload()
                                ->required(),
                            DatePicker::make('date')
                                ->default(now())
                                ->minDate(today())
                                ->required(),
                            Toggle::make('purchased')
                                ->inline(false)
                                ->required()
                                ->disabled(
                                    function (string $context, $record) {
                                        if ($context == 'create') {
                                            return true;
                                        }
                                        return $record->purchased;
                                    }
                                )
                                ->hint('toggling this will remove products from the inventory and disable any further changes!')
                                ->hintColor('warning'),
                        ]),
                    Section::make('Payment Details')
                        ->disabled()
                        ->columnSpan(1)
                        ->schema([
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
                            Select::make('status')
                                ->options(SaleStatusEnum::enumOptions())
                                ->default(SaleStatusEnum::UNPAID->name)
                        ])
                ]),
                Section::make('Products')->schema([
                    Repeater::make('saleProducts')
                        ->relationship()
                        ->createItemButtonLabel('Add Products')
                        ->columns(4)
                        ->label(false)
                        ->disabled(function (string $context, $record) {
                            if ($context == 'create') {
                                return false;
                            }
                            return $record->purchased;
                        })
                        ->schema([
                            Select::make('product_id')
                                ->relationship('product', 'name', function (Builder $query) {
                                    $query->where('total_quantity', '>', 0);
                                })
                                ->preload()
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    if ($state == null) {
                                        $set('unit_price', null);
                                        $set('sale_price', null);
                                        return;
                                    };
                                    $product = Product::where('id', $state)->first();
                                    if ($product == null) return;
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
                        ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('client.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sale_products_count')
                    ->counts('saleProducts')
                    ->label('# Products')
                    ->sortable(),
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
            ])
            ->actions([
                Action::make('Export')
                    ->icon('heroicon-o-download')
                    ->url(fn ($record) => route('export.sale', $record->id)),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            SettlementsRelationManager::class,
            ClientRelationManager::class,
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
