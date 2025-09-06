<?php

namespace App\Livewire\News;

use Livewire\Component;
use App\Models\NewsPage as NewsDB;
use Carbon\Carbon;

class News extends Component
{
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
        // Get featured news (latest 3 articles)
        $featuredNews = NewsDB::orderByDesc('id')
            ->limit(3)
            ->get();

        // Get trending topics based on most viewed/read articles in the last 7 days
        $trendingTopics = NewsDB::where('created_at', '>=', now()->subDays(7))
            ->orderByDesc('views')
            ->limit(6)
            ->get()
            ->map(function($news) {
                return $this->categories[$news->topic_category];
            })
            ->unique()
            ->values();

        return view('livewire.news.news', [
            'featuredNews' => $featuredNews,
            'trendingTopics' => $trendingTopics
        ]);
    }

    public function getLikesCount($newsId)
    {
        return \App\Models\newsLikes::where('post_id', $newsId)->count();
    }

    public function getCommentsCount($newsId)
    {
        return \App\Models\newsComment::where('post_id', $newsId)->count();
    }

    public function getViewsCount($newsId)
    {
        $news = NewsDB::find($newsId);
        return $news ? $news->views : 0;
    }
}
