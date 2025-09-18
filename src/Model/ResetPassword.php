<?php
declare(strict_types=1);

namespace App\Service\Auth;

use App\Config\Database;
use App\Validation\Validator;
use App\Support\Mailer;
use DomainException;

final class ResetPassword extends Database
{
    private Validator $v;

    public function __construct(?Validator $v = null)
    {
        parent::__construct();
        $this->v = $v ?? new Validator(8);
    }

    public function apply(string $token, string $newPassword, ?string $confirm = null): void
    {
        $this->v->password($newPassword, $confirm); // length + match

        $hash = hash('sha256', $token);
        $row = $this->run(
            'SELECT pr.id, pr.user_id, pr.expires_at, pr.used_at, u.email, u.password_hash
               FROM password_resets pr
               JOIN users u ON u.id = pr.user_id
              WHERE pr.token_hash = :h
              LIMIT 1',
            ['h' => $hash]
        )->fetch();

        if (!$row || $row['used_at'] !== null || strtotime((string)$row['expires_at']) < time()) {
            throw new DomainException('Invalid or expired reset link.');
        }

        // Must differ from current
        if (password_verify($newPassword, (string)$row['password_hash'])) {
            throw new DomainException('New password must be different from the old one.');
        }

        $newHash = password_hash($newPassword, PASSWORD_DEFAULT);

        $this->run('UPDATE users SET password_hash = :h WHERE id = :id', [
            'h' => $newHash, 'id' => (int)$row['user_id']
        ]);

        $this->run('UPDATE password_resets SET used_at = NOW() WHERE id = :id', [
            'id' => (int)$row['id']
        ]);

        try {
            (new Mailer())->send(
                (string)$row['email'],
                'Your password was changed',
                '<p>Your password was successfully changed. If this wasn’t you, contact support.</p>'
            );
        } catch (\Throwable $e) {}
    }
}
