<?php

namespace Modules\Counseling\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Counseling\Enums\NoteType;
use Modules\Users\Models\Staff;
// use Modules\Counseling\Database\Factories\CaseNoteFactory;

class CaseNote extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'case_id',
        'staff_id',
        'note_date',
        'note_type',
        'content',
        'next_action',
        'next_follow_up_date',
    ];

    protected function casts(): array
    {
        return [
            'note_date' => 'date',
            'note_type' => NoteType::class,
            'next_follow_up_date' => 'date',
        ];
    }

    /**
     * Relationships
     */
    public function counselingCase(): BelongsTo
    {
        return $this->belongsTo(CounselingCase::class, 'case_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }

    /**
     * Computed Attributes
     */
    public function getHasFollowUpAttribute(): bool
    {
        return $this->next_follow_up_date !== null;
    }

    public function getIsFollowUpDueAttribute(): bool
    {
        if (!$this->next_follow_up_date) {
            return false;
        }

        return $this->next_follow_up_date->isPast() || $this->next_follow_up_date->isToday();
    }

    /**
     * Query Scopes
     */
    public function scopeByCase($query, int $caseId)
    {
        return $query->where('case_id', $caseId);
    }

    public function scopeByType($query, NoteType $noteType)
    {
        return $query->where('note_type', $noteType);
    }

    public function scopeWithFollowUp($query)
    {
        return $query->whereNotNull('next_follow_up_date');
    }

    public function scopeFollowUpDue($query)
    {
        return $query->whereNotNull('next_follow_up_date')
            ->where('next_follow_up_date', '<=', now());
    }

    // protected static function newFactory(): CaseNoteFactory
    // {
    //     // return CaseNoteFactory::new();
    // }
}
