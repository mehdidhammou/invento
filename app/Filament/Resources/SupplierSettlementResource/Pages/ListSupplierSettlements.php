<?php

namespace App\Filament\Resources\SupplierSettlementResource\Pages;

use App\Filament\Resources\SupplierSettlementResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSupplierSettlements extends ListRecords
{
    protected static string $resource = SupplierSettlementResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
