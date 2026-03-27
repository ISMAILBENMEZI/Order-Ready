// نضع window. لكي تكون الدالة متاحة في كل المشروع
window.showAlert = function (message, type = "error") {
    const alertBox = document.getElementById("form-alert");

    if (!alertBox) {
        alert(message); // fallback في حال عدم وجود الـ div
        return;
    }

    alertBox.innerText = message;
    const baseClasses = "fixed top-6 left-1/2 -translate-x-1/2 px-6 py-4 rounded-2xl shadow-xl text-sm font-bold z-50 transition-all duration-300 ";
    const typeClasses = type === "error"
        ? "bg-red-100 text-red-700 border border-red-200"
        : "bg-emerald-100 text-emerald-700 border border-emerald-200";

    alertBox.className = baseClasses + typeClasses;
    alertBox.classList.remove("hidden");

    // إخفاء تلقائي بعد 5 ثوانٍ
    setTimeout(() => {
        alertBox.classList.add("hidden");
    }, 5000);
};