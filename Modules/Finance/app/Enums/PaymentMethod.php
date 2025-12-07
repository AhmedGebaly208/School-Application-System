<?php

namespace Modules\Finance\Enums;

enum PaymentMethod: string
{
    case CASH = 'cash';
    case BANK_TRANSFER = 'bank_transfer';
    case CREDIT_CARD = 'credit_card';
    case CHEQUE = 'cheque';
    case ONLINE = 'online';

    public static function values(): array
    {
        return array_map(fn (self $method) => $method->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::CASH->value => 'Cash',
            self::BANK_TRANSFER->value => 'Bank Transfer',
            self::CREDIT_CARD->value => 'Credit Card',
            self::CHEQUE->value => 'Cheque',
            self::ONLINE->value => 'Online Payment',
        ];
    }
}
