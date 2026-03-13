document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('product-form');
    const alertBox = document.getElementById('form-alert');

    const primaryInput = form.querySelector('input[name="primary_image"]');
    const primaryPreviewContainer = document.getElementById('primary-preview-container');
    const primaryPreviewImg = document.getElementById('primary-preview');
    const removePrimaryBtn = primaryPreviewContainer.querySelector('button');

    const galleryInput = form.querySelector('input[type="file"][multiple]');
    const galleryPreviewContainer = document.getElementById('gallery-preview');

    primaryInput.addEventListener('change', function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                primaryPreviewImg.src = e.target.result;
                primaryPreviewContainer.classList.remove('hidden');
                primaryInput.parentElement.querySelector('.space-y-2').classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    removePrimaryBtn.addEventListener('click', function (e) {
        e.preventDefault();
        primaryInput.value = "";
        primaryPreviewContainer.classList.add('hidden');
        primaryInput.parentElement.querySelector('.space-y-2').classList.remove('hidden');
    });

    let galleryFiles = [];

    galleryInput.addEventListener('change', function () {
        const newFiles = Array.from(this.files);
        galleryFiles = [...galleryFiles, ...newFiles];
        renderGallery();
        this.value = "";
    });

    function renderGallery() {
        galleryPreviewContainer.innerHTML = "";

        galleryFiles.forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function (e) {
                const div = document.createElement('div');
                div.className = "relative group shadow-sm rounded-xl overflow-hidden h-24";
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-full object-cover">
                    <button type="button" 
                        class="absolute top-1 right-1 bg-red-500 text-white w-5 h-5 rounded-full flex items-center justify-center text-[10px] shadow-lg hover:bg-red-600 transition-colors"
                        onclick="removeFromGallery(${index})">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                `;
                galleryPreviewContainer.appendChild(div);
            }

            reader.readAsDataURL(file);
        });
    }

    window.removeFromGallery = function (index) {
        galleryFiles.splice(index, 1);
        renderGallery();
    }

    form.addEventListener('submit', function (e) {
        e.preventDefault();
        let errors = [];

        const name = form.name.value.trim();
        const description = form.description.value.trim();
        const price = parseFloat(form.price.value);
        const discountInput = form.discount_price.value;
        const category = form.category_id.value;
        const primaryImage = form.primary_image.files[0];

        if (!name) {
            errors.push("Product name is required.");
        } else if (name.length > 255) {
            errors.push("Product name cannot exceed 255 characters.");
        }

        if (!description) {
            errors.push("Description is required.");
        }

        if (isNaN(price)) {
            errors.push("Price is required and must be a number.");
        } else if (price < 0) {
            errors.push("Price cannot be less than 0.");
        }

        if (discountInput) {
            const discount = parseFloat(discountInput);

            if (isNaN(discount || discount < 0)) {
                errors.push("Discount must be a valid positive number.");
            }
            else if (discount >= price) {
                errors.push("Discount price must be less than the original price.");
            }
        }

        if (!category) {
            errors.push("Please select a category.");
        }

        if (!primaryImage) {
            errors.push("Primary image is required.");
        }
        else {
            const allowedExtensions = ['png', 'jpg', 'jpeg', 'gif'];
            const fileExtension = primaryImage.name.split('.').pop().toLowerCase();

            if (!allowedExtensions.includes(fileExtension)) {
                errors.push("Primary image must be a png, jpg, jpeg, or gif.");
            }

            if (primaryImage.size > 2 * 1024 * 1024) {
                errors.push("Primary image size must be less than 2MB.");
            }
        }

        if (errors.length > 0) {
            e.preventDefault();
            showAlert(errors[0]);
            return;
        }

        const formData = new FormData(form);

        formData.delete('images[]');

        galleryFiles.forEach((file, index) => {
            formData.append('imagesinternal[' + index + ']', file);
        });

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                    document.querySelector('input[name="_token"]')?.value
            }
        })
            .then(async response => {
                const data = await response.json();
                if (response.ok && data.success) {
                    window.location.href = data.redirect;
                } else {
                    showAlert(data.message || "Validation Error");
                    console.error('Server Error:', data);
                }
            })
            .catch(error => {
                console.error('Fetch Error:', error);
                showAlert("Check your internet or server connection");
            });
    });

    function showAlert(message) {
        if (alertBox) {
            alertBox.innerText = message;
            alertBox.classList.remove('hidden', 'bg-green-500', 'text-white');
            alertBox.classList.add('bg-red-500', 'text-white', 'block');
            alertBox.className = "fixed top-6 left-1/2 -translate-x-1/2 px-6 py-4 rounded-2xl shadow-xl text-sm font-bold z-50 bg-red-100 text-red-700 border border-red-200";


            alertBox.style.opacity = "0";

            setTimeout(() => {
                alertBox.style.opacity = "1";
            }, 10);

            window.scrollTo({ top: 0, behavior: 'smooth' });

            setTimeout(() => {
                alertBox.classList.add('hidden');
            }, 5000);
        }
        else {
            alert(message);
        }
    }
});