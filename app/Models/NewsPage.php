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

    public function views()
    {
        return $this->hasMany(NewsView::class);
    }

    public function getViewsCountAttribute()
    {
        return $this->views()->count();
    }
}
