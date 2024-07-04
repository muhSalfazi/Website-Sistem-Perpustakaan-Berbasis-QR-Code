<!-- resources/views/layouts/footer.blade.php -->
<footer class="py-6 px-6 text-center animate-fade-in">
    <p class="mb-0 fs-4">Design and Developed by 
        <a href="https://ubpkarawang.ac.id/" rel="noopener noreferrer" target="_blank" 
           class="pe-1 text-primary animate-hover">MhsYubifiKRW</a>
    </p>
</footer>

<script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/js/dashboard.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Santai, ini hanya kode javascript sederhana
        if (typeof simpleDatatables !== 'undefined') {
            new simpleDatatables.DataTable('.datatable');
        }
    });

    function confirmLogout() {
        if (confirm("Apakah Anda yakin ingin keluar?")) {
            document.getElementById('logout-form').submit();
        }
    }
</script>

<!-- Custom CSS for animations and modern look -->
<style>
    footer {
        color: #ffffff;
        padding: 20px 0;
        position: relative;
        overflow: hidden;
    }

    footer p {
        margin: 0;
        padding: 0;
        font-family: 'Roboto', sans-serif;
        font-size: 18px;
        color: #adb5bd;
    }

    footer a {
        color: #ffdd57;
        text-decoration: none;
        transition: color 0.3s ease-in-out, transform 0.3s ease-in-out;
        position: relative;
    }

    footer a::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 2px;
        bottom: -2px;
        left: 0;
        background-color: #050C9C;
        visibility: hidden;
        transform: scaleX(0);
        transition: all 0.3s ease-in-out;
    }

    footer a:hover::after {
        visibility: visible;
        transform: scaleX(1);
    }

    footer a:hover {
        color: #ff6b6b;
        transform: translateY(-2px);
    }

    .animate-hover {
        position: relative;
        display: inline-block;
    }

    @keyframes hoverAnimation {
        from {
            transform: translateY(0);
        }
        to {
            transform: translateY(-5px);
        }
    }

    .animate-fade-in {
        animation: fadeIn 2s ease-in-out;
    }

    @keyframes fadeIn {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
</body>
</html>
