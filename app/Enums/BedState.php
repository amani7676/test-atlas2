<?php

// app/Enums/BedState.php
namespace App\Enums;

enum BedState: string
{
    case ACTIVE = 'active';
    case REPAIR = 'repair';

    public static function all(): array
    {
        return [
            self::ACTIVE->value,
            self::REPAIR->value
        ];
    }
}
