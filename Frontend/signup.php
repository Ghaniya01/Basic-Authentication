<?php
$error =' nothing to show';
$csrf = '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Create Account</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="/Frontend/style.css" />

</head>
<body>
  <div class="auth-container">
    <div class="card">
      <h1>Create Account</h1>

      <div id="auth-msg" class="alert" style="display: <?= $error ? 'block' : 'none' ?>;">
        <?= $error ? htmlspecialchars($error, ENT_QUOTES, 'UTF-8') : '' ?>
      </div>

      <form action="/signup" method="POST" class="form" novalidate>
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
