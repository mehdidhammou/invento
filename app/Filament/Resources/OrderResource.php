<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Order;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Enums\OrderStatusEnum;
use App\Filament\Resources\OrderResource\RelationManagers\SettlementsRelationManager;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\OrderResource\Pages;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';

    protected static ?string $navigationGroup = 'Transactions';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Sale Details')
                    ->schema([
                        Grid::make(2)->schema([
                            Select::make('supplier_id')
                                ->searchable()
                                ->relationship('supplier', 'name')
                                ->preload()
                                ->required(),
                            DatePicker::make('date')
                                ->default(now())
                                ->required(),
                            TextInput::make('total_price')
                                ->numeric()
                                ->disabled()
                                ->default(0),
                            TextInput::make('total_paid')
                                ->disabled()
                                ->numeric()
                                ->default(0),
                            Select::make('status')
                                ->options(OrderStatusEnum::enumOptions())
                                ->default(OrderStatusEnum::UNPAID->name)
                                ->disabled(),
                            Toggle::make('delivered')
                                ->required()
                                ->disabledOn('create'),
                        ])
                    ]),

                Repeater::make('orderProducts')
                    ->relationship()
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(4)->schema([
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
                Tables\Columns\TextColumn::make('supplier.name')
                    ->sortable()
                    ->searchable()
                    ->label('Supplier'),
                TextColumn::make('order_products_count')
                    ->counts('orderProducts')
                    ->label('# Products')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_paid')
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
                SelectFilter::make('status')
                    ->options(OrderStatusEnum::enumOptions())
                    ->placeholder('All Statuses'),
            ])
            ->actions([
                Tables\Actions\Action::make('Export')
                    ->icon('heroicon-o-download')
                    ->url(fn ($record) => route('export.order', $record->id)),
                Tables\Actions\EditAction::make()
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            SettlementsRelationManager::class,
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
