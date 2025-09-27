<?php
namespace App\Enums;

enum Role: int
{
    case SuperAdmin = 1;
    case Admin      = 2;
    case User       = 3;

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::Admin      => 'Admin',
            self::User       => 'User',
        };
    }

    public function default(): self
    {
        return self::User;
    }
}
