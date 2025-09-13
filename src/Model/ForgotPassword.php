<?php
declare(strict_types=1);

namespace App\Service\Auth;

use App\Config\Database;
use App\Validation\Validator;
use App\Support\Mailer; // your Mailtrap wrapper (or swap with PHPMailer directly)

final class ForgotPassword extends Database
{
    private const EXPIRES_MIN = 120; // 2 hours
    private Validator $v;

    public function __construct(?Validator $v = null)
    {
        parent::__construct();
        $this->v = $v ?? new Validator(8);
    }

    /** Always return the same UX; only send when email exists. */
    public function sendLink(string $email): void
    {
        // Don’t block on invalid format; but you can validate if you prefer:
        $email = strtolower(trim($email));

        $row = $this->run('SELECT id FROM users WHERE email = :e LIMIT 1', ['e' => $email])->fetch();
        if ($row) {
            $userId = (int)$row['id'];
            $token  = bin2hex(random_bytes(32));   // 64-char token
            $hash   = hash('sha256', $token);

            $this->run(
                'INSERT INTO password_resets (user_id, token_hash, expires_at)
                 VALUES (:u, :h, DATE_ADD(NOW(), INTERVAL :m MINUTE))',
                ['u' => $userId, 'h' => $hash, 'm' => self::EXPIRES_MIN]
            );

            $appUrl   = rtrim($_ENV['APP_URL'] ?? '', '/');
            $resetUrl = $appUrl . '/reset-password.php?token=' . $token;

            try {
                (new Mailer())->send(
                    $email,
                    'Reset your password',
                    "<p>We received a request to reset your password.</p>
                     <p><a href=\"{$resetUrl}\">Reset password</a> (valid for 2 hours).</p>"
                );
            } catch (\Throwable $e) { /* don’t leak */ }
        }

        // Controller/view should always show:
        // “If that email exists, we’ve sent a password reset link.”
    }
}
