<?php

namespace App\Livewire\Announcement;

use Livewire\Component;
use App\Models\Announcement as AnnouncementDB;
use App\Models\announcementReacts as React;
use App\Models\announcementComment as CommentDB;
use App\Models\User;
use App\Models\ReportComments;
use Carbon\Carbon;
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

    // Do NOT override Livewire's internal $id property; use $postId instead
    public $postId;
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
        if (!Auth::check()) {
            return;
        }

        $normalized = ucfirst(strtolower(trim($react)));

        $query = React::where('user_id', Auth::id())
            ->where('post_id', $id)
            ->where('type', $type);

        $existing = $query->first();

        if ($existing) {
            if (strtolower($existing->react) !== strtolower($normalized)) {
                $query->update(['react' => $normalized]);
            } else {
                $query->delete();
            }
        } else {
            React::create([
                'user_id' => Auth::id(),
                'post_id' => $id,
                'type' => $type,
                'react' => $normalized,
                'count' => 1,
            ]);
        }
    }
    public $MainCommentData;
    public function mount($id = null)
    {
        $this->postId = $id ?? Session::get('comment');
        $this->isNotSmallMidium = Session::get('screen', true);
        try {
            $this->MainCommentData = CommentDB::where('post_id', $this->postId)->where('type', 'main')->get();
        } catch (\Exception $e) {
            $this->MainCommentData = [];
        }
    }
    public function update()
    {
        $this->postId = Session::get('comment');
        try {
            $this->MainCommentData = CommentDB::where('post_id', $this->postId)->where('type', 'main')->get();
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
        // Check if user is authenticated
        if (!Auth::check()) {
            return;
        }

        $commentText = trim($this->comment_input ?? '');
        
        if (empty($commentText)) {
            return;
        }

        try {
            if ($this->CommentType == "reply") {
                if (empty($this->commentPostId) || empty($this->commentID)) {
                    return;
                }
                
                $data = [
                    'post_id' => $this->commentPostId,
                    'commentatorId' => Auth::user()->id,
                    'type' => $this->CommentType,
                    'reply_to' => $this->commentID,
                    'comment' => $commentText
                ];
                
                $comment = CommentDB::create($data);
                
                if ($comment && $comment->id) {
                    Log::info('Reply comment saved successfully', ['comment_id' => $comment->id]);
                        
                    $this->mentionedName = "/";
                    $this->CommentType = "main";
                    $this->comment_input = '';
                    $this->commentID = null;
                    $this->commentPostId = null;
                    $this->commentatorId = null;
                } else {
                    throw new \Exception('Failed to create reply comment');
                }
                
            } else {
                if (empty($this->postId)) {
                    $this->postId = Session::get('comment');
                }
                if (empty($this->postId)) {
                    Log::warning('Main comment submission aborted: Missing postId after fallback');
                    return;
                }
                    
                $data = [
                    'post_id' => $this->postId,
                    'commentatorId' => Auth::user()->id,
                    'type' => $this->CommentType,
                    'reply_to' => null,
                    'comment' => $commentText
                ];
                
                Log::info('Attempting to save main comment', ['data' => $data]);
                $comment = CommentDB::create($data);
                
                if ($comment && $comment->id) {
                    Log::info('Main comment saved successfully', ['comment_id' => $comment->id]);
                        
                    $this->mentionedName = "/";
                    $this->comment_input = '';
                } else {
                    throw new \Exception('Failed to create main comment');
                }
            }

            // Refresh comments list to show the new comment
            $this->refreshComments();
            
        } catch (\Exception $e) {
            Log::error('Comment submission failed', [
                'error' => $e->getMessage(),
                'user_id' => Auth::user()->id,
                'data' => $data ?? []
            ]);
        }
        
        $this->dispatch('clear-comment-input');
    }

    /**
     * Refresh the comments list
     */
    public function refreshComments()
    {
        try {
            $pid = $this->postId ?? null;
            if (empty($pid)) {
                $pid = Session::get('comment');
            }
            if (empty($pid)) {
                Log::warning('refreshComments skipped: missing postId');
                $this->MainCommentData = [];
                return;
            }

            $this->MainCommentData = CommentDB::where('post_id', $pid)
                ->where('type', 'main')
                ->orderBy('created_at', 'desc')
                ->get();

            Log::info('Comments refreshed successfully', ['post_id' => $pid]);
        } catch (\Exception $e) {
            Log::error('Failed to refresh comments', [
                'error' => $e->getMessage(),
                'post_id' => $this->postId
            ]);
            $this->MainCommentData = [];
        }
    }

    public $voilateWords = null, $mentionedUser;
    public function checkWithAi()
    {
        // return false;//remove if ai is actiVE
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
    public function Avatar($id)
    {
        $user = User::find($id);
        if ($user && !empty($user->profile_picture)) {
            return asset('storage/' . ltrim($user->profile_picture, '/'));
        }
        return asset('images/blank-avatar.png');
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
    public function reportComment($commentId)
    {
        ReportComments::create([
            'comment_type' => 'announcement',
            'comment_id' => $commentId,
        ]);
        session()->flash('message', 'Comment reported successfully.');
    }
    public function render()
    {
        return view('livewire.announcement.comments', [
            "main_comments" => $this->MainCommentData,
        ]);
    }
}
