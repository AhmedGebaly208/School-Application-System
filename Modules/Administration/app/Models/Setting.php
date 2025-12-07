<?php

namespace Modules\Administration\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Administration\Enums\SettingType;
use Modules\Administration\Enums\SettingGroup;
// use Modules\Administration\Database\Factories\SettingFactory;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'description',
        'is_public',
    ];

    protected function casts(): array
    {
        return [
            'type' => SettingType::class,
            'group' => SettingGroup::class,
            'is_public' => 'boolean',
        ];
    }

    /**
     * Computed Attributes
     */
    public function getCastedValueAttribute()
    {
        return match ($this->type) {
            SettingType::BOOLEAN => filter_var($this->value, FILTER_VALIDATE_BOOLEAN),
            SettingType::INTEGER => (int) $this->value,
            SettingType::JSON, SettingType::ARRAY => json_decode($this->value, true),
            default => $this->value,
        };
    }

    /**
     * Query Scopes
     */
    public function scopeByKey($query, string $key)
    {
        return $query->where('key', $key);
    }

    public function scopeByGroup($query, SettingGroup $group)
    {
        return $query->where('group', $group);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopePrivate($query)
    {
        return $query->where('is_public', false);
    }

    /**
     * Business Logic Methods
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = static::byKey($key)->first();

        return $setting ? $setting->casted_value : $default;
    }

    public static function setValue(string $key, $value, SettingType $type = SettingType::STRING, SettingGroup $group = SettingGroup::GENERAL): self
    {
        $valueString = match ($type) {
            SettingType::JSON => json_encode($value),
            SettingType::BOOLEAN => $value ? '1' : '0',
            default => (string) $value,
        };

        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $valueString,
                'type' => $type,
                'group' => $group,
            ]
        );
    }

    // protected static function newFactory(): SettingFactory
    // {
    //     // return SettingFactory::new();
    // }
}
