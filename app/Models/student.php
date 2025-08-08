<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    use HasFactory;
    protected $casts = [
        'birthday' => 'date',                // Cast birthday as a Carbon date instance
        'year_graduated' => 'integer',       // Cast year_graduated as an integer
        'remarks' => 'string',               // Cast remarks as a string
        'gender' => 'string',                // Cast gender as a string (although it’s already string in DB, this can be helpful for consistency)
    ];
    
    protected $fillable = [
        'profile',
        'lrn',
        'birthday',
        'permanent_address',
        'gender',
        'grade',
        'section',
        'email',
        'guardian_name',
        'relationship',
        'guardian_contact_number',
        'guardian_email',
        'year_graduated',
        'remarks',
    ];
}
