<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class announcementComment extends Model
{
    protected $table = 'announcement_comments';

    protected $fillable = [
        'post_id',
        'commentatorId',
        'type',
        'reply_to',
        'comment'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function announcement()
    {
        return $this->belongsTo(Announcement::class, 'post_id');
    }

    public function commentator()
    {
        return $this->belongsTo(User::class, 'commentatorId');
    }

    public function replies()
    {
        return $this->hasMany(announcementComment::class, 'reply_to');
    }

    public function parent()
    {
        return $this->belongsTo(announcementComment::class, 'reply_to');
    }
}
