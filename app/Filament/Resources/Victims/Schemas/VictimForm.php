<?php

namespace App\Filament\Resources\Victims\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class VictimForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('name')->required()->maxLength(255),
                Forms\Components\TextInput::make('age')->numeric()->minValue(0),
                Forms\Components\Select::make('gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other',
                    ])
                    ->nullable(),
                Forms\Components\TextInput::make('contact')->tel()->nullable(),
                Forms\Components\TextInput::make('location')->placeholder('Community or landmark name'),

                // 🗺️ Add map picker here
                Forms\Components\ViewField::make('map')
                    ->label('Pick Location on Map')
                    ->view('filament.forms.fields.map-picker')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('latitude')
                    ->label('Latitude')
                    ->readOnly()
                    ->required(),

                Forms\Components\TextInput::make('longitude')
                    ->label('Longitude')
                    ->readOnly()
                    ->required(),

            ]);
    }
}
