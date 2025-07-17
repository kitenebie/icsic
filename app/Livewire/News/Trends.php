<?php

namespace App\Livewire\News;

use Livewire\Component;
use App\Models\NewsPage;

class Trends extends Component
{
    public function render()
    {
        return view('livewire.news.trends',[
        'newsTrends' => NewsPage::orderBy('views', 'desc')->take(4)->get(),
        ]);
    }
}
