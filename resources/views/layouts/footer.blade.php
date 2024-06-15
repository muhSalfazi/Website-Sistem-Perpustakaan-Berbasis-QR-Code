<!-- resources/views/layouts/footer.blade.php -->
<footer class="py-6 px-6 text-center">
    <p class="mb-0 fs-4">Design and Developed by <a href="https://ubpkarawang.ac.id/" rel="noopener noreferrer"
            target="_blank" class="pe-1 text-primary text-decoration-underline">MhsYubifiKRW</a></p>
</footer>

<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>

<script>
    function confirmLogout() {
        if (confirm("Apakah Anda yakin ingin keluar?")) {
            document.getElementById('logout-form').submit();
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Santai, ini hanya kode javascript sederhana
        new simpleDatatables.DataTable('.datatable');
    });
</script>
