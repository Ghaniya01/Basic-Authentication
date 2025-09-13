<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
Dotenv\Dotenv::createImmutable(dirname(__DIR__))->safeLoad();

use App\Model\Register;
use DomainException;

// --- CSRF (simple) ---
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (empty($_SESSION['csrf'])) { $_SESSION['csrf'] = bin2hex(random_bytes(32)); }
$csrf = $_SESSION['csrf'];

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // CSRF check
        if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
            throw new DomainException('Invalid form token.');
        }

        $reg  = new Register();
        $user = $reg->register(
            $_POST['fullname'] ?? '',
            $_POST['email'] ?? '',
            $_POST['password'] ?? '',
        );

        // Auto-login (optional)
        session_regenerate_id(true);
        $_SESSION['user_id']       = $user->id;
        $_SESSION['role_id']       = $user->role->value;
        $_SESSION['last_activity'] = time();

        header('Location: /dashboard.php');
        exit;
    } catch (\InvalidArgumentException|DomainException $e) {
        $error = $e->getMessage();          // validation or domain errors
    } catch (\Throwable $e) {
        $error = 'Something went wrong.';   // generic fallback
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Create Account</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="style.css?v=1">

</head>
<body>
  <div class="auth-container">
    <div class="card">
      <h1>Create Account</h1>

      <div id="auth-msg" class="alert" style="display: <?= $error ? 'block' : 'none' ?>;">
        <?= $error ? htmlspecialchars($error, ENT_QUOTES, 'UTF-8') : '' ?>
      </div>

      <form action="" method="POST" class="form" novalidate>
        <input type="hidden" name="csrf" value="<?= htmlspecialchars($csrf, ENT_QUOTES, 'UTF-8') ?>">

        <div class="form-group">
          <label for="fullname">Full Name</label>
          <input
            type="text"
            id="fullname"
            name="fullname"
            placeholder="Full name"
            required
            autocomplete="name"
            value="<?= isset($_POST['fullname']) ? htmlspecialchars((string)$_POST['fullname'], ENT_QUOTES, 'UTF-8') : '' ?>"
          />
        </div>

        <div class="form-group">
          <label for="email">Email Address</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="you@example.com"
            required
            autocomplete="email"
            inputmode="email"
            value="<?= isset($_POST['email']) ? htmlspecialchars((string)$_POST['email'], ENT_QUOTES, 'UTF-8') : '' ?>"
          />
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input
            type="password"
            id="password"
            name="password"
            placeholder="Create a password"
            required
            minlength="8"
            autocomplete="new-password"
          />
          <small class="hint">Minimum 8 characters.</small>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>
      </form>

      <div class="auth-links">
        <a class="link-btn" href="signin.php" aria-label="Have an account? Sign in">Have an account? Sign in</a>
      </div>
    </div>
  </div>
</body>
</html>
