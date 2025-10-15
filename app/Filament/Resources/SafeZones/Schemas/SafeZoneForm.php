<?php

namespace App\Filament\Resources\SafeZones\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SafeZoneForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('gps_lat')
                    ->required()
                    ->numeric(),
                TextInput::make('gps_lng')
                    ->required()
                    ->numeric(),
                TextInput::make('address')
                    ->required(),
                TextInput::make('capacity')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
