<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class alluStudentsChart extends ChartWidget
{
    protected static ?string $heading = 'User Population by Role';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 2,
    ];

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'User Count',
                    'data' => [86, 5, 597, 79, 3000, 150], // Pending, Admin, Parents, Teachers, Students
                    'backgroundColor' => [
                        '#f59e0b', // Pending - amber
                        '#1e40af', // Admin - dark blue
                        '#22c55e', // Parents - green
                        '#06b6d4', // Teachers - cyan
                        '#3b82f6', // Students - blue
                    ],
                    'borderColor' => '#1f2937', // Consistent dark border
                    'borderWidth' => 2,
                ],
            ],
            'labels' => [
                'Pending',
                'Admin',
                'Parents',
                'Teachers',
                'Students',
                'Rejected',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
