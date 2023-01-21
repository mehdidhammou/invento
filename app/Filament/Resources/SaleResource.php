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
use Filament\Tables\Actions\Action;

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
                                ->preload()
                                ->required(),
                            TextInput::make('total_price')
                                ->disabled()
                                ->required()
                                ->default(0),
                            TextInput::make('total_paid')
                                ->disabled(fn (string $context) => $context === 'create')
                                ->lte('total_price')
                                ->required()
                                ->default(0),
                            TextInput::make('discount')
                                ->disabled(fn (string $context) => $context === 'create')
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
                                ->required(),
                        ])
                    ]),
                Section::make('Sale Products')->schema([
                    Repeater::make('saleProducts')
                        ->relationship()
                        ->columnSpanFull()
                        ->columns(4)
                        ->schema([
                            Select::make('product_id')
                                ->options(Product::pluck('name', 'id'))
                                ->label('Product')
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) {
                                    $latest_price = Product::where('id', $state)->first()->latest_price;
                                    $set('unit_price', $latest_price);
                                }),
                            TextInput::make('quantity')
                                ->required()
                                ->numeric()
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
                        ])
                        ->createItemButtonLabel('+')
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_price')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_paid')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount')
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
            //
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
