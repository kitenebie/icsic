<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class announcementComment extends Model
{
    use HasFactory;

    protected $table = 'announcement_comments';

    protected $fillable = [
        'post_id',
        'commentatorId',
        'type',
        'reply_to',
        'comment'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Validation rules
    public static function rules()
    {
        return [
            'post_id' => 'required|integer|exists:announcements,id',
            'commentatorId' => 'required|integer|exists:users,id',
            'type' => 'required|in:main,reply',
            'reply_to' => 'nullable|integer|exists:announcement_comments,id',
            'comment' => 'required|string|min:1|max:10000',
        ];
    }

    // Relationships
    public function announcement(): BelongsTo
    {
        return $this->belongsTo(Announcement::class, 'post_id');
    }

    public function commentator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'commentatorId');
    }

    public function parentComment(): BelongsTo
    {
        return $this->belongsTo(self::class, 'reply_to');
    }

    public function replies(): HasMany
    {
        return $this->hasMany(self::class, 'reply_to');
    }

    // Scopes
    public function scopeMainComments($query)
    {
        return $query->where('type', 'main');
    }

    public function scopeReplies($query)
    {
        return $query->where('type', 'reply');
    }

    public function scopeForPost($query, $postId)
    {
        return $query->where('post_id', $postId);
    }

    // Boot method for model events
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            // Ensure commentatorId is set to current user if not provided
            if (empty($comment->commentatorId) && Auth::check()) {
                $comment->commentatorId = Auth::id();
            }

            // Clean and validate comment text
            $comment->comment = strip_tags(trim($comment->comment));
            
            // Validate comment length
            if (strlen($comment->comment) > 10000) {
                throw new \InvalidArgumentException('Comment text cannot exceed 10,000 characters.');
            }

            if (empty($comment->comment)) {
                throw new \InvalidArgumentException('Comment text cannot be empty.');
            }
        });

        static::created(function ($comment) {
            Log::info('Comment created successfully', [
                'id' => $comment->id,
                'post_id' => $comment->post_id,
                'type' => $comment->type,
                'commentator_id' => $comment->commentatorId
            ]);
        });
    }

    // Helper methods
    public function isReply(): bool
    {
        return $this->type === 'reply';
    }

    public function isMainComment(): bool
    {
        return $this->type === 'main';
    }

    public function canEdit(): bool
    {
        return Auth::check() && Auth::id() === $this->commentatorId;
    }

    public function getAuthorNameAttribute(): string
    {
        if ($this->commentator) {
            return trim($this->commentator->FirstName . ' ' .
                       $this->commentator->LastName . ' ' .
                       $this->commentator->MiddleName . ' ' .
                       $this->commentator->extension_name);
        }
        return 'ICSIS User';
    }
}
