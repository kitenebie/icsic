<?php

namespace App\Livewire\News;

use Livewire\Component;
use App\Models\NewsPage as NewsDB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class LatestNews extends Component
{
    public $categories = [
        "World",
        "International",
        "Politics",
        "U.S. Politics",
        "Global Politics",
        "Business",
        "Economy",
        "Markets",
        "Banking",
        "Stock Market",
        "Finance",
        "Investing",
        "Cryptocurrency",
        "Real Estate",
        "Energy",
        "Oil & Gas",
        "Utilities",
        "Startups",
        "Entrepreneurship",
        "Venture Capital",
        "Technology",
        "Gadgets",
        "AI & Machine Learning",
        "Cybersecurity",
        "Data Privacy",
        "Social Media",
        "Internet",
        "Software",
        "Hardware",
        "Mobile",
        "Cloud Computing",
        "E-commerce",
        "Science",
        "Space",
        "Physics",
        "Biology",
        "Environment",
        "Climate Change",
        "Natural Disasters",
        "Conservation",
        "Weather",
        "Health",
        "Mental Health",
        "Healthcare Policy",
        "Medicine",
        "Fitness",
        "Nutrition",
        "Public Health",
        "Diseases",
        "COVID-19",
        "Vaccines",
        "Lifestyle",
        "Fashion",
        "Beauty",
        "Travel",
        "Food & Drink",
        "Home & Garden",
        "Relationships",
        "Parenting",
        "Pets",
        "Education",
        "Higher Education",
        "K-12",
        "Student Life",
        "Scholarships",
        "Entertainment",
        "Movies",
        "TV Shows",
        "Streaming",
        "Music",
        "Celebrities",
        "Theater",
        "Pop Culture",
        "Art & Design",
        "Books",
        "Gaming",
        "Esports",
        "Comics",
        "Sports",
        "Football",
        "Soccer",
        "Basketball",
        "Baseball",
        "Tennis",
        "Olympics",
        "MMA / UFC",
        "Motorsports",
        "Wrestling",
        "Golf",
        "Cricket",
        "Local News",
        "Regional News",
        "Community",
        "Crime",
        "Public Safety",
        "Legal",
        "Courts",
        "Law Enforcement",
        "Human Rights",
        "Immigration",
        "Social Justice",
        "Race & Ethnicity",
        "Gender",
        "Religion",
        "Faith & Spirituality",
        "Culture",
        "Philosophy",
        "Opinion",
        "Editorial",
        "Columns",
        "Letters",
        "Satire",
        "Breaking News",
        "Obituaries",
        "Military",
        "Defense",
        "Terrorism",
        "Security",
        "Surveillance",
        "Government",
        "Infrastructure",
        "Transportation",
        "Labor",
        "Unions",
        "Agriculture",
        "Commodities",
        "Philanthropy",
        "Donations & Aid",
        "Charities",
        "Events",
        "Conferences",
        "Awards",
        "Historical",
        "Anniversaries",
        "Technology Policy",
        "Digital Ethics",
        "Metaverse",
        "Web3",
        "Space Exploration"
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
        return view('livewire.news.latest-news', [
            'latest' => NewsDB::orderByDesc('id')
                ->limit(9)
                ->get()
        ]);
    }
}
