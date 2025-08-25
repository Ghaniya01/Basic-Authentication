<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Forgot Password</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="auth-container">
    <div="card">
      <h1>Forgot Password</h1>

      <div id="forgot-msg" class="alert" style="display:none;" aria-live="polite"></div>

      <form id="forgot-form" action="#" method="POST" class="form" novalidate>
        <div class="form-group">
          <label for="email">Email Address</label>
          <input id="email" name="email" type="email" placeholder="you@example.com" required autocomplete="email" />
        </div>

        <button type="submit" class="btn btn-primary">Send reset link</button>
      </form>

      <p class="muted mt-16">
        <a href="auth.php">Back to sign in</a>
      </p>
    </div>
  </div>

  <script src="js/forgotpassword.js" defer></script>
</body>
</html>
