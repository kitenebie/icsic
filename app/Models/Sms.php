<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sms extends Model
{
    protected $fillable = [
        'numbers',
        'Content',
        'status'
    ];
    
    protected $casts = [
        'numbers' => 'array',
        'Content' => 'string'
    ];
}
