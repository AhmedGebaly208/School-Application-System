<?php

namespace Modules\Finance\Enums;

enum InvoiceStatus: string
{
    case DRAFT = 'draft';
    case ISSUED = 'issued';
    case PAID = 'paid';
    case PARTIALLY_PAID = 'partially_paid';
    case OVERDUE = 'overdue';
    case CANCELLED = 'cancelled';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::DRAFT->value => 'Draft',
            self::ISSUED->value => 'Issued',
            self::PAID->value => 'Paid',
            self::PARTIALLY_PAID->value => 'Partially Paid',
            self::OVERDUE->value => 'Overdue',
            self::CANCELLED->value => 'Cancelled',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'gray',
            self::ISSUED => 'info',
            self::PAID => 'success',
            self::PARTIALLY_PAID => 'warning',
            self::OVERDUE => 'danger',
            self::CANCELLED => 'gray',
        };
    }
}
