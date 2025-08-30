<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Reset Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <main class="auth-container">
    <section class="card">
      <h1>Reset Password</h1>

      <!-- Messages -->
      <div id="reset-msg" class="alert" style="display:none;" aria-live="polite"></div>

      
      <form id="reset-form" action="#" method="POST" class="form" novalidate>
      
        <input type="hidden" id="token" name="token" />

        <div class="form-group">
          <label for="new-password">New Password</label>
          <input
            id="new-password"
            name="new_password"
            type="password"
            placeholder="••••••••"
            required
            minlength="8"
            autocomplete="new-password"
          />
          <small class="hint">Minimum 8 characters.</small>
        </div>

        <div class="form-group">
          <label for="confirm-password">Confirm Password</label>
          <input
            id="confirm-password"
            name="confirm_password"
            type="password"
            placeholder="••••••••"
            required
            minlength="8"
            autocomplete="new-password"
          />
        </div>

        <button type="submit" class="btn btn-primary" id="reset-submit">Update Password</button>
      </form>

      <p class="muted mt-16"><a href="auth.php">Back to sign in</a></p>
    </section>
  </main>

  <script src="js/resetpassword.js" defer></script>
</body>
</html>
