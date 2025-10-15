<?php
namespace App\Filament\Resources\SafeZones\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;

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

                // 🗺️ Map picker
                Forms\Components\ViewField::make('map')
                    ->label('Pick Location on Map')
                    ->view('filament.forms.fields.map-picker')
                    ->columnSpanFull(),

                Forms\Components\TextInput::make('latitude')
                    ->label('Latitude')
                    ->readOnly()
                    ->dehydrated(true)
                    ->required(),

                Forms\Components\TextInput::make('longitude')
                    ->label('Longitude')
                    ->readOnly()
                    ->dehydrated(true)
                    ->required(),

                TextInput::make('address')->required(),
                TextInput::make('capacity')->numeric()->default(null),
            ]);
    }
}
