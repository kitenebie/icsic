<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class news extends Model
{
    protected $casts = [
        'categories' => 'array',
        'tags' => 'array',
        'ads2' => 'array',
    ];
    protected $fillable = [
        'mainImage',
        'title',
        'content',
        'categories',
        'tags',
        'ads1',
        'ads2',
    ];
}
