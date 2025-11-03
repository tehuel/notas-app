<?php

namespace App\Enums;

enum GradeTypeEnum: string
{
    case Numeric = 'numeric';
    case PassFail = 'pass_fail';
    case Semaphore = 'semaphore';

    public function label(): string
    {
        return "messages.grade_type.$this->value";
    }
}
