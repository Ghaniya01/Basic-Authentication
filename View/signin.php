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

      <div id="auth-msg" class="alert" style="display:none;"></div>

      <form action="/auth/login" method="POST" class="form" novalidate>
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
        <a href="forgotpassword.php">Forgot password?</a>
        <span>•</span>
        <a class="link-btn" href="signup.html" aria-label="Create an account">Create an account</a>
      </div>
    </div>
  </div>

</body>
</html>
