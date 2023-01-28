<?php

namespace App\Filament\Resources;

use App\Models\BL;
use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Supplier;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BLResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BLResource\RelationManagers;
use App\Filament\Resources\BLResource\RelationManagers\OrderRelationManager;

class BLResource extends Resource
{
    protected static ?string $model = BL::class;

    protected static ?string $label = 'Bills Of Lading';

    protected static ?string $navigationGroup = 'Documents';

    protected static ?string $navigationIcon = 'heroicon-o-document-add';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('supplier_id')
                    ->options(Supplier::pluck('name', 'id'))
                    ->reactive()
                    ->searchable()
                    ->preload()
                    ->required()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('order_id', null);
                    }),
                Forms\Components\Select::make('order_id')
                    ->options(function (callable $get) {
                        if ($get('supplier_id')) {
                            return Order::where('supplier_id', $get('supplier_id')->where('delivered', 1))
                                ->pluck('date', 'id');
                        }
                    })
                    ->required(),
                Forms\Components\TextInput::make('number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date')
                    ->default(now())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.supplier.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('order.date')
                    ->sortable()
                    ->label('Order Date'),
                Tables\Columns\TextColumn::make('number')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('date')
                    ->sortable()
                    ->date(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->since(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->since(),
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
            OrderRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBLS::route('/'),
            'create' => Pages\CreateBL::route('/create'),
            'edit' => Pages\EditBL::route('/{record}/edit'),
        ];
    }
}
