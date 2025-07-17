<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Models\student;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'FirstName',
        'LastName',
        'MiddleName',
        'extension_name',
        'contact',
        'email',
        'password',
        'lrn',
        'role',
        'year_graduated',
        'user_group',
        'status',
        'grade',
        'section',
        'profile_picture'
    ];
    protected $casts = [
        'user_group' => 'array',
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }
    public function groups()
    {
        return $this->belongsToMany(\App\Models\Group::class, 'user_group');
    }
    public function fullname()
    {
        return "{$this->LastName} {$this->extension_name}, {$this->FirstName} {$this->MiddleName}";
    }
}
