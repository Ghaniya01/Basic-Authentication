<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <main class="auth-container">
    <section class="card">
      <h1>Dashboard</h1>

      <div class="alert success" id="dash-msg" style="display:none;" aria-live="polite"></div>

      <p class="muted">Welcome back! You’ll be logged out automatically after 30 minutes of inactivity.</p>

      <div class="auth-links" style="margin-top:1rem;">
        <a href="invite.php">Invite Users</a>
        <span>•</span>
        <a href="auth.php">Logout</a>
      </div>
    </section>
  </main>

  <script src="js/dashboard.js" defer></script>
</body>
</html>
