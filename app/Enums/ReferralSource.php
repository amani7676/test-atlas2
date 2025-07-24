<?php
// app/Enums/ReferralSource.php

namespace App\Enums;

enum ReferralSource: string
{
    case UNIVERSITY_INTRODUCTION = 'university_introduction';
    case UNIVERSITY_WEBSITE = 'university_website';
    case GOOGLE = 'google';
    case MAP = 'map';
    case KHOBINJA_WEBSITE = 'khobinja_website';
    case FRIENDS = 'introducing_friends';
    case STREET = 'street';
    case DIVAR = 'divar';
    case OTHER = 'other';

    public static function isValid(string $value): bool
    {
        return !is_null(self::tryFrom($value));
    }

    public static function all(): array
    {
        return array_column(self::cases(), 'value');
    }
}
