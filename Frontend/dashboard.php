<?php require_once 'partials/header.layout.php'; ?>

      <h1>Dashboard</h1>

      <div class="alert success" id="dash-msg" style="display:none;" aria-live="polite"></div>

      <p class="muted">Welcome back, <?php echo user()?->fullname ?>! You’ll be logged out automatically after 30 minutes of inactivity.</p>

      <div class="auth-links" style="margin-top:1rem;">
        <a href="invite.php">Invite Users</a>
        <span>•</span>
        <a href="auth.php">Logout</a>
      </div>

<?php require_once 'partials/footer.layout.php'; ?>