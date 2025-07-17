<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class allUsers extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Number of Padding', '86'),
            Stat::make('Number of admin', '5'),
            Stat::make('Number of Parents', '597'),
            Stat::make('Number of Teachers', '79'),
            Stat::make('Number of Students', '3,000'),
            Stat::make('Number of Rejected', '150'),
        ];
    }
}
