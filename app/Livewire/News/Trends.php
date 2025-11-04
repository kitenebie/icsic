<?php

namespace App\Livewire\News;

use Livewire\Component;
use App\Models\NewsPage as NewsDB;
use Carbon\Carbon;

class Trends extends Component
{
    public $categories = [
        "School Announcements",
        "Teacher Updates",
        "Student Achievements",
        "Curriculum Changes",
        "School Events",
        "DEPED Policies",
        "Educational Resources",
        "Parent Involvement",
        "School Safety",
        "Academic Programs",
        "Extracurricular Activities",
        "School Administration",
        "Teacher Training",
        "Student Welfare",
        "Educational Technology",
        "School Facilities",
        "Graduation News",
        "Enrollment Information",
        "Scholarship Opportunities",
        "Educational Reforms",
        "School Supplies",
        "Teacher Recruitment",
        "Student Discipline",
        "School Budget",
        "Educational Partnerships",
        "Online Learning",
        "Special Education",
        "School Feeding Program",
        "DepEd Orders",
        "School Calendar"
    ];

    public function formatDateHumanReadable($date)
    {
        $date = Carbon::parse($date);
        $now = Carbon::now();

        $diffInMinutes = $date->diffInMinutes($now);
        $diffInHours = $date->diffInHours($now);
        $diffInDays = $date->diffInDays($now);
        $diffInWeeks = $date->diffInWeeks($now);
        $diffInMonths = $date->diffInMonths($now);

        if ($diffInMonths >= 1) {
            return $date->format('F d, Y'); // e.g. June 03, 2025
        } elseif ($diffInWeeks >= 1) {
            return intval($diffInWeeks) . 'w';
        } elseif ($diffInDays >= 1) {
            return intval($diffInDays) . 'd ago';
        } elseif ($diffInHours >= 1) {
            return intval($diffInHours) . 'h ago';
        } elseif ($diffInMinutes >= 1) {
            return intval($diffInMinutes) . 'm ago';
        } else {
            return 'Just now';
        }
    }

    public function render()
    {
        // Get trending news based on most visited/read articles in the last 30 days
        $trendingNews = NewsDB::where('created_at', '>=', now()->subDays(30))
            ->withCount('views')
            ->having('views_count', '>', 0) // Only include articles with views
            ->orderByDesc('views_count')
            ->limit(10)
            ->get();

        return view('livewire.news.trends', [
            'trendingNews' => $trendingNews
        ]);
    }
}
