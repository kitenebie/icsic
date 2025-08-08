<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $fillable = [
        'affected_user_id',
        'performed_by_user_id',
        'action',
        'before',
        'after',
    ];

    protected $casts = [
        'before' => 'array',
        'after' => 'array',
    ];
    public function affectedUser()
    {
        return $this->belongsTo(User::class, 'affected_user_id');
    }

    public function performedByUser()
    {
        return $this->belongsTo(User::class, 'performed_by_user_id');
    }

    //
}
