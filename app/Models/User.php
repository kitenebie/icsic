<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use App\Models\student;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Filament\Models\Contracts\HasAvatar;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@gmail.com') && $this->hasVerifiedEmail() && ($this->role === 'admin' || $this->role === 'teacher');
    }
    
    public function getFilamentAvatarUrl(): ?string
    {
        return $this->profile_image ?? 'https://ui-avatars.com/api/?name='. strtoupper(substr($this->FirstName, 0, 1)). strtoupper(substr($this->LastName, 0, 1)) .'&color=FFFFFF&background=09090b';
    }
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
        'profile_picture',
        'front_id',
        'back_id',
        'profile_image',
        'fcm_token'
    ];
    protected $casts = [
        'user_group' => 'array',
        'fcm_token' => 'string',
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

    public function newsViews()
    {
        return $this->hasMany(NewsView::class);
    }

    /**
     * Get the student record associated with this user
     */
    public function student()
    {
        return $this->belongsTo(\App\Models\Student::class, 'lrn', 'lrn');
    }
}
