<?php
// app/Enums/NoteType.php
namespace App\Enums;

enum NoteType: string
{
    case PAYMENT = 'payment';
    case END_DATE = 'end_date';
    case EXIT = 'exit';
    case DEMAND = 'demand';
    case OTHER = 'other';

    public static function isValid(string $value): bool
    {
        return in_array($value, self::all());
    }

    public static function all(): array
    {
        return [
            self::PAYMENT->value,
            self::END_DATE->value,
            self::EXIT->value,
            self::DEMAND->value,
            self::OTHER->value
        ];
    }
}
