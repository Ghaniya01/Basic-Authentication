<?php
declare(strict_types=1);

namespace App\Model;

use App\Config\Database;
use App\Enums\Role;
use App\Validation\Validator;
use App\Objects\User;
use DomainException;
use PDOException;

class Register extends Database
{
    private Validator $v;

    public function __construct(?Validator $validator = null)
    {
        parent::__construct();
        $this->v = $validator ?? new Validator(8);
    }

    public function register(string $fullname, string $email, string $password, ?string $confirm = null):User
    {
     
        $fullname = $this->v->name($fullname);
        $email    = $this->v->email($email);
        $this->v->password($password, $confirm);

        if ($this->emailExists($email)) {
            throw new DomainException('Email already registered.');
        }

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (fullname, email, password_hash, role_id)
                VALUES (:fullname, :email, :password_hash, :role_id)";

        try {
            // try to make first signup SuperAdmin
            $this->run($sql, [
                'fullname'      => $fullname,
                'email'         => $email,
                'password_hash' => $hash,
                'role_id'       => Role::SuperAdmin->value,
            ]);
        } catch (PDOException $e) {
            $sqlState = $e->getCode();            // '23000' = integrity violation
            $driver   = $e->errorInfo[1] ?? null; // 1062 = duplicate key (MySQL)

            // super-admin seat taken (duplicate key) and email isn't a dup → fall back to User
            if ($sqlState === '23000' && $driver === 1062 && !$this->emailExists($email)) {
                $this->run($sql, [
                    'fullname'      => $fullname,
                    'email'         => $email,
                    'password_hash' => $hash,
                    'role_id'       => Role::User->value,
                ]);
            } else {
                throw $e; 
            }
        }

        $id = (int)$this->lastInsertId();

       
        $row = $this->run(
            'SELECT id, fullname, email, role_id, created_at FROM users WHERE id = :id LIMIT 1',
            ['id' => $id]
        )->fetch();

        if (!$row) {
            throw new \RuntimeException('User created but could not be reloaded.');
        }

        return User::fromArray($row);
    }

    
    public function emailExists(string $email): bool
    {
        return (bool)$this->run(
            'SELECT 1 FROM users WHERE email = :email LIMIT 1',
            ['email' => $email]
        )->fetchColumn();
    }
}
