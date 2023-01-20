<?php

namespace App\Filament\Resources\BLResource\Pages;

use App\Filament\Resources\BLResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBLS extends ListRecords
{
    protected static string $resource = BLResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
