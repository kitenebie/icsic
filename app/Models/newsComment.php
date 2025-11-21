<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class newsComment extends Model
{
    protected $guarded = [];

    public function news()
    {
        return $this->belongsTo(news::class, 'post_id');
    }

    public function commentator()
    {
        return $this->belongsTo(User::class, 'commentatorId');
    }

    public function replies()
    {
        return $this->hasMany(newsComment::class, 'reply_to');
    }

    public function parent()
    {
        return $this->belongsTo(newsComment::class, 'reply_to');
    }
}
