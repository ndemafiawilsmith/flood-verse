<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Alert;
use App\Models\SafeZone;

class FloodAnalytics extends Page
{
    protected  string $view = 'filament.pages.flood-analytics';

    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-chart-bar';
    protected static string|null|\UnitEnum $navigationGroup = 'Analytics';
    protected static string|null $title = 'Flood Analytics';

    public array $stats = [];
    public $alerts;
    public $safeZones;

    public function mount(): void
    {
        $this->alerts = Alert::all();
        $this->safeZones = SafeZone::all();

        $this->stats = [
            'total_alerts'    => Alert::count(),
            'critical_alerts' => Alert::where('severity', 'critical')->count(),
            'safe_zones'      => SafeZone::count(),
        ];
    }
}
