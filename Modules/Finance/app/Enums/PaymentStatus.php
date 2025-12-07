<?php

namespace Modules\Finance\Enums;

enum PaymentStatus: string
{
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
    case REFUNDED = 'refunded';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::PENDING->value => 'Pending',
            self::COMPLETED->value => 'Completed',
            self::FAILED->value => 'Failed',
            self::REFUNDED->value => 'Refunded',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::COMPLETED => 'success',
            self::FAILED => 'danger',
            self::REFUNDED => 'info',
        };
    }
}
