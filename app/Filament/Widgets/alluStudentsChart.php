<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\User;

class alluStudentsChart extends ChartWidget
{
    protected static ?string $heading = 'User Population by Role';

    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 2,
    ];

    protected function getData(): array
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
        $pendingCount = (clone $query)->where('role', 'pending')->count();
        $adminCount = (clone $query)->where('role', 'admin')->count();
        $parentCount = (clone $query)->where('role', 'parent')->count();
        $teacherCount = (clone $query)->where('role', 'teacher')->count();
        $studentCount = (clone $query)->where('role', 'student')->count();
        $gradCount = (clone $query)->where('role', 'graduate')->count();
        $staff = (clone $query)->where('role', 'staff')->count();
        $rejectedCount = (clone $query)->where('role', 'rejected')->count();

        return [
            'datasets' => [
                [
                    'label' => 'User Count',
                    'data' => [$pendingCount, $adminCount, $parentCount, $teacherCount, $staff, $studentCount, $gradCount, $rejectedCount],
                    'backgroundColor' => [
                        '#f59e0b', // Pending - amber
                        '#dc2626', // Admin - red
                        '#22c55e', // Parents - green
                        '#06b6d4', // Teachers - cyan
                        '#063DD4FF', // Teachers - cyan
                        '#B23BF6FF', // Students - blue
                        '#F63B83FF', // Students - blue
                        '#6b7280', // Rejected - gray
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
                'Staff',
                'Students',
                'Graduates',
                'Rejected',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'enabled' => true,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],
            'responsive' => true,
            'maintainAspectRatio' => false,
        ];
    }

    public function getDescription(): ?string
    {
        // Get current authenticated user
        $currentUser = \Filament\Facades\Filament::auth()->user();

        // Base query for filtering
        $query = User::query();

        // Apply role-based filtering for teachers
        if ($currentUser && $currentUser->role === 'teacher') {
            $query->where('grade', $currentUser->grade)
                  ->where('section', $currentUser->section);
            $totalUsers = $query->count();
            return "Total users in Grade {$currentUser->grade}, Section {$currentUser->section}: {$totalUsers} | Updated: " . now()->format('M d, Y H:i');
        }

        $totalUsers = $query->count();
        return "Total users: {$totalUsers} | Updated: " . now()->format('M d, Y H:i');
    }

    public function getColumnSpan(): string | array | int
    {
        return [
            'md' => 2,
            'xl' => 3,
        ];
    }
}
