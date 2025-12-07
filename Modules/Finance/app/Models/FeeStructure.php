<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Academics\Models\Grade;
use Modules\Academics\Models\AcademicYear;
use Modules\Finance\Enums\PaymentFrequency;

class FeeStructure extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'grade_id',
        'fee_type_id',
        'academic_year_id',
        'amount',
        'currency',
        'payment_frequency',
        'due_day_of_month',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'payment_frequency' => PaymentFrequency::class,
            'due_day_of_month' => 'integer',
        ];
    }

    /**
     * Get the grade for this fee structure.
     */
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    /**
     * Get the fee type for this structure.
     */
    public function feeType(): BelongsTo
    {
        return $this->belongsTo(FeeType::class);
    }

    /**
     * Get the academic year for this structure.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the formatted amount with currency.
     */
    public function getFormattedAmountAttribute(): string
    {
        return $this->currency . ' ' . number_format($this->amount, 2);
    }
}
