<?php
declare(strict_types=1);

namespace App\Validation;

use InvalidArgumentException;

class Validator
{
    public function __construct(private int $minPassword = 8) {}

    public function name(string $fullname): string
    {
        $name = preg_replace('/\s+/', ' ', trim($fullname));
        if ($name === '') {
            throw new InvalidArgumentException('Full name is required.');
        }
        if (mb_strlen($name) > 100) {
            throw new InvalidArgumentException('Full name is too long.');
        }
        return $name;
    }

    public function email(string $email): string
    {
        $emailAddress = strtolower(trim($email));
        if (!filter_var($emailAddress, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email.');
        }
        return $emailAddress;
    }

    public function password(string $password, ?string $confirm = null): string
    {
        if (mb_strlen($password) < $this->minPassword) {
            throw new InvalidArgumentException("Password must be at least {$this->minPassword} characters.");
        }
        if ($confirm !== null && $password !== $confirm) {
            throw new InvalidArgumentException('Passwords do not match.');
        }
        return $password;
    }
}
