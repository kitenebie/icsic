<?php

namespace App\Livewire\Announcement;

use Livewire\Component;
use App\Models\Announcement as AnnouncementDB;
use App\Models\announcementReacts as React;
use App\Models\announcementComment as CommentDB;
use App\Models\User;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use  Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\On;
    use App\Services\OpenRouterService;

class Comments extends Component
{
    public $announcementID = null;
    public bool $disableLoadComments = false;
    public $isNotSmallMidium = true;



    public $id;
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
    public function mount()
    {
        $this->id = Session::get('comment');
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
    public $comment_input;
    public function submit_comment()
    {
        if ($this->CommentType == "reply") {
            if (!$this->comment_input == null) {
                $isValid = $this->checkWithAi();
                if (!$isValid) {
                    $this->comment_input = null;
                    return;
                }else{

                $data = [
                    'post_id' => $this->commentPostId,
                    'commentatorId' => Auth::user()->id,
                    'type' => $this->CommentType,
                    'reply_to' => $this->commentID,
                    'comment' => $this->comment_input
                ];
                $this->mentionedName = "/";
                $this->CommentType = "main";

                CommentDB::create($data);
                return redirect()->route('comment_section', ['id' => $this->id]);
                }
            }
        } else {
            if (!$this->comment_input == null) {
                $this->checkWithAi();
                $isValid = $this->checkWithAi();
                if (!$isValid) {
                    $this->comment_input = null;
                    return;
                }else{
                    
                $data = [
                    'post_id' => $this->id,
                    'commentatorId' => Auth::user()->id,
                    'type' => $this->CommentType,
                    'reply_to' => null,
                    'comment' => $this->comment_input
                ];
                $this->mentionedName = "/";

                CommentDB::create($data);
                return redirect()->route('comment_section', ['id' => $this->id]);
                }
            }
        }
    }

    public $voilateWords = null, $mentionedUser;
    public function checkWithAi()
    {
 
        $rawComment = $this->mentionedUser . ' ' . $this->comment_input;
        $openRouterService = new OpenRouterService();
        $aiReply = $openRouterService->ask($rawComment);
        preg_match_all('/\*(.*?)\*/', $aiReply, $matches);
        $offensiveWords = $matches[1] ?? [];
        // dd($offensiveWords);
        if (!empty($offensiveWords)) {
            $this->voilateWords = $offensiveWords;
            $this->comment_input = null;
            return false;
        }
        return true;
    }


    #[On('post-created')]
    public function handleNewPost($refreshPosts)
    {
        Session::put('screen', $refreshPosts);
    }
    public $closeCommentModal = false;
    public function closeComment()
    {
        $this->closeCommentModal = true;
    }

    public function Author($id)
    {
        $user = User::where('id', $id)->first();
        return $user->FirstName . " " . $user->LastName . " " . $user->MiddleName . " " . $user->extension_name;
    }
    public function render()
    {
        return view('livewire.announcement.comments', [
            "main_comments" => $this->MainCommentData,
        ]);
    }
}
