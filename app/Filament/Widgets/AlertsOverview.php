<?php

namespace App\Filament\Widgets;

use App\Models\Alert;
use App\Models\SafeZone;
use App\Models\Victim;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AlertsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Alerts', Alert::count())
                ->description('All flood alerts in system')
                ->descriptionIcon('heroicon-o-bell')
                ->color('danger'),

            Stat::make('Critical Alerts', Alert::where('severity', 'critical')->count())
                ->description('High severity alerts')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('warning'),

            Stat::make('Safe Zones', SafeZone::count())
                ->description('Registered evacuation centers')
                ->descriptionIcon('heroicon-o-home')
                ->color('success'),

            Stat::make('Victims', Victim::count())
                ->description('Affected individuals tracked')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('primary'),
        ];
    }
}
