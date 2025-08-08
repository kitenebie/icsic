<?php

namespace App\Livewire\News;

use Livewire\Component;
use App\Models\NewsPage as NewsDB;

class NewButton extends Component
{
    public function render()
    {
        return view('livewire.news.new-button',[
            'totalNews' => NewsDB::count()
        ]);
    }
}
