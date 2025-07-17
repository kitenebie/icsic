<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class guardian extends Model
{
    protected $fillable = [
        'profile',
        'students_lrn',
        'contact_number',
        'email',
        'birthday',
        'permanent_address',
    ];

    protected $casts = [
        'students_lrn' => 'array',   // Cast the 'students_lrn' JSON field to an array
        'birthday' => 'date',        // Cast 'birthday' to a Carbon date instance
    ];
}
