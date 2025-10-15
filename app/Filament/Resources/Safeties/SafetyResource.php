<?php

namespace App\Filament\Resources\Safeties;

use App\Filament\Resources\Safeties\Pages\CreateSafety;
use App\Filament\Resources\Safeties\Pages\EditSafety;
use App\Filament\Resources\Safeties\Pages\ListSafeties;
use App\Filament\Resources\Safeties\Schemas\SafetyForm;
use App\Filament\Resources\Safeties\Tables\SafetiesTable;
use App\Models\Safety;
use App\Models\SafetyTip;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SafetyResource extends Resource
{
    protected static ?string $model = SafetyTip::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::ShieldCheck;

    public static function form(Schema $schema): Schema
    {
        return SafetyForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SafetiesTable::configure($table);
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
            'index' => ListSafeties::route('/'),
            'create' => CreateSafety::route('/create'),
            'edit' => EditSafety::route('/{record}/edit'),
        ];
    }
}
