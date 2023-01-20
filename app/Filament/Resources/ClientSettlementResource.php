<?php

namespace App\Filament\Resources;

use App\Enums\OrderStatusEnum;
use App\Filament\Resources\ClientSettlementResource\Pages;
use App\Filament\Resources\ClientSettlementResource\RelationManagers;
use App\Models\ClientSettlement;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientSettlementResource extends Resource
{
    protected static ?string $model = ClientSettlement::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('client_id')
                ->relationship('client', 'name'),
                Forms\Components\TextInput::make('amount')
                    ->placeholder('0.00')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                    Select::make('status')->options(OrderStatusEnum::enumOptions())
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('client_id'),
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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageClientSettlements::route('/'),
        ];
    }    
}
