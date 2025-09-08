<?php
namespace App\Validation;

use InvalidArgumentException;

class Validator
{
    // Validate full name 
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

   //validate email
    public function email(string $email): string
    {
        $emailaddress = strtolower(trim($email));
        if (!filter_var($emailaddress, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Invalid email.');
        }
        return $emailaddress;
    }

    //Validate password 
    public function password(string $password, ?string $confirm = null, int $min = 8): string
    {
        if (mb_strlen($password) < $min) {
            throw new InvalidArgumentException("Password must be at least {$min} characters.");
        }
        if ($confirm !== null && $password !== $confirm) {
            throw new InvalidArgumentException('Passwords do not match.');
        }
        return $password; 
    }
}
