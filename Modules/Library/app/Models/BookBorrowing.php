<?php

namespace Modules\Library\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Library\Enums\BorrowingStatus;
use Modules\Library\Enums\BookCondition;
use Modules\Users\Models\Student;
use Modules\Users\Models\Staff;
// use Modules\Library\Database\Factories\BookBorrowingFactory;

class BookBorrowing extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'book_id',
        'student_id',
        'borrowed_date',
        'due_date',
        'returned_date',
        'issued_by_staff_id',
        'received_by_staff_id',
        'fine_amount',
        'fine_paid',
        'condition_on_return',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'borrowed_date' => 'date',
            'due_date' => 'date',
            'returned_date' => 'date',
            'fine_amount' => 'decimal:2',
            'fine_paid' => 'boolean',
            'condition_on_return' => BookCondition::class,
            'status' => BorrowingStatus::class,
        ];
    }

    /**
     * Relationships
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function issuedByStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'issued_by_staff_id');
    }

    public function receivedByStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'received_by_staff_id');
    }

    /**
     * Computed Attributes
     */
    public function getIsOverdueAttribute(): bool
    {
        if ($this->status !== BorrowingStatus::ACTIVE) {
            return false;
        }

        return $this->due_date->isPast();
    }

    public function getDaysOverdueAttribute(): int
    {
        if (!$this->is_overdue) {
            return 0;
        }

        return $this->due_date->diffInDays(now());
    }

    public function getHasPendingFineAttribute(): bool
    {
        return $this->fine_amount > 0 && !$this->fine_paid;
    }

    /**
     * Query Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('status', BorrowingStatus::ACTIVE);
    }

    public function scopeReturned($query)
    {
        return $query->where('status', BorrowingStatus::RETURNED);
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', BorrowingStatus::ACTIVE)
            ->where('due_date', '<', now());
    }

    public function scopeByStudent($query, int $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeWithPendingFines($query)
    {
        return $query->where('fine_amount', '>', 0)
            ->where('fine_paid', false);
    }

    // protected static function newFactory(): BookBorrowingFactory
    // {
    //     // return BookBorrowingFactory::new();
    // }
}
