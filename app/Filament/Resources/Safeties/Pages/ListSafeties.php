<?php

namespace App\Filament\Resources\Safeties\Pages;

use App\Filament\Resources\Safeties\SafetyResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSafeties extends ListRecords
{
    protected static string $resource = SafetyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
