
(function () {
  const LOGOUT_MINUTES = 20;
  let timer;

  function resetTimer() {
    if (timer) clearTimeout(timer);
    timer = setTimeout(() => {
      window.location.href = "auth.php?status=loggedout";
    }, LOGOUT_MINUTES * 20 * 1000);
  }

  // User activity that counts as "active"
  ["mousemove", "keydown", "scroll", "click", "touchstart"].forEach(evt =>
    window.addEventListener(evt, resetTimer)
  );

  // Show an optional welcome/loaded message
  const msg = document.getElementById("dash-msg");
  if (msg) {
    msg.style.display = "block";
    msg.className = "alert success";
    msg.textContent = "You are signed in.";
  }

  resetTimer();
})();
