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
use Livewire\Attributes\On;
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
        // Log comment submission attempt
        Log::info('Comment submission attempt started', [
            'user_id' => Auth::id(),
            'comment_type' => $this->CommentType,
            'post_id' => $this->id,
            'comment_post_id' => $this->commentPostId ?? null,
            'comment_id' => $this->commentID ?? null,
        ]);

        // Authentication check
        if (!Auth::check()) {
            Log::warning('Comment submission failed: User not authenticated');
            Notification::make()
                ->title('Authentication Error')
                ->body('You must be logged in to comment.')
                ->danger()
                ->send();
            return;
        }

        $commentText = trim($this->comment_input ?? '');
        
        // Input validation
        if (empty($commentText)) {
            Log::info('Comment submission aborted: Empty comment text');
            return;
        }

        if (strlen($commentText) > 10000) {
            Log::warning('Comment submission failed: Text too long', ['length' => strlen($commentText)]);
            Notification::make()
                ->title('Comment Too Long')
                ->body('Comments must be less than 10,000 characters.')
                ->warning()
                ->send();
            return;
        }

        // XSS Protection
        $commentText = strip_tags($commentText);

        try {
            if ($this->CommentType == "reply") {
                // Validate reply data
                if (empty($this->commentPostId) || empty($this->commentID)) {
                    Log::warning('Reply comment submission failed: Missing reply data', [
                        'comment_post_id' => $this->commentPostId,
                        'comment_id' => $this->commentID
                    ]);
                    return;
                }

                // Verify parent comment exists
                $parentComment = CommentDB::find($this->commentID);
                if (!$parentComment) {
                    Log::warning('Reply comment submission failed: Parent comment not found', [
                        'parent_comment_id' => $this->commentID
                    ]);
                    Notification::make()
                        ->title('Invalid Reply')
                        ->body('The comment you are replying to no longer exists.')
                        ->warning()
                        ->send();
                    return;
                }

                // Verify announcement exists
                $announcement = AnnouncementDB::find($this->commentPostId);
                if (!$announcement) {
                    Log::warning('Reply comment submission failed: Announcement not found', [
                        'announcement_id' => $this->commentPostId
                    ]);
                    Notification::make()
                        ->title('Invalid Post')
                        ->body('The announcement you are commenting on no longer exists.')
                        ->warning()
                        ->send();
                    return;
                }
                
                $data = [
                    'post_id' => $this->commentPostId,
                    'commentatorId' => Auth::user()->id,
                    'type' => $this->CommentType,
                    'reply_to' => $this->commentID,
                    'comment' => $commentText
                ];
                
                Log::info('Creating reply comment', $data);
                CommentDB::create($data);
                
                $this->mentionedName = "/";
                $this->CommentType = "main";
                $this->comment_input = '';
                $this->commentID = null;
                $this->commentPostId = null;
                $this->commentatorId = null;
                
            } else {
                // Validate main comment data
                if (empty($this->id)) {
                    Log::warning('Main comment submission failed: Missing post ID');
                    return;
                }

                // Verify announcement exists
                $announcement = AnnouncementDB::find($this->id);
                if (!$announcement) {
                    Log::warning('Main comment submission failed: Announcement not found', [
                        'announcement_id' => $this->id
                    ]);
                    Notification::make()
                        ->title('Invalid Post')
                        ->body('The announcement you are commenting on no longer exists.')
                        ->warning()
                        ->send();
                    return;
                }
                    
                $data = [
                    'post_id' => $this->id,
                    'commentatorId' => Auth::user()->id,
                    'type' => $this->CommentType,
                    'reply_to' => null,
                    'comment' => $commentText
                ];
                
                Log::info('Creating main comment', $data);
                CommentDB::create($data);
                
                $this->mentionedName = "/";
                $this->comment_input = '';
            }

            Log::info('Comment created successfully');
            
            // Success notification
            Notification::make()
                ->title('Comment Posted')
                ->body('Your comment has been posted successfully.')
                ->success()
                ->send();
            
        } catch (\Exception $e) {
            Log::error('Comment submission database error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'data' => $data ?? null
            ]);
            
            Notification::make()
                ->title('Save Error')
                ->body('Unable to save your comment. Please try again.')
                ->danger()
                ->send();
                
            return;
        }
        
        // Refresh comments list
        try {
            $this->MainCommentData = CommentDB::where('post_id', $this->id)->where('type', 'main')->get();
            Log::info('Comments list refreshed successfully');
        } catch (\Exception $e) {
            Log::error('Failed to refresh comments list', [
                'error' => $e->getMessage(),
                'post_id' => $this->id
            ]);
            $this->MainCommentData = [];
        }
        
        $this->dispatch('clear-comment-input');
    }

    public $voilateWords = null, $mentionedUser;
    public function checkWithAi()
    {
        return false;//remove if ai is actiVE
        $rawComment = $this->mentionedUser . ' ' . $this->comment_input;
        $openRouterService = new OpenRouterService();
        $aiReply = $openRouterService->ask($rawComment);
        preg_match_all('/\*(.*?)\*/', $aiReply, $matches);
        $offensiveWords = $matches[1] ?? [];
        // dd($offensiveWords);
        if (!empty($offensiveWords)) {
            $this->voilateWords = $offensiveWords;
            $this->comment_input = null;
            return true;
        }
        return false;
    }


    #[On('post-created')]
    public function handleNewPost($refreshPosts)
    {
        Session::put('screen', $refreshPosts);
    }
    
    public function closeComment()
    {
        // Dispatch event to parent component to close modal
        $this->dispatch('closeCommentModal');
    }

    public function Author($id)
    {
        $user = User::where('id', $id)->first();
        return $user ? $user?->FirstName . " " . $user?->LastName . " " . $user?->MiddleName . " " . $user?->extension_name : "ICSIS User";
    }
    public function render()
    {
        return view('livewire.announcement.comments', [
            "main_comments" => $this->MainCommentData,
        ]);
    }
}
