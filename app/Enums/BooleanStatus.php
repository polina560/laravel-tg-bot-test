<?php

namespace App\Enums;

enum BooleanStatus: int
{
    case No = 0;
    case Yes = 1;

    public function description(): string
    {
        return match ($this) {
            self::No => 'Нет',
            self::Yes => 'Да'
        };
    }
}
