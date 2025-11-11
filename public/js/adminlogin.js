// Password visibility toggle
const passwordInput = document.getElementById("password");
const toggleBtn = document.getElementById("passwordToggle");

toggleBtn.addEventListener("click", () => {
  const isPassword = passwordInput.type === "password";
  passwordInput.type = isPassword ? "text" : "password";
  toggleBtn.classList.toggle("active");
});

// Form validation
const form = document.getElementById("loginForm");
const email = document.getElementById("email");
const password = document.getElementById("password");
const emailError = document.getElementById("emailError");
const passwordError = document.getElementById("passwordError");
const loginBtn = document.querySelector(".login-btn");
const loader = document.querySelector(".btn-loader");
const btnText = document.querySelector(".btn-text");

form.addEventListener("submit", (e) => {
  e.preventDefault();

  let valid = true;
  emailError.textContent = "";
  passwordError.textContent = "";

  // Email validation
  const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
  if (!email.value.match(emailPattern)) {
    emailError.textContent = "Enter a valid email address";
    valid = false;
  }

  // Password validation
  if (password.value.length < 6) {
    passwordError.textContent = "Password must be at least 6 characters";
    valid = false;
  }

  // If valid, show loading animation
  if (valid) {
    btnText.textContent = "Logging in...";
    loader.style.display = "inline-block";
    loginBtn.disabled = true;

    setTimeout(() => {
      btnText.textContent = "Login Successful ✅";
      loader.style.display = "none";
      loginBtn.style.background = "linear-gradient(135deg, #00b894, #0984e3)";
    }, 1500);
  }
});