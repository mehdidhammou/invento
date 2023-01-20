<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierSettlementResource\Pages;
use App\Filament\Resources\SupplierSettlementResource\RelationManagers;
use App\Models\SupplierSettlement;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SupplierSettlementResource extends Resource
{
    protected static ?string $model = SupplierSettlement::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-check';

    protected static ?string $navigationGroup = 'Settlements';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('supplier_id'),
                Forms\Components\TextInput::make('amount')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('supplier_id'),
                Tables\Columns\TextColumn::make('amount'),
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
