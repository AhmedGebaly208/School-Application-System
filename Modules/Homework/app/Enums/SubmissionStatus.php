<?php

namespace Modules\Homework\Enums;

enum SubmissionStatus: string
{
    case PENDING = 'pending';
    case SUBMITTED = 'submitted';
    case LATE = 'late';
    case GRADED = 'graded';

    public static function values(): array
    {
        return array_map(fn (self $status) => $status->value, self::cases());
    }

    public static function labels(): array
    {
        return [
            self::PENDING->value => 'Pending',
            self::SUBMITTED->value => 'Submitted',
            self::LATE->value => 'Late Submission',
            self::GRADED->value => 'Graded',
        ];
    }

    public function color(): string
    {
        return match($this) {
            self::PENDING => 'warning',
            self::SUBMITTED => 'info',
            self::LATE => 'danger',
            self::GRADED => 'success',
        };
    }
}
