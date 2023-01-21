<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Supplier;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use App\Models\SupplierSettlement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\SupplierSettlementResource\Pages;
use App\Filament\Resources\SupplierSettlementResource\RelationManagers;

class SupplierSettlementResource extends Resource
{
    protected static ?string $model = SupplierSettlement::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-check';

    protected static ?string $navigationGroup = 'Settlements';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('supplier_id')
                    ->relationship('supplier', 'name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->default(0)
                    ->disabled(fn (string $context) => $context === 'create')
                    ->numeric()
                    ->maxValue(function (string $context, callable $get) {
                        if ($context == 'create') {
                            return 0;
                        } else {
                            return Supplier::find($get("supplier_id"))->balance;
                        }
                    })
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->default(now())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('DZD', true),
                Tables\Columns\TextColumn::make('date')
                    ->date(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSupplierSettlements::route('/'),
            'create' => Pages\CreateSupplierSettlement::route('/create'),
            'edit' => Pages\EditSupplierSettlement::route('/{record}/edit'),
        ];
    }
}
