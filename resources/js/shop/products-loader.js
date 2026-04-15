document.addEventListener('DOMContentLoaded', function () {
    const btn = document.getElementById('load-more-btn');
    const container = document.getElementById('products-container');

    if (!btn) return;


    btn.addEventListener('click', function () {
        const url = btn.getAttribute('data-url');

        if (!url) return;

        btn.disabled = true;
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Loading...';

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(res => res.json())
            .then(data => {

                container.insertAdjacentHTML('beforeend', data.html);
                btn.setAttribute('data-url', data.next_page);

                if (!data.next_page) {
                    btn.style.display = "none";
                }

                btn.disabled = false;
                btn.innerHTML = originalText;
            })
            .catch(error => {
                console.error('Error loding products:', error);
                btn.disabled = false;
                btn.innerHTML = "try Again";
            });
    });

});