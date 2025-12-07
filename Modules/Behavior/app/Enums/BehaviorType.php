<?php

namespace Modules\Behavior\Enums;

enum BehaviorType: string
{
    case POSITIVE = 'positive';
    case NEGATIVE = 'negative';

    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::POSITIVE->value => 'Positive',
            self::NEGATIVE->value => 'Negative',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::POSITIVE => 'success',
            self::NEGATIVE => 'danger',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::POSITIVE => 'heroicon-o-hand-thumb-up',
            self::NEGATIVE => 'heroicon-o-hand-thumb-down',
        };
    }
}
