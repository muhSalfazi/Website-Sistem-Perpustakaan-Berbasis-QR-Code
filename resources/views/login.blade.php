<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Libration Perpustakaan</title>
    <link href="{{ asset('img/logoTitle.png') }}" rel="icon" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-popup {
            font-size: 0.8rem !important;
            width: auto !important;
            max-width: 250px !important;
            padding: 1.5rem !important;
        }

        .swal2-title {
            font-size: 1.1rem !important;
        }

        .swal2-content {
            font-size: 0.9rem !important;
        }

        /* Prevent page from shifting when SweetAlert is active */
        body.swal2-active {
            overflow: hidden;
        }
    </style>
</head>
<script>
    function validateForm() {
        const username = document.querySelector('input[name="username"]').value;
        const password = document.querySelector('input[name="password"]').value;

        if (!username || !password) {
            document.body.classList.add('swal2-active'); // Add class to body
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Username and Password are required!',
                customClass: {
                    popup: 'swal2-popup',
                    title: 'swal2-title',
                    content: 'swal2-content'
                },
                didClose: () => {
                    document.body.classList.remove(
                    'swal2-active'); // Remove class when SweetAlert is closed
                }
            });
            return false; // Prevent form submission
        }
        return true; // Allow form submission
    }
</script>

<body>
    <div class="login">
        <h2>Login</h2>
    </div>
    <div class="container">
        <div class="login-box">
            <form id="login-form" action="{{ route('login') }}" method="POST" onsubmit="return validateForm()">
                @csrf
                <div class="input-group">
                    <input type="email" name="email" placeholder="email">
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="password">
                </div>
                <div class="input-group">
                    <button type="submit">Login</button>
                </div>
            </form>
        </div>
        <div class="logo">
            <img src="{{ asset('img/logo.png') }}">
        </div>
    </div>


</body>

</html>
