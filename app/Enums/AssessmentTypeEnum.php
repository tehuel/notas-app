<?php

namespace App\Enums;

enum AssessmentTypeEnum: string
{
    case Individual = 'individual';
    case Group = 'group';

    public function label(): string
    {
        return "messages.assessment_type.$this->value";
    }

    public function icon(): string
    {
        return match ($this) {
            self::Individual => 'bi bi-person',
            self::Group => 'bi bi-people',
        };
    }
}
