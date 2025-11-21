<?php

namespace App\Livewire\News;

use Livewire\Component;
use App\Models\NewsPage as NewsDB;
use App\Models\newsComment as NewsCommentModel;
use App\Models\User;
use App\Models\ReportComments;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Services\OpenRouterService;
use App\Models\NewsView;

class View extends Component
{
    public $hashId, $voilateWords  = null;
    public $categories = [
        "School Announcements",
        "Teacher Updates",
        "Student Achievements",
        "Curriculum Changes",
        "School Events",
        "DEPED Policies",
        "Educational Resources",
        "Parent Involvement",
        "School Safety",
        "Academic Programs",
        "Extracurricular Activities",
        "School Administration",
        "Teacher Training",
        "Student Welfare",
        "Educational Technology",
        "School Facilities",
        "Graduation News",
        "Enrollment Information",
        "Scholarship Opportunities",
        "Educational Reforms",
        "School Supplies",
        "Teacher Recruitment",
        "Student Discipline",
        "School Budget",
        "Educational Partnerships",
        "Online Learning",
        "Special Education",
        "School Feeding Program",
        "DepEd Orders",
        "School Calendar"
    ];

    public function mount($hashId)
    {
        $this->hashId = $hashId;

        // Track view for authenticated users
        if (Auth::check()) {
            $userId = Auth::id();
            $newsPageId = $this->hashId;

            // Check if user has already viewed this news item
            $existingView = NewsView::where('user_id', $userId)
                ->where('news_page_id', $newsPageId)
                ->first();

            // If no existing view, create one
            if (!$existingView) {
                NewsView::create([
                    'user_id' => $userId,
                    'news_page_id' => $newsPageId,
                ]);
            }
        }
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
    public function Topic_category()
    {
        return $this->categories[NewsDB::where('id', $this->hashId)->first()->topic_category];
    }
    public function Topic_title()
    {
        return NewsDB::where('id', $this->hashId)->first()->title;
    }
    public $commentInput;
    public $UserCommentId = null;
    public $comment_type = 'main';
    protected $rules = [
        'commentInput' => 'required|min:3',
    ];
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }
    public function save_comment()
    {
        // dd($this->commentInput);
        $this->validate(); 

        $rawComment = $this->mentionedUser . ' ' . $this->commentInput;
        $openRouterService = new OpenRouterService();
        $aiReply = $openRouterService->ask($rawComment);
        preg_match_all('/\*(.*?)\*/', $aiReply, $matches);
        $offensiveWords = $matches[1] ?? [];
        if (!empty($offensiveWords)) {
            $this->voilateWords = $offensiveWords;
            $this->commentInput = null;
            return;
        }

        $comment_data = [
            'post_id' => $this->hashId,
            'commentatorId' => Auth::user()->id,
            'type' => $this->comment_type,
            'reply_to' => $this->UserCommentId,
            'comment' => '<strong class="text-green-600"> ' . $this->mentionedUser . '  </strong> <span>' . $this->commentInput . '</span>',
        ];
        NewsCommentModel::create($comment_data);
        $this->ReplycommentInput = null;
        $this->commentInput = null;
        return redirect('/read' . '/' . Str::random(80) . '/ ' . $this->hashId . '#reply');
    }

    public function reply_comment($commentId)
    {
        return NewsCommentModel::where('reply_to', $commentId)->where('type', 'reply')->get();
    }
    public function user_name($userId)
    {
        $commentor = User::where('id', $userId)->first();
        return $commentor->FirstName . " " . $commentor->MiddleName . " " . $commentor->LastName . " " . $commentor->extension_name;
    }
    public function all_comments_Count()
    {
        return NewsCommentModel::where('post_id', $this->hashId)->count();
    }
    public $ReplycommentInput;
    public $mentionedUser;
    public function reply($userComment, $type, $id, $reply_id)
    {
        $comment = NewsCommentModel::where('id', $id)->first()->comment;
        if ($reply_id != "") {
            $comment = NewsCommentModel::where('id', $reply_id)->first()->comment;
        }
        $this->UserCommentId = $id;
        $this->comment_type = $type;
        $this->mentionedUser = $this->user_name($userComment);
        $this->ReplycommentInput = "Reply to: @" . $this->mentionedUser  . " - " . $comment;
    }
    public function reportComment($commentId)
    {
        ReportComments::updateOrCreate([
            'comment_type' => 'news',
            'comment_id' => $commentId,
        ]);
        session()->flash('message', 'Comment reported successfully.');
    }
    public function render()
    {
        return view('livewire.news.view', [
            'News' => NewsDB::where('id', $this->hashId)->first(),
            'main_comments' => NewsCommentModel::where('post_id', $this->hashId)->where('type', 'main')->get(),
        ]);
    }
}
