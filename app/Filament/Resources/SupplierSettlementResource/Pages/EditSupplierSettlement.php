<?php

namespace App\Filament\Resources\SupplierSettlementResource\Pages;

use App\Filament\Resources\SupplierSettlementResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSupplierSettlement extends EditRecord
{
    protected static string $resource = SupplierSettlementResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
