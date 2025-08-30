<?php
namespace App\Models;

use App\Config\Database;

class User {
    public function emailExists(string $email): bool 
    {
        $sql  = "SELECT 1 FROM users WHERE email = :email LIMIT 1";
        $stmt = Database::conn()->prepare($sql);
        $stmt->execute(['email' => strtolower($email)]);
        return (bool) $stmt->fetchColumn();
    }

    public function create(string $fullname, string $email, string $password): int {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql  = "INSERT INTO users (fullname, email, password_hash)
                 VALUES (:fullname, :email, :password_hash)";
        $pdo  = Database::conn();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'fullname'      => $fullname,
            'email'         => strtolower($email),
            'password_hash' => $hash,
        ]);
        return (int) $pdo->lastInsertId();
    }
}

