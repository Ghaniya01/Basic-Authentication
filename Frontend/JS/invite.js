
(function () {
  const form = document.getElementById("invite-form");
  const msg  = document.getElementById("invite-msg");

  function showMessage(text, type = "success") {
    msg.style.display = "block";
    msg.className = `alert ${type}`;
    msg.textContent = text;
  }

  form.addEventListener("submit", (e) => {
    const email = form.email.value.trim();

    if (!email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      e.preventDefault();
      return showMessage("Please enter a valid email address.", "error");
    }


  });
})();
