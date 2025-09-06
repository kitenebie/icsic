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
}
