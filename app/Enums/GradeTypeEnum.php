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

    public function icon(): string
    {
        return match ($this) {
            self::Numeric => 'bi bi-hash',
            self::PassFail => 'bi bi-check2-square',
            self::Semaphore => 'bi bi-stoplights',
        };
    }
}
