document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("login-form");
    const passwordInput = document.getElementById("password-input");
    const togglePasswordBtn = document.getElementById("toggle-password");
    const eyeOpen = document.getElementById("eye-open");
    const eyeClosed = document.getElementById("eye-closed");
    const alertBox = document.getElementById("form-alert");

    if (togglePasswordBtn && passwordInput) {
        togglePasswordBtn.addEventListener("click", () => {
            const isPassword = passwordInput.type === "password";

            passwordInput.type = isPassword ? "text" : "password";

            if (eyeOpen && eyeClosed) {
                eyeOpen.classList.toggle("hidden", isPassword);
                eyeClosed.classList.toggle("hidden", !isPassword);
            }
        });
    }

    if (form) {
        form.addEventListener("submit", (e) => {
            const email = document.querySelector('input[name="email"]')?.value.trim();
            const password = document.querySelector('input[name="password"]')?.value.trim();

            if (!email) {
                e.preventDefault();
                window.showAlert("Email is required.", "error");
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                e.preventDefault();
                window.showAlert("Please enter a valid email address.", "error");
                return;
            }

            if (!password) {
                e.preventDefault();
                window.showAlert("Password is required.", "error");
                return;
            }

            if (password.length < 6) {
                e.preventDefault();
                window.showAlert("Password must be at least 6 characters.", "error");
                return;
            }
        });
    }
});