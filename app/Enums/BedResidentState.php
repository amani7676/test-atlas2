<?php 
// app/Enums/BedResidentState.php
namespace App\Enums;

enum BedResidentState: string
{
    case RESERVE = 'rezerve';
    case FULL = 'full';
    case EMPTY = 'empty';

    public static function all(): array
    {
        return [
            self::RESERVE->value,
            self::FULL->value,
            self::EMPTY->value
        ];
    }
}
