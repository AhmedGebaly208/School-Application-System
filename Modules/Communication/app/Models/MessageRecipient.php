<?php

namespace Modules\Communication\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Communication\Enums\RecipientType;

class MessageRecipient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'message_id',
        'recipient_id',
        'recipient_type',
        'is_read',
        'read_at',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'recipient_type' => RecipientType::class,
            'is_read' => 'boolean',
            'read_at' => 'datetime',
        ];
    }

    /**
     * Get the message for this recipient.
     */
    public function message(): BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    /**
     * Get the recipient (polymorphic).
     */
    public function recipient(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'recipient_type', 'recipient_id');
    }

    /**
     * Scope a query to only include unread recipients.
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope a query to only include read recipients.
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }
}
