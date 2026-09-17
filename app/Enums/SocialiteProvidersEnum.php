<?php

namespace App\Enums;

enum SocialiteProvidersEnum: string
{
    case Google = 'google';
    case Github = 'github';
    case Apple = 'apple';

    public function label(): string
    {
        return match ($this) {
            self::Google => 'Google',
            self::Github => 'GitHub',
            self::Apple => 'Apple',
        };
    }
}
