<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsView extends Model
{
    protected $fillable = [
        'user_id',
        'news_page_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function newsPage()
    {
        return $this->belongsTo(NewsPage::class);
    }
}
