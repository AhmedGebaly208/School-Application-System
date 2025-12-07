<?php

namespace Modules\Finance\Enums;

enum PaymentFrequency: string
{
    case MONTHLY = 'monthly';
    case QUARTERLY = 'quarterly';
    case ANNUALLY = 'annually';
    case ONE_TIME = 'one_time';

    public static function values(): array
    {
        return array_map(fn (self $frequency) => $frequency->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::MONTHLY->value => 'Monthly',
            self::QUARTERLY->value => 'Quarterly',
            self::ANNUALLY->value => 'Annually',
            self::ONE_TIME->value => 'One Time',
        ];
    }
}
