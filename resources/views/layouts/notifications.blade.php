<div id="form-alert"
    class="fixed top-6 left-1/2 -translate-x-1/2 hidden px-6 py-4 rounded-2xl shadow-xl text-sm font-bold z-50 transition-all duration-300">
</div>

@if (session('success'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof window.showAlert === 'function') {
                window.showAlert("{{ session('success') }}", "success");
            }
        });
    </script>
@endif

@if (session('error'))
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof window.showAlert === 'function') {
                window.showAlert("{{ session('error') }}", "error");
            }
        });
    </script>
@endif
