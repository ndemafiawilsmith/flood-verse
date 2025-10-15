<?php

namespace App\Filament\Resources\Victims\Pages;

use App\Filament\Resources\Victims\VictimResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListVictims extends ListRecords
{
    protected static string $resource = VictimResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
