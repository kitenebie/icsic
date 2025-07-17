<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserLog;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    public function created(User $user): void
    {
        UserLog::create([
            'affected_user_id' => $user->id,
            'performed_by_user_id' => Auth::user()->id(),
            'action' => 'created',
            'after' => $user->toArray(),
            'description' => 'User created: ' . $user->name,
        ]);
    }

    public function updated(User $user): void
    {
        UserLog::create([
            'affected_user_id' => $user->id,
            'performed_by_user_id' => Auth::user()->id(),
            'action' => 'updated',
            'before' => $user->getOriginal(),
            'after' => $user->getChanges(),
            'description' => 'User updated: ' . $user->name,
        ]);
    }

    public function deleted(User $user): void
    {
        UserLog::create([
            'affected_user_id' => $user->id,
            'performed_by_user_id' => Auth::user()->id(),
            'action' => 'deleted',
            'before' => $user->toArray(),
            'description' => 'User deleted: ' . $user->name,
        ]);
    }
}
