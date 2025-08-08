<?php

namespace App\Livewire\Announcement;

use Livewire\Component;
use App\Models\Announcement as AnnouncementDB;
use App\Models\announcementReacts as React;
use App\Models\announcementComment as CommentDB;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use  Illuminate\Support\Facades\Auth;
class Main extends Component
{

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
        return  $reactNum < 1 ? "" : ($reactNum > 1 ? $reactNum . " reacts" : $reactNum . " react");
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

    public function commentCount($id)
    {
        $commentNum = CommentDB::where('post_id', $id)->count();
        return $commentNum > 1 ? $commentNum . " comments" : $commentNum . " comment";
    }
    public function reply_comments($id)
    {
        return CommentDB::where('post_id', $id)->where('type', 'reply')->get();
    }
    public $mentionedName = "/";
    public $CommentType = 'main';
    public $commentReplyId;
    public function replay_comment($id)
    {
        $this->commentReplyId = $id;
        $this->CommentType = 'reply';
        return $this->mentionedName = "@John Doe";
    }
    public $comment_input;
    public function submit_comment($id, $postID)
    {
        if (!$this->comment_input == null) {
            $data = [
                'post_id' => $postID,
                'commentatorId' => $id,
                'type' => $this->CommentType,
                'reply_to' => $this->commentReplyId,
                'comment' => $this->comment_input
            ];
            return CommentDB::create($data);
        }
    }
    public $i = null;
    public function openComment($id)
    {
        return redirect()->route('comment_section', ['id' => $id]);
    }
    public function render()
    {
        $user = Auth::user();
        $announcements = [];
        // Ensure user exists
        if ($user) {
            $announcements = AnnouncementDB::where(function ($query) use ($user) {
                // Match user ID in 'users' array
                $query->whereJsonContains('users', (string) $user->id)
                    ->orWhereJsonLength('users', 0); // include if users is []

                // Match group IDs in 'groups' array or include if empty
                $query->orWhere(function ($q) use ($user) {
                    foreach ((array) $user->user_group as $groupId) {
                        $q->orWhereJsonContains('groups', (string) $groupId);
                    }
                    $q->WhereJsonLength('groups', 0); // include if groups is []
                });

                // Optional: if you also want to include those with empty tags
                $query->WhereJsonLength('tags', 0);
            })
                ->orderByDesc('id')
                ->get();
        } else {
            $announcements = collect(); // Return empty collection if user not authenticated
        }
        return view('livewire.announcement.main', [
            "announcements" => $announcements,
        ]);
    }
}
