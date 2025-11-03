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
}
