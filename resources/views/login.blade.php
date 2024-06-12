<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Libration Perpustakaan</title>
    <link href="{{ asset('img/logoTitle.png') }}" rel="icon" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div class="container">
        <div class="login-box">
            <img src="{{ asset('img/logo.png') }}" alt="Libra Nation Logo" class="logo">
            <h2>Login</h2>
            <form id="login-form" action="{{ route('login') }}" method="POST" onsubmit="return validateForm(event)">
                @csrf
                <div class="user-box">
                    <input type="email" name="email" placeholder="">
                    <label>Email</label>
                </div>
                <div class="user-box">
                    <input type="password" name="password" placeholder="">
                    <label>Password</label>
                </div>
                <button type="submit" class="btn">
                    <span>Login</span>
                    <div class="loader"></div>
                </button>
            </form>
        </div>
    </div>
    <script>
        function validateForm(event) {
            const email = document.querySelector('input[name="email"]').value;
            const password = document.querySelector('input[name="password"]').value;

            if (!email || !password) {
                event.preventDefault(); // Prevent form submission
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Email atau Kata Sandi diperlukan!',
                    width: '300px', // Smaller width
                    timer: 1000,
                    showConfirmButton: false,
                });
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }

        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    width: '300px', // Smaller width
                    timer: 1000,
                    showConfirmButton: false,
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    width: '300px', // Smaller width
                    timer: 1000,
                    showConfirmButton: false,
                });
            @endif
        });
    </script>
</body>

</html>
