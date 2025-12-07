<?php

namespace Modules\Communication\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Communication\Enums\MessagePriority;
use Modules\Communication\Enums\SenderType;

class Message extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'sender_id',
        'sender_type',
        'subject',
        'body',
        'priority',
        'is_read',
        'read_at',
        'parent_message_id',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'sender_type' => SenderType::class,
            'priority' => MessagePriority::class,
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    /**
     * Get the sender (polymorphic).
     */
    public function sender(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'sender_type', 'sender_id');
    }

    /**
     * Get the parent message (for threading).
     */
    public function parentMessage(): BelongsTo
    {
        return $this->belongsTo(Message::class, 'parent_message_id');
    }

    /**
     * Get the reply messages.
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Message::class, 'parent_message_id');
    }

    /**
     * Get the message recipients.
     */
    public function recipients(): HasMany
    {
        return $this->hasMany(MessageRecipient::class);
    }

    /**
     * Scope a query to only include unread messages.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope a query to only include read messages.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope a query to only include high priority messages.
     */
    public function scopeHighPriority($query)
    {
        return $query->where('priority', MessagePriority::HIGH);
    }
}
