<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Invite User</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <main class="auth-container">
    <section class="card">
      <h1>Invite New User</h1>

      <div id="invite-msg" class="alert" style="display:none;" aria-live="polite"></div>

      <form id="invite-form" action="#" method="POST" class="form" novalidate>
        <div class="form-group">
          <label for="email">User Email</label>
          <input id="email" name="email" type="email" placeholder="new.user@example.com" required autocomplete="email" />
        </div>

        <button type="submit" class="btn btn-primary">Send Invite</button>
      </form>

      <p class="muted mt-16">
        <a href="dashboard.php">Back to dashboard</a>
      </p>
    </section>
  </main>

  <script src="js/invite.js" defer></script>
</body>
</html>
