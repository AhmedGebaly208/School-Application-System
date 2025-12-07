<?php

namespace Modules\Administration\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Administration\Enums\AuditAction;
use Modules\Users\Models\User;
// use Modules\Administration\Database\Factories\AuditLogFactory;

class AuditLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'action',
        'auditable_type',
        'auditable_id',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'action' => AuditAction::class,
            'old_values' => 'array',
            'new_values' => 'array',
            'created_at' => 'datetime',
        ];
    }

    /**
     * Relationships
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function auditable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Computed Attributes
     */
    public function getChangesAttribute(): array
    {
        if (!$this->old_values || !$this->new_values) {
            return [];
        }

        $changes = [];
        foreach ($this->new_values as $key => $newValue) {
            $oldValue = $this->old_values[$key] ?? null;
            if ($oldValue !== $newValue) {
                $changes[$key] = [
                    'old' => $oldValue,
                    'new' => $newValue,
                ];
            }
        }

        return $changes;
    }

    /**
     * Query Scopes
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByAction($query, AuditAction $action)
    {
        return $query->where('action', $action);
    }

    public function scopeForEntity($query, string $type, int $id)
    {
        return $query->where('auditable_type', $type)
            ->where('auditable_id', $id);
    }

    public function scopeCreated($query)
    {
        return $query->where('action', AuditAction::CREATE);
    }

    public function scopeUpdated($query)
    {
        return $query->where('action', AuditAction::UPDATE);
    }

    public function scopeDeleted($query)
    {
        return $query->where('action', AuditAction::DELETE);
    }

    public function scopeRecent($query, int $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    // protected static function newFactory(): AuditLogFactory
    // {
    //     // return AuditLogFactory::new();
    // }
}
