<?php

namespace App\Livewire\News;

use Livewire\Component;
use App\Models\NewsPage;
class NavCategory extends Component
{
    
    public function getRelivantTopics()
    {
        $data = NewsPage::select('relevant_topic')->distinct()->get();
        $topics = [];
        foreach ($data as $item) {
            $extract = explode(',', $item->relevant_topic);
            foreach ($extract as $topic) {
                if (!in_array($topic, $topics)) {
                    $topics[] = $topic;
                }
            }
        }
        return array_unique($topics);
    }
    public function render()
    {
        return view('livewire.news.nav-category');
    }
}
