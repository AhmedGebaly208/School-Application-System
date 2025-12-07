<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Users\Models\Student;
use Modules\Academics\Models\AcademicYear;

class StudentAccountSummary extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'student_account_summary';

    /**
     * Indicates if the model should use created_at timestamp.
     */
    const CREATED_AT = null;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'student_id',
        'academic_year_id',
        'total_fees',
        'total_paid',
        'total_outstanding',
        'last_payment_date',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'total_fees' => 'decimal:2',
            'total_paid' => 'decimal:2',
            'total_outstanding' => 'decimal:2',
            'last_payment_date' => 'date',
        ];
    }

    /**
     * Get the student for this account summary.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the academic year for this account summary.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the payment completion percentage.
     */
    public function getPaymentPercentageAttribute(): float
    {
        if ($this->total_fees == 0) {
            return 0;
        }
        return ($this->total_paid / $this->total_fees) * 100;
    }

    /**
     * Check if the account is fully paid.
     */
    public function getIsFullyPaidAttribute(): bool
    {
        return $this->total_outstanding <= 0;
    }

    /**
     * Check if there is an outstanding balance.
     */
    public function getHasOutstandingAttribute(): bool
    {
        return $this->total_outstanding > 0;
    }
}
