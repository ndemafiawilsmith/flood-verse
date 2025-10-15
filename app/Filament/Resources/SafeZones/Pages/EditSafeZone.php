<?php

namespace App\Filament\Resources\SafeZones\Pages;

use App\Filament\Resources\SafeZones\SafeZoneResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSafeZone extends EditRecord
{
    protected static string $resource = SafeZoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
