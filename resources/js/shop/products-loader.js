document.addEventListener('DOMContentLoaded', function () {
    let page = 2;
    const btn = document.getElementById('load-more-btn');
    const container = document.getElementById('products-container');

    if (btn) {
        btn.addEventListener('click', function () {
            const baseUrl = this.getAttribute('data-url');

            btn.disabled = true;
            const originalText = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Loading...';
            fetch(`${baseUrl}?page=${page}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(res => res.text())
                .then(data => {
                    if (data.trim() === "") {
                        btn.style.display = "none";
                        return;
                    }

                    container.insertAdjacentHTML('beforeend', data);

                    page++;
                    btn.disabled = false;
                    btn.innerHTML = originalText;
                })
                .catch(error => {
                    console.error('Error loding products:', error);
                    btn.disabled = false;
                    btn.innerHTML = "try Again";
                });
        });
    }
});