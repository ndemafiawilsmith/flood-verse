<?php

namespace App\Filament\Resources\SafeZones;

use App\Filament\Resources\SafeZones\Pages\CreateSafeZone;
use App\Filament\Resources\SafeZones\Pages\EditSafeZone;
use App\Filament\Resources\SafeZones\Pages\ListSafeZones;
use App\Filament\Resources\SafeZones\Schemas\SafeZoneForm;
use App\Filament\Resources\SafeZones\Tables\SafeZonesTable;
use App\Models\SafeZone;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SafeZoneResource extends Resource
{
    protected static ?string $model = SafeZone::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ShieldCheck;

    public static function form(Schema $schema): Schema
    {
        return SafeZoneForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SafeZonesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSafeZones::route('/'),
            'create' => CreateSafeZone::route('/create'),
            'edit' => EditSafeZone::route('/{record}/edit'),
        ];
    }
}
