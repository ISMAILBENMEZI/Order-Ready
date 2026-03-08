document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("register-form");

    if (!form) return;

    const showAlert = (message) => {
        const alertBox = document.getElementById("form-alert");

        alertBox.innerText = message;

        alertBox.className =
            "fixed top-6 left-1/2 -translate-x-1/2 px-6 py-4 rounded-2xl shadow-xl text-sm font-bold z-50 bg-red-100 text-red-700 border border-red-200";

        alertBox.classList.remove("hidden");

        setTimeout(() => {
            alertBox.classList.add("hidden");
        }, 5000);
    };

    form.addEventListener("submit", (e) => {
        const name = document.querySelector('input[name="name"]').value.trim();
        const email = document.querySelector('input[name="email"]').value.trim();
        const password = document.querySelector('input[name="password"]').value.trim();
        const role = document.querySelector('select[name="role_id"]').value;
        const password_confirmation = document.querySelector('input[name="password_confirmation"]').value.trim();

        if (!name) {
            e.preventDefault();
            showAlert("Name is required.");
            return;
        }

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

        if (password !== password_confirmation) {
            e.preventDefault();
            showAlert("Passwords do not match!");
            return;
        }

        if (!role) {
            e.preventDefault();
            showAlert("Please select an account type.");
            return;
        }
    });
});