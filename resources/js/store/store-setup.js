

document.addEventListener('DOMContentLoaded', () => {
    let currentStep = 1;
    const totalSteps = 3;
    const titles = { 1: 'Store Information', 2: 'Store Categories', 3: 'Store Branding' };

    const updateStep = () => {
        document.querySelectorAll('.step').forEach(s => s.classList.add('hidden'));
        const activeStep = document.getElementById(`step-${currentStep}`);
        if (activeStep) activeStep.classList.remove('hidden');

        document.getElementById('step-title').textContent = titles[currentStep];


        for (let i = 1; i <= 3; i++) {
            const dot = document.getElementById(`dot-${i}`);
            if (dot) {
                if (i === currentStep) {
                    dot.className = 'h-2 w-8 rounded-full bg-blue-600 transition-all duration-500';
                } else if (i < currentStep) {
                    dot.className = 'h-2 w-2 rounded-full bg-emerald-400 transition-all duration-500';
                } else {
                    dot.className = 'h-2 w-2 rounded-full bg-slate-100 transition-all duration-500';
                }
            }
        }

        document.getElementById('prev-btn').classList.toggle('hidden', currentStep === 1);
        document.getElementById('next-btn').classList.toggle('hidden', currentStep === totalSteps);
        document.getElementById('submit-btn').classList.toggle('hidden', currentStep !== totalSteps);
    };

    document.getElementById('next-btn').onclick = () => { if (currentStep < totalSteps) { currentStep++; updateStep(); } };
    document.getElementById('prev-btn').onclick = () => { if (currentStep > 1) { currentStep--; updateStep(); } };

    updateStep();
});