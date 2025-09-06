<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;

class allUsers extends BaseWidget
{
    protected function getStats(): array
    {
        // Get dynamic counts from database
        $pendingCount = User::where('status', 'pending')->count();
        $adminCount = User::where('role', 'admin')->count();
        $parentCount = User::where('role', 'parent')->count();
        $teacherCount = User::where('role', 'teacher')->count();
        $studentCount = User::where('role', 'student')->count();
        $rejectedCount = User::where('status', 'rejected')->count();

        return [
            Stat::make('Number of Pending', number_format($pendingCount))
                ->description('Users awaiting approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Number of Admin', number_format($adminCount))
                ->description('System administrators')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('danger'),

            Stat::make('Number of Parents', number_format($parentCount))
                ->description('Parent accounts')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Number of Teachers', number_format($teacherCount))
                ->description('Teaching staff')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),

            Stat::make('Number of Students', number_format($studentCount))
                ->description('Student accounts')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Number of Rejected', number_format($rejectedCount))
                ->description('Rejected applications')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('gray'),
        ];
    }
}
