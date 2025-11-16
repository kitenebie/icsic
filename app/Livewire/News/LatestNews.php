<?php

namespace App\Livewire\News;

use Livewire\Component;
use App\Models\NewsPage as NewsDB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LatestNews extends Component
{
    public $selectedCategory = null;

    protected $listeners = ['categorySelected' => 'setCategory'];

    public function setCategory($category)
    {
        $this->selectedCategory = $category;
    }

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
        $query = NewsDB::orderByDesc('id');

        if ($this->selectedCategory && $this->selectedCategory !== 'All') {
            $query->where('relevant_topic', 'like', '%' . $this->selectedCategory . '%');
        }

        $latestNews = $query->limit(9)->get();

        // Get trending topics based on most viewed/read articles in the last 7 days
        $trendingTopics = NewsDB::where('created_at', '>=', now()->subDays(7))
            ->withCount('views')
            ->orderByDesc('views_count')
            ->limit(5)
            ->get()
            ->map(function($news) {
                return $this->categories[$news->topic_category];
            })
            ->unique()
            ->values();

        return view('livewire.news.latest-news', [
            'latest' => $latestNews,
            'trendingTopics' => $trendingTopics
        ]);
    }

    public function getRelatedArticles($currentNewsId, $category)
    {
        return NewsDB::where('topic_category', $category)
            ->where('id', '!=', $currentNewsId)
            ->withCount('views')
            ->orderByDesc('views_count')
            ->limit(3)
            ->get();
    }

    public function getLikesCount($newsId)
    {
        return \App\Models\newsLikes::where('news_id', $newsId)->count();
    }

    public function getCommentsCount($newsId)
    {
        return \App\Models\newsComment::where('post_id', $newsId)->count();
    }

    public function getViewsCount($newsId)
    {
        $news = NewsDB::find($newsId);
        return $news ? $news->views_count : 0;
    }
}
