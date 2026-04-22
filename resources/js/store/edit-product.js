document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('edit-product-form');

    const deletedImagesInputs = document.getElementById('deleted-images');
    const galleryWrapper = document.getElementById('gallery-wrapper');

    const galleryInput = form.querySelector('input[name="imagesinternal[]"]');

    let deletedImages = [];
    let newImages = [];

    document.querySelectorAll('.delete-image-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const imageId = this.getAttribute('data-id');

            deletedImages.push(imageId);

            this.closest('.relative').remove();
        });
    });

    galleryInput.addEventListener('change', function () {
        const files = Array.from(this.files);

        newImages = [...newImages, ...files];

        renderNewImages();

        this.value = "";
    });

    function renderNewImages() {
        document.querySelectorAll('.new-image-preview').forEach(el => el.remove());

        newImages.forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function (e) {
                const div = document.createElement('div');
                div.className = "relative aspect-square bg-white rounded-xl border overflow-hidden shadow-sm group new-image-preview";

                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-contain p-1">
                    <button type="button"
                        class="absolute top-1 right-1 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center opacity-100 shadow-lg"
                        data-index="${index}">
                        <i class="fa-solid fa-times text-xs"></i>
                    </button>
                `;

                div.querySelector('button').addEventListener('click', function () {
                    const i = this.getAttribute('data-index');
                    newImages.splice(i, 1);
                    renderNewImages();
                });
                galleryWrapper.insertBefore(div, galleryWrapper.lastElementChild);
            };

            reader.readAsDataURL(file);
        });
    }

    const primaryInput = document.getElementById('primary-input');
    const primaryPreview = document.getElementById('primary-preview');
    const noImageText = document.getElementById('no-image-text');

    primaryInput.addEventListener('change', function () {
        const file = this.files[0];

        if (file) {
            const reader = new FileReader();

            reader.onload = function (e) {
                primaryPreview.src = e.target.result;
                primaryPreview.classList.remove('hidden');

                if (noImageText)
                    noImageText.classList.add('hidden');
            };

            reader.readAsDataURL(file);
        }
    });

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(form);

        formData.set('deleted_images', JSON.stringify(deletedImages));

        newImages.forEach((file) => {
            formData.append('imagesinternal[]', file);
        });

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
            .then(async res => {
                const text = await res.text();
                try {
                    const data = JSON.parse(text);
                    if (res.ok && data.success) {
                        window.location.href = data.redirect;
                    } else {
                        window.showAlert(data.message || "Error updating product", "error");
                    }
                } catch (err) {
                    console.error('Response is not JSON:', text);
                    window.showAlert("Server Error: Check the logs", "error");
                }
            })
    });

});