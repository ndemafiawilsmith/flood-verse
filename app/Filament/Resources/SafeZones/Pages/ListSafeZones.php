<?php

namespace App\Filament\Resources\SafeZones\Pages;

use App\Filament\Resources\SafeZones\SafeZoneResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSafeZones extends ListRecords
{
    protected static string $resource = SafeZoneResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
