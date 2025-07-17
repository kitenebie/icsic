<?php

namespace App\Livewire\News;

use Livewire\Component;
use App\Models\newsLikes as NewsLD;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class LikeDislike extends Component
{

    public $commentId;
    public $isDislike = false;
    public $isLike = false;
    public function mount($commentId)
    {
        $this->commentId = $commentId;
        $user = NewsLD::where('user_id', Auth::id())->where('news_id', $this->commentId)->first();
        if ($user) {
            $this->isDislike = $user->is_disliked;
            $this->isLike = $user->is_liked;
        }
    }
    public function toggleDislike()
    {
        $user = NewsLD::where('user_id', Auth::id())->where('news_id', $this->commentId)->first();
        $this->isDislike = true;
        $this->isLike = false;
        if (!$user) {
            return NewsLD::create([
                'is_liked' => false,
                'user_id' => Auth::id(),
                'news_id' => $this->commentId,
                'is_disliked' => true
            ]);
        } else {
            return NewsLD::where('user_id', Auth::id())
                ->where('news_id', $this->commentId)
                ->update([
                    'is_liked' => false,
                    'is_disliked' => true
                ]);
        }
    }
    public function toggleLike()
    {
        $user = NewsLD::where('user_id', Auth::id())->where('news_id', $this->commentId)->first();
        $this->isDislike = false;
        $this->isLike = true;
        if (!$user) {
            return NewsLD::create([
                'is_liked' => true,
                'user_id' => Auth::id(),
                'news_id' => $this->commentId,
                'is_disliked' => false
            ]);
        } else {
            return NewsLD::where('user_id', Auth::id())
                ->where('news_id', $this->commentId)
                ->update([
                    'is_liked' => true,
                    'is_disliked' => false
                ]);
        }
    }
    public function LikeCounts()
    {
        return NewsLD::where('news_id', $this->commentId)->where('is_liked', true)->count();
    }
    public function DislikeCounts()
    {
        return NewsLD::where('news_id', $this->commentId)->where('is_disliked', true)->count();
    }
    public function render()
    {
        return view('livewire.news.like-dislike');
    }
}
