<?php

namespace App\Livewire\News;

use Livewire\Component;

class RecentlyFeatured extends Component
{
    public function render()
    {
        $featuredNews = \App\Models\NewsPage::where('remarks', 'featured')
            ->latest()
            ->take(4)
            ->get();

        return view('livewire.news.recently-featured', [
            'featured' => $featuredNews,
        ]);
    }
}
