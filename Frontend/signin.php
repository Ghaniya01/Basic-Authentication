<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';
Dotenv\Dotenv::createImmutable(dirname(__DIR__))->safeLoad();

use App\Model\Login;
use DomainException;

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $auth = new Login();

        $email    = (string)($_POST['email'] ?? '');
        $password = (string)($_POST['password'] ?? '');

        // Authenticate (throws DomainException on invalid/locked)
        $user = $auth->login($email, $password);

        // Set secure session cookie (before session_start)
        session_set_cookie_params([
            'lifetime' => 0,
            'httponly' => true,
            'samesite' => 'Lax',
            'secure'   => !empty($_SERVER['HTTPS']),
        ]);

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        session_regenerate_id(true);

        // Store auth info
        $_SESSION['user_id']       = $user->id;
        $_SESSION['role_id']       = $user->role->value;
        $_SESSION['last_activity'] = time(); // for 30-min inactivity guard

        // Redirect to your app's landing page
        header('Location: /dashboard.php');
        exit;
    } catch (DomainException $e) {
        // "Invalid credentials." or "Account is locked..." etc.
        $error = $e->getMessage();
    } catch (\Throwable $e) {
        $error = 'Something went wrong.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Sign In</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
 <link rel="stylesheet" href="style.css?v=1">

</head>
<body>
  <div class="auth-container">
    <div class="card">
      <h1>Sign In</h1>

      <div id="auth-msg" class="alert" style="display: <?= $error ? 'block' : 'none' ?>;">
        <?= $error ? htmlspecialchars($error, ENT_QUOTES, 'UTF-8') : '' ?>
      </div>

      <form action="" method="POST" class="form" novalidate>
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
            placeholder="••••••••"
            required
            minlength="8"
            autocomplete="current-password"
          />
          <small class="hint">Minimum 8 characters.</small>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>
      </form>

      <div class="auth-links">
        <a href="/forgot-password.php">Forgot password?</a>
        <span>•</span>
        <a class="link-btn" href="signup.php" aria-label="Create an account">Create an account</a>
      </div>
    </div>
  </div>
</body>
</html>
