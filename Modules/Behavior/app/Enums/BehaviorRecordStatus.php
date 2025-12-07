<?php

namespace Modules\Behavior\Enums;

enum BehaviorRecordStatus: string
{
    case REPORTED = 'reported';
    case UNDER_REVIEW = 'under_review';
    case RESOLVED = 'resolved';
    case ESCALATED = 'escalated';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::REPORTED->value => 'Reported',
            self::UNDER_REVIEW->value => 'Under Review',
            self::RESOLVED->value => 'Resolved',
            self::ESCALATED->value => 'Escalated',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::REPORTED => 'gray',
            self::UNDER_REVIEW => 'warning',
            self::RESOLVED => 'success',
            self::ESCALATED => 'danger',
        };
    }

    public function icon(): string
    {
        return match($this) {
            self::REPORTED => 'heroicon-o-document-text',
            self::UNDER_REVIEW => 'heroicon-o-magnifying-glass',
            self::RESOLVED => 'heroicon-o-check-circle',
            self::ESCALATED => 'heroicon-o-exclamation-triangle',
        };
    }

    public function description(): string
    {
        return match($this) {
            self::REPORTED => 'Incident has been reported',
            self::UNDER_REVIEW => 'Incident is being reviewed by staff',
            self::RESOLVED => 'Incident has been resolved',
            self::ESCALATED => 'Incident has been escalated to higher authority',
        };
    }
}
