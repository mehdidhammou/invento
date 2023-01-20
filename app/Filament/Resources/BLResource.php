<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BLResource\Pages;
use App\Filament\Resources\BLResource\RelationManagers;
use App\Models\BL;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                Forms\Components\TextInput::make('order_id'),
                Forms\Components\TextInput::make('number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('date')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_id'),
                Tables\Columns\TextColumn::make('number'),
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
            'index' => Pages\ListBLS::route('/'),
            'create' => Pages\CreateBL::route('/create'),
            'edit' => Pages\EditBL::route('/{record}/edit'),
        ];
    }    
}
