<?php
declare(strict_types=1);

namespace App\Model;

use App\Config\Database;
use App\Validation\Validator;
use App\Objects\User;
use App\Support\Mailer;
use DomainException;

final class Login extends Database
{
    private const MAX_ATTEMPTS = 5;   // lock after 5 bad tries
    private const LOCK_MINUTES = 15;  // lock duration

    private Validator $v;

    public function __construct(?Validator $v = null)
    {
        parent::__construct();
        $this->v = $v ?? new Validator(8);
    }

    /** Authenticate and return the User entity. */
    public function login(string $email, string $password): User
    {
        $email   = $this->v->email($email);
        $invalid = new DomainException('Invalid credentials.');

        
        $row = $this->run(
            'SELECT id, fullname, email, role_id, password_hash, failed_attempts, lockout_until, created_at
               FROM users
              WHERE email = :email
              LIMIT 1',
            ['email' => $email]
        )->fetch();

        if (!$row) {
            throw $invalid; // don’t reveal whether email exists
        }

        // Locked?
        if (!empty($row['lockout_until']) && strtotime((string)$row['lockout_until']) > time()) {
            throw new DomainException('Account is locked. Try again later.');
        }

        // Wrong password → bump counter or lock
        if (!password_verify($password, (string)$row['password_hash'])) {
            $failed = (int)$row['failed_attempts'] + 1;

            if ($failed >= self::MAX_ATTEMPTS) {
                $this->run(
                    'UPDATE users
                        SET failed_attempts = 0,
                            lockout_until   = DATE_ADD(NOW(), INTERVAL :m MINUTE)
                      WHERE id = :id',
                    ['m' => self::LOCK_MINUTES, 'id' => (int)$row['id']]
                );
            } else {
                $this->run(
                    'UPDATE users SET failed_attempts = :f WHERE id = :id',
                    ['f' => $failed, 'id' => (int)$row['id']]
                );
            }

            throw $invalid;
        }

        // Success → reset counters and stamp last_login
        $this->run(
            'UPDATE users
                SET failed_attempts = 0,
                    lockout_until   = NULL,
                    last_login      = NOW()
              WHERE id = :id',
            ['id' => (int)$row['id']]
        );


        //email notification on login
        try {
            (new Mailer())->send(
                (string)$row['email'],
                'New login to your account',
                '<p>You just signed in. If this wasn’t you, please reset your password.</p>'
            );
        } catch (\Throwable $e) {
            // don’t block login on email failures
        }

        return User::fromArray($row);
    }
}
