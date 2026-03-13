document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("login-form");
    const passwordInput = document.getElementById("password-input");
    const togglePasswordBtn = document.getElementById("toggle-password");
    const eyeOpen = document.getElementById("eye-open");
    const eyeClosed = document.getElementById("eye-closed");
    const alertBox = document.getElementById("form-alert");

    const showAlert = (message, type = "error") => {
        if (!alertBox) return;

        alertBox.textContent = message;

        if (type === "error") {
            alertBox.className =
                "fixed top-6 left-1/2 -translate-x-1/2 px-6 py-4 rounded-2xl shadow-xl text-sm font-bold z-50 bg-red-100 text-red-700 border border-red-200";
        } else {
            alertBox.className =
                "fixed top-6 left-1/2 -translate-x-1/2 px-6 py-4 rounded-2xl shadow-xl text-sm font-bold z-50 bg-emerald-100 text-emerald-700 border border-emerald-200";
        }

        alertBox.classList.remove("hidden");

        setTimeout(() => {
            alertBox.classList.add("hidden");
        }, 5000);
    };

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
                showAlert("Email is required.");
                return;
            }

            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                e.preventDefault();
                showAlert("Please enter a valid email address.");
                return;
            }

            if (!password) {
                e.preventDefault();
                showAlert("Password is required.");
                return;
            }

            if (password.length < 6) {
                e.preventDefault();
                showAlert("Password must be at least 6 characters.");
                return;
            }
        });
    }
});