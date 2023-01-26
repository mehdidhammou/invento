<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use Filament\Resources\Form;
use Filament\Resources\Table;
use App\Enums\OrderStatusEnum;
use PhpParser\Node\Stmt\Label;
use Barryvdh\DomPDF\Facade\Pdf;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput\Mask;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;
use Filament\Forms\Components\Actions\Modal\Actions\Action;
use Filament\Forms\Components\Hidden;

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
                            TextInput::make('total_price')
                                ->required()
                                ->numeric()
                                ->disabled()
                                ->default(0),
                            TextInput::make('total_paid')
                                ->disabledOn('create')
                                ->numeric()
                                ->required()
                                ->lte('total_price')
                                ->default(0),
                            TextInput::make('discount')
                                ->default(0)
                                ->required()
                                ->minValue(0)
                                ->maxValue(100)
                                ->numeric(),
                            DatePicker::make('date')
                                ->default(now())
                                ->required(),
                            Select::make('status')
                                ->options(OrderStatusEnum::enumOptions())
                                ->default(OrderStatusEnum::PENDING->name)
                                ->disabledOn('create')
                                ->required(),
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
                Tables\Columns\TextColumn::make('total_price')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_paid')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount')
                    ->sortable(),
                Tables\Columns\TextColumn::make('date')
                    ->sortable(),
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
            //
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
