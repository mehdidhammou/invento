<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Pages\Actions;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\OrderResource;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('Export Invoice')
                ->icon('heroicon-o-download')
                ->url(fn () => route('export.invoice', $this->record->id)),
            Action::make('Export Bill  of lading')
                ->icon('heroicon-o-download')
                ->url(fn ($record) => route('export.bl', $this->record->id)),
            Actions\DeleteAction::make(),
        ];
    }
}
