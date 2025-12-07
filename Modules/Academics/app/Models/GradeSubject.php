<?php

namespace Modules\Academics\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GradeSubject extends Pivot
{
    /**
     * The table associated with the model.
     */
    protected $table = 'grade_subject';

    /**
     * Indicates if the model should be timestamped.
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'grade_id',
        'subject_id',
        'is_mandatory',
        'weekly_hours',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'is_mandatory' => 'boolean',
            'weekly_hours' => 'integer',
        ];
    }
}
