<?php

namespace Modules\Library\Enums;

enum BorrowingStatus: string
{
    case ACTIVE = 'active';
    case RETURNED = 'returned';
    case OVERDUE = 'overdue';
    case LOST = 'lost';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::ACTIVE->value => 'Active',
            self::RETURNED->value => 'Returned',
            self::OVERDUE->value => 'Overdue',
            self::LOST->value => 'Lost',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::ACTIVE => 'info',
            self::RETURNED => 'success',
            self::OVERDUE => 'danger',
            self::LOST => 'gray',
        };
    }
}
