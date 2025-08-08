<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'category',
        'descriptions',
        'user_id_who_already_viewed',
        'user_id_who_can_viewed',
        'author_name',
        'author_profile',
        'link',
    ];

    protected $casts = [
        'user_id_who_already_viewed' => 'array',
        'user_id_who_can_viewed' => 'array',
    ];
}
