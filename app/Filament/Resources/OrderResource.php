<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Order;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Enums\OrderStatusEnum;
use App\Filament\Resources\OrderResource\RelationManagers\ProductsRelationManager;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\Pages\EditOrder;
use App\Filament\Resources\OrderResource\Pages\ListOrders;
use App\Filament\Resources\OrderResource\Pages\CreateOrder;
use App\Filament\Resources\OrderResource\RelationManagers\SupplierRelationManager;
use App\Filament\Resources\OrderResource\RelationManagers\SettlementsRelationManager;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';

    protected static ?string $navigationGroup = 'Transactions';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(3)->schema([
                    Section::make('Order Details')
                        ->columnSpan(2)
                        ->schema([
                            Select::make('supplier_id')
                                ->searchable()
                                ->disabled(fn (string $context) => $context == 'edit')
                                ->relationship('supplier', 'name')
                                ->preload()
                                ->required(),
                            DatePicker::make('date')
                                ->default(now())
                                ->required(),
                            Toggle::make('delivered')
                                ->inline(false)
                                ->required()
                                ->disabled(
                                    function (string $context, $record) {
                                        if ($context == 'create') {
                                            return true;
                                        }
                                        return $record->delivered;
                                    }
                                )
                                ->hint('toggling this will add products to the inventory and disable any further changes!')
                                ->hintColor('warning'),
                        ]),
                    Section::make('Payment Status')
                        ->disabled()
                        ->columnSpan(1)
                        ->schema([
                            TextInput::make('total_price')
                                ->numeric()
                                ->default(0),
                            TextInput::make('total_paid')
                                ->numeric()
                                ->default(0),
                            Select::make('status')
                                ->options(OrderStatusEnum::enumOptions())
                                ->default(OrderStatusEnum::UNPAID->name),
                        ])
                ]),

                Section::make('Products')
                    ->schema([
                        Repeater::make('orderProducts')
                            ->label(false)
                            ->columns(4)
                            ->relationship()
                            ->createItemButtonLabel('Add Products')
                            ->disabled(function (string $context, $record) {
                                if ($context == 'create') {
                                    return false;
                                }
                                return $record->delivered;
                            })
                            ->schema([
                                Select::make('product_id')
                                    ->relationship('product', 'name')
                                    ->preload()
                                    ->required(),
                                TextInput::make('quantity')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0),
                                TextInput::make('unit_price')
                                    ->numeric()
                                    ->required()
                                    ->default(0)
                                    ->disabledOn('create')
                                    ->minValue(0),
                                TextInput::make('sale_price')
                                    ->numeric()
                                    ->disabledOn('create')
                                    ->required()
                                    ->default(0)
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
                TextColumn::make('supplier.name')
                    ->sortable()
                    ->searchable()
                    ->label('Supplier'),
                TextColumn::make('order_products_count')
                    ->counts('orderProducts')
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
                IconColumn::make('delivered')
                    ->options(['heroicon-o-check-circle' => 1, 'heroicon-o-x-circle' => 0])
                    ->colors(['success' => 1, 'warning' => 0]),
                BadgeColumn::make('status')
                    ->colors(OrderStatusEnum::enumColors())
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(OrderStatusEnum::enumOptions())
                    ->label('Payment Status')
                    ->placeholder('All Statuses'),
                Filter::make('delivered')
                    ->label('Delivery Status')
                    ->query(fn (Builder $query) => $query->where('delivered', 1))
                    ->toggle()
            ])
            ->actions([
                Action::make('Export')
                    ->icon('heroicon-o-download')
                    ->url(fn ($record) => route('export.order', $record->id)),
                EditAction::make()
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            SettlementsRelationManager::class,
            SupplierRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
