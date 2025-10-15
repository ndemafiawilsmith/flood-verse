<?php

namespace App\Filament\Resources\Safeties\Pages;

use App\Filament\Resources\Safeties\SafetyResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSafety extends EditRecord
{
    protected static string $resource = SafetyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
