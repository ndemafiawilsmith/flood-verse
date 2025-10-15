<?php

namespace App\Filament\Widgets;

use App\Models\Victim;
use Filament\Widgets\ChartWidget;

class VictimsByAgeChart extends ChartWidget
{
    protected ?string $heading = 'Victims By Age';

    protected function getData(): array
    {
        // Define age ranges
        $ageGroups = [
            '0-18' => [0, 18],
            '19-35' => [19, 35],
            '36-60' => [36, 60],
            '61+'   => [61, 120],
        ];

        $counts = [];
        foreach ($ageGroups as $label => [$min, $max]) {
            $counts[] = Victim::whereBetween('age', [$min, $max])->count();
        }

        return [
            'datasets' => [
                [
                    'data' => $counts,
                    'backgroundColor' => [
                        'rgba(54, 162, 235, 0.7)',  // Blue
                        'rgba(255, 99, 132, 0.7)',  // Red
                        'rgba(255, 206, 86, 0.7)',  // Yellow
                        'rgba(75, 192, 192, 0.7)',  // Teal
                    ],
                ],
            ],
            'labels' => array_keys($ageGroups),
        ];
    }

    protected function getType(): string
    {
        return 'pie'; // changed from bar → pie
    }
}
