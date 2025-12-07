<?php

namespace Modules\Exams\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Academics\Models\Grade;

class GradeScale extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'grade_id',
        'min_percentage',
        'max_percentage',
        'letter_grade',
        'gpa_points',
        'description',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'min_percentage' => 'decimal:2',
            'max_percentage' => 'decimal:2',
            'gpa_points' => 'decimal:2',
        ];
    }

    /**
     * Get the grade for this scale.
     */
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    /**
     * Get the letter grade for a given percentage.
     */
    public static function getLetterGrade(int $gradeId, float $percentage): ?string
    {
        $scale = self::where('grade_id', $gradeId)
            ->where('min_percentage', '<=', $percentage)
            ->where('max_percentage', '>=', $percentage)
            ->first();

        return $scale?->letter_grade;
    }

    /**
     * Get the GPA points for a given percentage.
     */
    public static function getGpaPoints(int $gradeId, float $percentage): ?float
    {
        $scale = self::where('grade_id', $gradeId)
            ->where('min_percentage', '<=', $percentage)
            ->where('max_percentage', '>=', $percentage)
            ->first();

        return $scale?->gpa_points;
    }
}
