<?php

namespace Modules\Administration\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Administration\Enums\DocumentType;
use Modules\Users\Models\Staff;
// use Modules\Administration\Database\Factories\DocumentFactory;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'documentable_type',
        'documentable_id',
        'document_type',
        'title',
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
        'issued_by_staff_id',
        'issued_date',
        'expiry_date',
    ];

    protected function casts(): array
    {
        return [
            'document_type' => DocumentType::class,
            'file_size' => 'integer',
            'issued_date' => 'date',
            'expiry_date' => 'date',
        ];
    }

    /**
     * Relationships
     */
    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }

    public function issuedByStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'issued_by_staff_id');
    }

    /**
     * Computed Attributes
     */
    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    public function getIsExpiredAttribute(): bool
    {
        if (!$this->expiry_date) {
            return false;
        }

        return $this->expiry_date->isPast();
    }

    public function getIsExpiringSoonAttribute(): bool
    {
        if (!$this->expiry_date || $this->is_expired) {
            return false;
        }

        return $this->expiry_date->diffInDays(now()) <= 30;
    }

    /**
     * Query Scopes
     */
    public function scopeByType($query, DocumentType $documentType)
    {
        return $query->where('document_type', $documentType);
    }

    public function scopeForEntity($query, string $type, int $id)
    {
        return $query->where('documentable_type', $type)
            ->where('documentable_id', $id);
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '<', now());
    }

    public function scopeExpiringSoon($query, int $days = 30)
    {
        return $query->whereNotNull('expiry_date')
            ->whereDate('expiry_date', '>=', now())
            ->whereDate('expiry_date', '<=', now()->addDays($days));
    }

    // protected static function newFactory(): DocumentFactory
    // {
    //     // return DocumentFactory::new();
    // }
}
