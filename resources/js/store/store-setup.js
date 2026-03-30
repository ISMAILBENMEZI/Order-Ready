document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('store-setup-form');
    let currentStep = Number(form?.dataset.oldStep || 1);
    const totalSteps = 3;

    const nextBtn = document.getElementById('next-btn');
    const prevBtn = document.getElementById('prev-btn');
    const submitBtn = document.getElementById('submit-btn');

    const titles = {
        1: 'Store Information',
        2: 'Store Categories',
        3: 'Store Branding'
    };

    const Max_SIZE = 5 * 1024 * 1024;
    const validateFileSize = (input) => {
        const file = input.files[0];
        if (file && file.size > Max_SIZE) {
            window.showAlert("This file is too big! Please choose a file smaller than 8MB.", "error");
            input.value = "";
            return false;
        }
        return true;
    };

    document.getElementById('logo-input').addEventListener('change', function () { validateFileSize(this); });
    document.getElementById('banner-input').addEventListener('change', function () { validateFileSize(this); });

    const validateStep = () => {
        if (currentStep === 1) {
            const name = document.querySelector('input[name="name"]').value.trim(); // تصحيح inpute و value
            const description = document.querySelector('textarea[name="description"]').value.trim();
            const location = document.querySelector('input[name="location"]').value.trim();
            const email = document.querySelector('input[name="contact_email"]').value.trim();
            const phone = document.querySelector('input[name="contact_phone"]').value.trim();

            if (!name || !description || !location || !email || !phone) {
                window.showAlert("Please fill all information in Step 1.", "error");
                return false;
            }
        }

        if (currentStep === 2) {
            const categories = document.querySelectorAll('input[name="categories[]"]:checked');
            if (categories.length === 0) {
                window.showAlert("Please select at least one category.", "error");
                return false;
            }
        }

        return true;
    };

    const updateStep = () => {
        document.querySelectorAll('.step').forEach(step => step.classList.add('hidden'));

        const activeStep = document.getElementById(`step-${currentStep}`);
        if (activeStep) activeStep.classList.remove('hidden');

        const stepTitle = document.getElementById('step-title');
        if (stepTitle) stepTitle.textContent = titles[currentStep];

        for (let i = 1; i <= totalSteps; i++) {
            const dot = document.getElementById(`dot-${i}`);
            if (!dot) continue;
            if (i === currentStep) {
                dot.className = 'h-2 w-8 rounded-full bg-blue-600 transition-all duration-500';
            } else if (i < currentStep) {
                dot.className = 'h-2 w-2 rounded-full bg-emerald-400 transition-all duration-500';
            } else {
                dot.className = 'h-2 w-2 rounded-full bg-slate-100 transition-all duration-500';
            }
        }

        if (prevBtn) prevBtn.classList.toggle('hidden', currentStep === 1);
        if (nextBtn) nextBtn.classList.toggle('hidden', currentStep === totalSteps);
        if (submitBtn) submitBtn.classList.toggle('hidden', currentStep !== totalSteps);
    };

    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            if (validateStep()) {
                if (currentStep < totalSteps) {
                    currentStep++;
                    updateStep();
                }
            }
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            if (currentStep > 1) {
                currentStep--;
                updateStep();
            }
        });
    }

    const bindImagePreview = (inputId, previewId, placeholderId) => {
        const input = document.getElementById(inputId);
        const preview = document.getElementById(previewId);
        const placeholder = document.getElementById(placeholderId);

        if (!input || !preview || !placeholder) return;

        input.addEventListener('change', (event) => {
            const file = event.target.files[0];
            if (file) {
                const fileUrl = URL.createObjectURL(file);
                preview.src = fileUrl;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
        });
    };

    bindImagePreview('logo-input', 'logo-preview', 'logo-placeholder');
    bindImagePreview('banner-input', 'banner-preview', 'banner-placeholder');

    updateStep();
});