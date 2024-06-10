<!-- resources/views/layouts/footer.blade.php -->
<footer class="py-6 px-6 text-center">
    <p class="mb-0 fs-4">Design and Developed by <a href="https://ubpkarawang.ac.id/" target="_blank"
            class="pe-1 text-primary text-decoration-underline">MhsYubifiKRW</a></p>
</footer>
<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/sidebarmenu.js"></script>
<script src="../assets/js/app.min.js"></script>
    <script src="../assets/js/dashboard.js"></script>

<script>
    function confirmLogout() {
        if (confirm("Apakah Anda yakin ingin keluar?")) {
            document.getElementById('logout-form').submit();
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXlD6/8fQzt+3Q9fMdT6DRhcvwY1kp4fjYNFEO2U0lK4JsYkLf8Y9gltKGLS" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhG1qiD1T6GkJt7E2YfIouuWE1cQEOstzF4iqp1rIwKtOf+SZAxTOQE2akKx" crossorigin="anonymous">
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        new simpleDatatables.DataTable('.datatable');
    });
</script>

</body>

</html>
