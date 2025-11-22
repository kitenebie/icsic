<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;

class allUsers extends BaseWidget
{
    protected function getStats(): array
    {
        // Get current authenticated user
        $currentUser = \Filament\Facades\Filament::auth()->user();

        // Base query for filtering
        $query = User::query();

        // Apply role-based filtering for teachers
        if ($currentUser && $currentUser->role === 'teacher') {
            $query->where('grade', $currentUser->grade)
                  ->where('section', $currentUser->section);
        }

        // Get dynamic counts from database with filtering
        $pendingCount = User::where('role', 'pending')->count();
        $adminCount = User::where('role', 'admin')->count();
        $parentCount = User::where('role', 'parent')->count();
        $teacherCount = User::where('role', 'teacher')->count();
        $studentCount = User::where('role', 'student')->count();
        $rejectedCount = User::where('role', 'rejected')->count();
        $StaffCount = User::where('role', 'staff')->count();
        $GradCount = User::where('role', 'staff')->count();

        return [
            Stat::make('Number of Pending', number_format($pendingCount))
                ->description('Users awaiting approval')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Number of Admin', number_format($adminCount))
                ->description('System administrators')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('danger'),

            Stat::make('Number of Teachers', number_format($teacherCount))
                ->description('Teachers accounts')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),
            Stat::make('Number of Sraff', number_format($teacherCount))
                ->description('Staff accounts')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info'),

            Stat::make('Number of Parents', number_format($parentCount))
                ->description('Parent accounts')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('success'),

            Stat::make('Number of Students', number_format($studentCount))
                ->description('Student accounts')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Number of Alumni', number_format($GradCount))
                ->description('Alumni accounts')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Number of Rejected', number_format($rejectedCount))
                ->description('Rejected applications')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('gray'),
        ];
    }
}
