<?php

namespace Modules\Administration\Enums;

enum DocumentType: string
{
    case CERTIFICATE = 'certificate';
    case TRANSCRIPT = 'transcript';
    case ID_CARD = 'id_card';
    case CONTRACT = 'contract';
    case REPORT = 'report';
    case OTHER = 'other';

    public static function values(): array
    {
        return array_map(fn (self $type) => $type->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::CERTIFICATE->value => 'Certificate',
            self::TRANSCRIPT->value => 'Transcript',
            self::ID_CARD->value => 'ID Card',
            self::CONTRACT->value => 'Contract',
            self::REPORT->value => 'Report',
            self::OTHER->value => 'Other',
        ];
    }
}
