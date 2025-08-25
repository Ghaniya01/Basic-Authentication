<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Auth</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="style.css?v=1">
</head>

<body>

  <div class="auth-container">
    <div class="card">
      <h1 id="auth-title">Sign In</h1>

      <div id="auth-msg" class="alert" style="display:none;"></div>
      
      <form id="auth-form" action="" method="POST" class="form">
        
        <div class="form-group" id="group-fullname" style="display:none;">
          <label for="fullname">Full Name</label>
          <input
            type="text"
            id="fullname"
            name="fullname"
            placeholder="Full name"
            autocomplete="name"
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

        <button type="submit" class="btn btn-primary" id="auth-submit">Login</button>
      </form>

      <div class="auth-links">
        <a href="forgotpassword.php" id="forgot-link">Forgot password?</a>
        <span>•</span>
        <button id="toggle-mode" class="link-btn" type="button">Create an account</button>
      </div>
    </div>
  </div>

 <script src="JS/auth.js" defer></script>
  
</body>
</html>
