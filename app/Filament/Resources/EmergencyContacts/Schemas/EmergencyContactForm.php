<?php

namespace App\Filament\Resources\EmergencyContacts\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class EmergencyContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('phone')
                    ->tel()
                    ->required(),
                TextInput::make('role')
                    ->required(),
                TextInput::make('location')
                    ->default(null),
            ]);
    }
}
