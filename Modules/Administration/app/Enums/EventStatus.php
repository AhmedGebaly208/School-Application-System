<?php

namespace Modules\Administration\Enums;

enum EventStatus: string
{
    case SCHEDULED = 'scheduled';
    case ONGOING = 'ongoing';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::SCHEDULED->value => 'Scheduled',
            self::ONGOING->value => 'Ongoing',
            self::COMPLETED->value => 'Completed',
            self::CANCELLED->value => 'Cancelled',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::SCHEDULED => 'info',
            self::ONGOING => 'warning',
            self::COMPLETED => 'success',
            self::CANCELLED => 'danger',
        };
    }
}
