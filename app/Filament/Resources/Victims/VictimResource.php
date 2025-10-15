<?php

namespace App\Filament\Resources\Victims;

use App\Filament\Resources\Victims\Pages\CreateVictim;
use App\Filament\Resources\Victims\Pages\EditVictim;
use App\Filament\Resources\Victims\Pages\ListVictims;
use App\Filament\Resources\Victims\Schemas\VictimForm;
use App\Filament\Resources\Victims\Tables\VictimsTable;
use App\Models\Victim;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VictimResource extends Resource
{
    protected static ?string $model = Victim::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Victim';

    public static function form(Schema $schema): Schema
    {
        return VictimForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VictimsTable::configure($table);
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
            'index' => ListVictims::route('/'),
            'create' => CreateVictim::route('/create'),
            'edit' => EditVictim::route('/{record}/edit'),
        ];
    }
}
