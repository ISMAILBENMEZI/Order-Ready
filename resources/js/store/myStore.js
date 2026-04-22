
function showAlert(message, type = "error") {
    const alertBox = document.getElementById("form-alert");
    if (!alertBox) {
        alert(message);
        return;
    }

    alertBox.innerText = message;
    const baseClasses = "fixed top-6 left-1/2 -translate-x-1/2 px-6 py-4 rounded-2xl shadow-xl text-sm font-bold z-50 transition-all duration-300 ";
    const typeClasses = type === "error"
        ? "bg-red-100 text-red-700 border border-red-200"
        : "bg-emerald-100 text-emerald-700 border border-emerald-200";

    alertBox.className = baseClasses + typeClasses;
    alertBox.classList.remove("hidden");

    setTimeout(() => {
        alertBox.classList.add("hidden");
    }, 5000);
}

window.deleteProduct = function (id) {
    if (!confirm('Are you sure you want to delete this product?')) return;

    const productCard = document.getElementById('product-' + id);

    fetch(`/seller/my-store/product/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json',
        },
    })
        .then(res => {
            if (!res.ok) throw new Error('Failed to delete');
            return res.json();
        })
        .then(data => {
            if (productCard) {
                productCard.style.opacity = '0';
                productCard.style.transform = 'scale(0.95)';
                setTimeout(() => productCard.remove(), 300);
            }

            showAlert(data.message || "Product deleted successfully!", "success");
        })
        .catch(err => {
            console.error('Delete Error:', err);
            showAlert("Something went wrong. Please try again.", "error");
        });
}