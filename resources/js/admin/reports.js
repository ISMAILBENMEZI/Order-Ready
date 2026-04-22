function openBanModal(reportId, productId) {
    const reportInput = document.getElementById('modal_report_id');
    const productInput = document.getElementById('modal_product_id');
    const modal = document.getElementById('actionModal');

    if (reportInput && productInput && modal) {
        reportInput.value = reportId;
        productInput.value = productId;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeModal() {
    const modal = document.getElementById('actionModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

window.openBanModal = openBanModal;
window.closeModal = closeModal;

document.addEventListener('click', function (e) {
    const btn = e.target.closest('.btn-take-action');
    if (btn) {
        const reportId = btn.dataset.report;
        const productId = btn.dataset.product;
        openBanModal(reportId, productId);
    }
});

window.onclick = function (event) {
    const modal = document.getElementById('actionModal');
    if (event.target === modal) {
        closeModal();
    }
}