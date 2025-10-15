<?php

namespace App\Filament\Resources\Victims\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class VictimForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('age')
                    ->numeric()
                    ->default(null),
                TextInput::make('gender')
                    ->default(null),
                TextInput::make('contact')
                    ->default(null),
                TextInput::make('location')
                    ->default(null),
                TextInput::make('safe_zone_id')
                    ->numeric()
                    ->default(null),
            ]);
    }
}
