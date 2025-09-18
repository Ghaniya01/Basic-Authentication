<?php
declare(strict_types=1);

namespace App\Support;

use PHPMailer\PHPMailer\PHPMailer;

final class Mailer
{
    private PHPMailer $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->isSMTP();
        $this->mail->Host       = $_ENV['MAIL_HOST'] ?? 'sandbox.smtp.mailtrap.io';
        $this->mail->Port       = (int)($_ENV['MAIL_PORT'] ?? 2525);
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $_ENV['MAIL_USER'] ?? '';
        $this->mail->Password   = $_ENV['MAIL_PASS'] ?? '';
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $this->mail->CharSet    = 'UTF-8';

        $fromEmail = $_ENV['MAIL_FROM'] ?? 'noreply@example.com';
        $fromName  = $_ENV['MAIL_FROM_NAME'] ?? 'Authentication';
        $this->mail->setFrom($fromEmail, $fromName);
        $this->mail->isHTML(true);
    }

    public function send(string $to, string $subject, string $html): void
    {
        try {
            $this->mail->clearAllRecipients();
            $this->mail->addAddress($to);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $html;
            $this->mail->AltBody = strip_tags($html);
            $this->mail->send();
        } catch (\Throwable $e) {
         
        }
    }
}
