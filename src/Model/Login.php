<?php
declare(strict_types=1);

namespace App\Service\Auth;
use App\Config\Database;
use App\Validation\Validator;
use DomainException;
use App\Objects\User;

class Login extends Database
{
    //Set maximum attemept to login to 5 and locks screen for 15 minutes 
    private const MAX_ATTEMPTS = 5;
    private const LOCK_MINUTES = 15;

    private Validator $v;
    public function __construct(?Validator $v = null)
    {
        parent::__construct();
        $this->v = $v ?? new Validator(8);
    }

    public function login(string $email, string $password):User
    {
        $email = $this->v->email($email);
        $invalid = new DomainException('Invalid credentials.');

        $row = $this->run(
            'SELECT id, fullname, email, role_id, password_hash, failed_attempts, lockout_until
               FROM users WHERE email = :email LIMIT 1',
            ['email' => $email]
        )->fetch();

        if (!$row) throw $invalid;

        if (!empty($row['lockout_until']) && strtotime((string)$row['lockout_until']) > time()) {
            throw new DomainException('Account is locked. Try again later.');
        }
// *compare the passwords to what is on the database, if it doesnt match, increment the failed login and if limit is hit, lock screen 
//when failure reach limit, reset counter to 0 and lock until 15 minutes

        if (!password_verify($password, (string)$row['password_hash'])) {
            $failed = (int)$row['failed_attempts'] + 1;
            if ($failed >= self::MAX_ATTEMPTS) {
                $this->run('UPDATE users SET failed_attempts=0, lockout_until=DATE_ADD(NOW(), INTERVAL :m MINUTE) WHERE id=:id',
                           ['m'=>self::LOCK_MINUTES,'id'=>(int)$row['id']]);
            } else {
                $this->run('UPDATE users SET failed_attempts=:f WHERE id=:id',
                           ['f'=>$failed,'id'=>(int)$row['id']]);
            }
            throw $invalid;
        }

        $this->run('UPDATE users SET failed_attempts=0, lockout_until=NULL, last_login=NOW() WHERE id=:id',
                   ['id'=>(int)$row['id']]);


        return User::fromArray($row);
    }
}
