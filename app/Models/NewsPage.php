<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsPage extends Model
{
    protected $casts = [
        'content' => 'array',
        'relevant_topic' => 'array',
    ];
    protected $guarded = [];
}
