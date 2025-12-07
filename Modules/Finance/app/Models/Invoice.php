<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Users\Models\Student;
use Modules\Users\Models\Staff;
use Modules\Academics\Models\AcademicYear;
use Modules\Academics\Models\Term;
use Modules\Finance\Enums\InvoiceStatus;

class Invoice extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'student_id',
        'invoice_number',
        'academic_year_id',
        'term_id',
        'invoice_date',
        'due_date',
        'total_amount',
        'discount_amount',
        'tax_amount',
        'net_amount',
        'status',
        'notes',
        'issued_by_staff_id',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'invoice_date' => 'date',
            'due_date' => 'date',
            'total_amount' => 'decimal:2',
            'discount_amount' => 'decimal:2',
            'tax_amount' => 'decimal:2',
            'net_amount' => 'decimal:2',
            'status' => InvoiceStatus::class,
        ];
    }

    /**
     * Get the student for this invoice.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the academic year for this invoice.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * Get the term for this invoice.
     */
    public function term(): BelongsTo
    {
        return $this->belongsTo(Term::class);
    }

    /**
     * Get the staff member who issued this invoice.
     */
    public function issuedByStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'issued_by_staff_id');
    }

    /**
     * Get the invoice items.
     */
    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * Get the payments for this invoice.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the total paid amount.
     */
    public function getTotalPaidAttribute(): float
    {
        return $this->payments()->where('status', 'completed')->sum('amount');
    }

    /**
     * Get the outstanding balance.
     */
    public function getBalanceAttribute(): float
    {
        return $this->net_amount - $this->total_paid;
    }

    /**
     * Check if the invoice is overdue.
     */
    public function getIsOverdueAttribute(): bool
    {
        return $this->due_date < now() && $this->balance > 0;
    }

    /**
     * Check if the invoice is fully paid.
     */
    public function getIsFullyPaidAttribute(): bool
    {
        return $this->balance <= 0;
    }

    /**
     * Scope a query to only include unpaid invoices.
     */
    public function scopeUnpaid($query)
    {
        return $query->whereIn('status', [InvoiceStatus::ISSUED, InvoiceStatus::PARTIALLY_PAID, InvoiceStatus::OVERDUE]);
    }

    /**
     * Scope a query to only include overdue invoices.
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
            ->where('status', '!=', InvoiceStatus::PAID);
    }

    /**
     * Scope a query to only include paid invoices.
     */
    public function scopePaid($query)
    {
        return $query->where('status', InvoiceStatus::PAID);
    }
}
