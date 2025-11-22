<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class ReportComments extends Model
{
    protected $fillable = ['comment_type', 'comment_id', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getCommentContent(): string
    {
        if ($this->comment_type === 'announcement') {
            $comment = \App\Models\announcementComment::find($this->comment_id);
        } elseif ($this->comment_type === 'news') {
            $comment = \App\Models\newsComment::find($this->comment_id);
        } else {
            return 'Unknown comment type';
        }

        return $comment ? strip_tags($comment->comment) : 'Comment not found';
    }
}
