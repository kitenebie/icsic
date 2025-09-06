<?php

namespace App\Livewire\Announcement;

use Livewire\Component;
use App\Models\Announcement as AnnouncementDB;
use App\Models\announcementReacts as React;
use App\Models\announcementComment as CommentDB;
use App\Models\User;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use App\Services\OpenRouterService;

class Comments extends Component
{
    public $announcementID = null;
    public bool $disableLoadComments = false;
    public $isNotSmallMidium = true;

    public $id;
    public $closeCommentModal = false;
    
    public function reply_comments($id, $commentatorId, $replyID, $name)
    {
        return CommentDB::where('post_id', $id)->where('reply_to', $replyID)->where('type', 'reply')->get();
    }
    
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
            return $date->format('F d, Y');
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
    
    public function emojies_react($post_id, $type)
    {
        return React::where('post_id', $post_id)->where('type', $type)->groupBy('react')->get('react');
    }
    
    public function total_reacts($post_id, $type)
    {
        $reactNum = React::where('post_id', $post_id)->where('type', $type)->count();
        return  $reactNum > 0 ? $reactNum : "";
    }
    
    public function current_react($post_id, $type)
    {
        $post = React::where('user_id', Auth::user()->id)->where('post_id', $post_id)->where('type', $type);
        if ($post->first()) {
            return "/build/img/" . strtolower($post->first()->react) . ".png";
        }
        return "";
    }
    
    public function react($react, $id, $type)
    {
        $post = React::where('user_id', Auth::user()->id)->where('post_id', $id)->where('type', $type);
        if ($post->first()) {
            if (strtolower($post->first()->react)  != strtolower($react)) {
                return $post->update([
                    'react' => $react,
                ]);
            }
            return $post->delete();
        }
        return React::create([
            'user_id' => Auth::user()->id,
            'post_id' => $id,
            'type' => $type,
            'react' => $react,
            'count' =>  1,
        ]);
    }
    
    public $MainCommentData;
    
    public function mount($id = null)
    {
        $this->id = $id ?? Session::get('comment');
        $this->isNotSmallMidium = Session::get('screen', true);
        try {
            $this->MainCommentData = CommentDB::where('post_id', $this->id)->where('type', 'main')->get();
        } catch (\Exception $e) {
            $this->MainCommentData = [];
        }
    }
    
    public function update()
    {
        $this->id = Session::get('comment');
        try {
            $this->MainCommentData = CommentDB::where('post_id', $this->id)->where('type', 'main')->get();
        } catch (\Exception $e) {
            $this->MainCommentData = [];
        }
    }

    public $mentionedName = "/";
    public $CommentType = 'main';
    public $commentID, $commentPostId, $commentatorId;
    
    public function replay_comment($id, $post_id, $commentatorId)
    {
        $this->commentID = $id;
        $this->commentPostId = $post_id;
        $this->CommentType = 'reply';
        $this->commentatorId = $commentatorId;
        return $this->mentionedName = "@" . $this->Author($commentatorId);
    }
    
    public $comment_input = '';
    
    public function submit_comment()
    {
        $commentText = trim($this->comment_input ?? '');
        
        Log::info('Comment submission attempt', [
            'comment_input' => $this->comment_input,
            'trimmed' => $commentText,
            'empty_check' => empty($commentText),
            'CommentType' => $this->CommentType
        ]);
        
        if (empty($commentText)) {
            Notification::make()
                ->title('Comment cannot be empty')
                ->warning()
                ->send();
            return;
        }

        if ($this->CommentType == "reply") {
            if (empty($this->commentPostId) || empty($this->commentID)) {
                Notification::make()
                    ->title('Invalid reply data')
                    ->warning()
                    ->send();
                return;
            }
            
            $isValid = $this->checkWithAi();
            if ($isValid) {
                $this->comment_input = '';
                return;
            }

            $data = [
                'post_id' => $this->commentPostId,
                'commentatorId' => Auth::user()->id,
                'type' => $this->CommentType,
                'reply_to' => $this->commentID,
                'comment' => $commentText
            ];
            
            try {
                CommentDB::create($data);
                
                Notification::make()
                    ->title('Reply posted successfully')
                    ->success()
                    ->send();
            } catch (\Exception $e) {
                Log::error('Failed to create reply comment', [
                    'error' => $e->getMessage(),
                    'data' => $data
                ]);
                
                Notification::make()
                    ->title('Failed to post reply')
                    ->danger()
                    ->send();
                return;
            }
            
            $this->mentionedName = "/";
            $this->CommentType = "main";
            $this->comment_input = '';
            $this->commentID = null;
            $this->commentPostId = null;
            $this->commentatorId = null;
            
        } else {
            if (empty($this->id)) {
                Notification::make()
                    ->title('Invalid post data')
                    ->warning()
                    ->send();
                return;
            }
            
            $isValid = $this->checkWithAi();
            if ($isValid) {
                $this->comment_input = '';
                return;
            }
                
            $data = [
                'post_id' => $this->id,
                'commentatorId' => Auth::user()->id,
                'type' => $this->CommentType,
                'reply_to' => null,
                'comment' => $commentText
            ];
            
            try {
                CommentDB::create($data);
                
                Notification::make()
                    ->title('Comment posted successfully')
                    ->success()
                    ->send();
            } catch (\Exception $e) {
                Log::error('Failed to create main comment', [
                    'error' => $e->getMessage(),
                    'data' => $data
                ]);
                
                Notification::make()
                    ->title('Failed to post comment')
                    ->danger()
                    ->send();
                return;
            }
            
            $this->mentionedName = "/";
            $this->comment_input = '';
        }
        
        try {
            $this->MainCommentData = CommentDB::where('post_id', $this->id)->where('type', 'main')->get();
        } catch (\Exception $e) {
            $this->MainCommentData = [];
        }
        
        $this->dispatch('clear-comment-input');
    }

    public $voilateWords = null, $mentionedUser;
    
    public function checkWithAi()
    {
        return false;
    }

    public function closeComment()
    {
        $this->dispatch('closeCommentModal');
    }

    public function Author($id)
    {
        $user = User::where('id', $id)->first();
        return $user ? $user->FirstName . " " . $user->LastName . " " . $user->MiddleName . " " . $user->extension_name : "ICSIS User";
    }
    
    public function render()
    {
        return view('livewire.announcement.comments', [
            "main_comments" => $this->MainCommentData,
        ]);
    }
}
