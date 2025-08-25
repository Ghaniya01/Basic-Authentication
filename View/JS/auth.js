
    (function () {
      const MODE = { SIGNIN: "signin", SIGNUP: "signup" };

      const form = document.getElementById("auth-form");
      const title = document.getElementById("auth-title");
      const submitBtn = document.getElementById("auth-submit");
      const toggleBtn = document.getElementById("toggle-mode");
      const forgotLink = document.getElementById("forgot-link");
      const groupFullname = document.getElementById("group-fullname");
      const passwordInput = document.getElementById("password");
      const msg = document.getElementById("auth-msg");

      let mode = MODE.SIGNIN;

      function applyMode() {
        if (mode === MODE.SIGNIN) {
          title.textContent = "Sign In";
          submitBtn.textContent = "Login";
          toggleBtn.textContent = "Create an account";
          forgotLink.style.display = "";
          groupFullname.style.display = "none";
          form.setAttribute("action", "/auth/login"); 
          passwordInput.setAttribute("autocomplete", "current-password");
        } else {
          title.textContent = "Create Account";
          submitBtn.textContent = "Register";
          toggleBtn.textContent = "Have an account? Sign in";
          forgotLink.style.display = "none";
          groupFullname.style.display = "";
          form.setAttribute("action", "/auth/register"); 
          passwordInput.setAttribute("autocomplete", "new-password");
        }
      }

      toggleBtn.addEventListener("click", () => {
        mode = mode === MODE.SIGNIN ? MODE.SIGNUP : MODE.SIGNIN;
        applyMode();
        // reset messages on toggle
        msg.style.display = "none";
        msg.textContent = "";
        msg.className = "alert";
      });

    })();
 