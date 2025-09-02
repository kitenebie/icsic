<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class event extends Model
{
        use HasFactory;

    protected $fillable = [
        'event_name',
        'event_category',
        'event_location',
        'event_date',
        'event_time',
        'event_duration',
        'event_discription'
    ];
}
