<?php

namespace Modules\Exams\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExamType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'weight_percentage',
        'description',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'weight_percentage' => 'decimal:2',
        ];
    }

    /**
     * Get the exams for this type.
     */
    public function exams(): HasMany
    {
        return $this->hasMany(Exam::class);
    }
}
