<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Libration Perpustakaan</title>
    <link href="{{ asset('img/logoTitle.png') }}" rel="icon" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .btn {
            position: relative;
            display: inline-block;
            padding: 20px 40px; /* Adjusted padding */
            color: #fff;
            background: linear-gradient(90deg, #03a9f4, #0288d1);
            border: none;
            cursor: pointer;
            border-radius: 50px;
            font-size: 20px; /* Adjusted font size */
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s ease-in-out;
            overflow: hidden;
            z-index: 1;
            animation: pulse 2s infinite, gradient 3s ease infinite;
        }

        .btn:hover {
            transform: scale(1.1);
            box-shadow: 0 0 20px rgba(3, 169, 244, 0.6);
        }

        .btn:before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: radial-gradient(circle at top right, rgb(36, 9, 119) 0%, rgb(36, 9, 119) 48%, rgb(72, 7, 149) 48%, rgb(72, 7, 149) 53%, rgb(109, 5, 178) 53%, rgb(109, 5, 178) 56%, rgb(145, 2, 208) 56%, rgb(145, 2, 208) 69%, rgb(181, 0, 237) 69%, rgb(181, 0, 237) 100%);
            border-radius: 30%;
            transform: translate(-50%, -50%) scale(0);
            transition: transform 0.5s;
            z-index: -1;
        }

        .btn:hover:before {
            transform: translate(-50%, -50%) scale(1);
        }

        .btn .loader {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 40px;
            height: 40px;
            background: linear-gradient(90deg, #fff, #bbb);
            border-radius: 50px;
            animation: slide 1s infinite ease-in-out;
            opacity: 0;
            transform: translate(-50%, -50%) scale(0.5);
            transition: all 0.5s ease-in-out;
        }

        .btn.loading .loader {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }

        .btn.loading span {
            opacity: 0;
            transform: scale(0.5);
        }

        @keyframes slide {
            0%,
            100% {
                transform: translate(-50%, -50%) translateX(-20px);
            }

            50% {
                transform: translate(-50%, -50%) translateX(20px);
            }
        }

        @keyframes pulse {
            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 rgba(0, 0, 0, 0.1);
            }

            50% {
                transform: scale(1.05);
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            }
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }

            100% {
                background-position: 0% 50%;
            }
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .btn:hover:after {
            content: '';
            position: absolute;
            top: -5px;
            left: -5px;
            right: -5px;
            bottom: -5px;
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-radius: 50px;
            animation: rotate 1.5s linear infinite;
        }

        .captcha-container {
            margin-top: 10px;
            margin-bottom: 10px;
            text-align: center;
        }

        .captcha {
            display: inline-block;
            padding: 10px;
            border: 2px solid #03a9f4;
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease-in-out;
            background: linear-gradient(135deg, rgba(3, 169, 244, 0.2), rgba(2, 136, 209, 0.2));
        }

        .captcha img {
            width: 180px;
            height: auto;
            display: block;
            transition: opacity 0.3s ease-in-out;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            background: linear-gradient(135deg, rgba(3, 169, 244, 0.4), rgba(2, 136, 209, 0.4));
        }

        .captcha:before,
        .captcha:after {
            content: '';
            position: absolute;
            width: 50%;
            height: 100%;
            top: 0;
            transition: transform 0.3s ease-in-out;
            z-index: -1;
        }

        .captcha:before {
            left: 0;
            background: rgba(3, 169, 244, 0.2);
        }

        .captcha:after {
            right: 0;
            background: rgba(2, 136, 209, 0.2);
        }

        .captcha:hover:before {
            transform: translateX(100%);
        }

        .captcha:hover:after {
            transform: translateX(-100%);
        }

        /* CSS for page transition */
        .page-transition {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: white;
            z-index: 9999;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .page-transition.active {
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="page-transition" id="page-transition"></div>
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
                <div class="user-box">
                    <input type="text" name="captcha" placeholder="">
                    <label>Captcha</label>
                </div>
                <div class="captcha-container">
                    <div class="captcha">
                        <img src="{{ captcha_src() }}" alt="Captcha Image">
                    </div>
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
                    timer: 6000,
                    showConfirmButton: true,
                });
                return false; // Cegah pengiriman formulir
            }

            const button = document.querySelector('.btn');
            button.classList.add('loading');

            // Trigger page transition
            const pageTransition = document.getElementById('page-transition');
            pageTransition.classList.add('active');

            // Wait for the transition to complete before allowing form submission
            setTimeout(function() {
                document.getElementById('login-form').submit();
            }, 500); // Duration of the transition

            return false; // Temporarily prevent form submission
        }

        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    width: '300px', // Smaller width
                    timer: 5000,
                    showConfirmButton: true,
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
                    width: '300px', // Smaller width
                    timer: 5000,
                    showConfirmButton: true,
                });
            @endif
        });
    </script>
</body>

</html>
