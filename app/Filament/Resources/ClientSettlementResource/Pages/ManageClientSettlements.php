<?php

namespace App\Filament\Resources\ClientSettlementResource\Pages;

use App\Filament\Resources\ClientSettlementResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageClientSettlements extends ManageRecords
{
    protected static string $resource = ClientSettlementResource::class;

    protected function getActions(): array
    {
        return [
        ];
    }
}
