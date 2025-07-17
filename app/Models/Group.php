<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = [
        'author_id',
        'name',
        'description',
    ];

    // Define relationship to User model
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
    public function getFullNameAttribute()
    {
        return $this->LastName . ', ' . $this->FirstName . ($this->MiddleName ? ' ' . $this->MiddleName : '');
    }
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'user_group');
    }
}
