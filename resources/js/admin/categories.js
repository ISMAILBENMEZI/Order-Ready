window.filterTable = function () {
    const query = document.getElementById('table-search').value.toLowerCase();
    const rows = document.querySelectorAll('#categories-table tbody tr:not(#no-results)');
    let hasVisibleRow = false;

    rows.forEach(row => {
        const name = row.querySelector('.category-name').textContent.toLowerCase();
        if (name.includes(query)) {
            row.style.display = "";
            hasVisibleRow = true;
        } else {
            row.style.display = "none";
        }
    });

    const noResults = document.getElementById('no-results');
    if (noResults) noResults.style.display = hasVisibleRow ? "none" : "table-row";
}

window.openEditModal = function(category) {
    const form = document.getElementById('category-form');
    const methodField = document.getElementById('method-field');
    
    form.action = `/admin/categories/${category.id}/update`;

    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
    
    document.getElementById('category-name-input').value = category.name;
    document.getElementById('category-desc-input').value = category.description || '';
    
    const modal = document.getElementById('category-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

window.toggleModal = function (id) {
    const el = document.getElementById(id);
    const form = document.getElementById('category-form');
    const title = document.getElementById('modal-title');
    const methodField = document.getElementById('method-field');

    if (el.classList.contains('hidden')) {
        el.classList.remove('hidden');
        el.classList.add('flex');
    } else {
        el.classList.add('hidden');
        el.classList.remove('flex');
        form.reset();
        form.action = "/admin/categories/store";
        title.innerText = "Add New Category";
        methodField.innerHTML = "";
    }
}