<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

use App\Models\User;
use App\Models\Group;
use Illuminate\Support\Facades\Auth;

class AudienceService
{
    
    public function getVisibleUsers(): array
    {
        $authUser = Auth::user();

        $users = $authUser->role === 'admin'
            ? User::where('role', '!=', 'pending')->get()
            : User::where('grade', $authUser->grade)
                ->where('section', $authUser->section)
                ->where('role', 'student')
                ->orWhere('role', 'parent')
                ->get();

        return $users->mapWithKeys(function ($user) {
            $fullName = "{$user->LastName}, {$user->FirstName} {$user->MiddleName}";
            return [$user->id => $fullName];
        })->toArray();
    }

    public function getVisibleGroups(): array
    {
        $authUser = Auth::user();
        $groupIds = $authUser->user_group ?? [];

        $groups = $authUser->role === 'admin'
            ? Group::all()
            : Group::whereIn('id', $groupIds)->get();

        return $groups->pluck('name', 'id')->toArray();
    }
}
