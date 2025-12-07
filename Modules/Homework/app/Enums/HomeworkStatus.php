<?php

namespace Modules\Homework\Enums;

enum HomeworkStatus: string
{
    case ACTIVE = 'active';
    case CLOSED = 'closed';
    case CANCELLED = 'cancelled';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::ACTIVE->value => 'Active',
            self::CLOSED->value => 'Closed',
            self::CANCELLED->value => 'Cancelled',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::ACTIVE => 'success',
            self::CLOSED => 'gray',
            self::CANCELLED => 'danger',
        };
    }
}
