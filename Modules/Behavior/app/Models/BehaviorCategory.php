<?php

namespace Modules\Behavior\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Behavior\Enums\BehaviorType;
use Modules\Behavior\Enums\BehaviorSeverity;
// use Modules\Behavior\Database\Factories\BehaviorCategoryFactory;

class BehaviorCategory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'type',
        'points',
        'severity',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'type' => BehaviorType::class,
            'points' => 'integer',
            'severity' => BehaviorSeverity::class,
        ];
    }

    /**
     * Relationships
     */
    public function behaviorRecords(): HasMany
    {
        return $this->hasMany(BehaviorRecord::class);
    }

    /**
     * Query Scopes
     */
    public function scopePositive($query)
    {
        return $query->where('type', BehaviorType::POSITIVE);
    }

    public function scopeNegative($query)
    {
        return $query->where('type', BehaviorType::NEGATIVE);
    }

    public function scopeBySeverity($query, BehaviorSeverity $severity)
    {
        return $query->where('severity', $severity);
    }

    // protected static function newFactory(): BehaviorCategoryFactory
    // {
    //     // return BehaviorCategoryFactory::new();
    // }
}
