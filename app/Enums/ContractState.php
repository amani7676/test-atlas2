<?php
// app/Enums/ContractState.php
namespace App\Enums;

enum ContractState: string
{
    case RESERVE = 'rezerve';
    case NIGHTLY = 'nightly';
    case ACTIVE = 'active';
    case LEAVING = 'leaving';
    case EXIT = 'exit';

    public static function all(): array
    {
        return [
            self::RESERVE->value,
            self::NIGHTLY->value,
            self::ACTIVE->value,
            self::LEAVING->value,
            self::EXIT->value
        ];
    }
}
