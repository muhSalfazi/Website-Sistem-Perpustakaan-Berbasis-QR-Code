<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Libration Perpustakaan</title>
    <link rel="icon" href="{{ asset('img/logoTitle.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .btn {
            position: relative;
            display: inline-block;
            padding: 20px 40px;
            /* Adjusted padding */
            color: #fff;
            background: linear-gradient(90deg, #03a9f4, #0288d1);
            border: none;
            cursor: pointer;
            border-radius: 50px;
            font-size: 20px;
            /* Adjusted font size */
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
            width: 250px;
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

        /* Styles for eye icon */
        .eye-icon {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 24px;
            color: #999;
            transition: opacity 0.3s ease;
        }

        .eye-icon svg {
            width: 24px;
            height: 24px;
        }

        .user-box {
            position: relative;
        }

        .password-input {
            transition: opacity 0.3s ease;
        }

        .password-visible {
            opacity: 0.5;
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
                    <input type="password" name="password" placeholder="" id="password" class="password-input">
                    <label>Password</label>
                    <span class="eye-icon" onclick="togglePasswordVisibility()">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zm0 12c-2.57 0-4.67-2.07-4.67-4.63S9.43 7.37 12 7.37s4.67 2.07 4.67 4.63S14.57 16.5 12 16.5zm0-7.13c-1.34 0-2.43 1.08-2.43 2.4s1.09 2.4 2.43 2.4 2.43-1.08 2.43-2.4-1.09-2.4-2.43-2.4z"
                                fill="currentColor" />
                            <path d="M0 0h24v24H0z" fill="none" />
                        </svg>
                    </span>
                </div>
                <div class="user-box">
                    <input type="text" name="captcha" placeholder="">
                    <label>Captcha</label>
                </div>
                <div class="captcha-container">
                    <div class="captcha">
                        <img src="{{ captcha_src() }}" alt="captcha">
                    </div>
                    <div class="countdown">
                        <span id="countdown-timer">60</span> detik sebelum captcha diperbarui.
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
        document.addEventListener("DOMContentLoaded", function() {
            var countdownElement = document.getElementById('countdown-timer');
            var countdown = 60;
            var interval = setInterval(function() {
                countdown--;
                countdownElement.textContent = countdown;
                if (countdown <= 0) {
                    var captchaImage = document.querySelector('img[alt="captcha"]');
                    if (captchaImage) {
                        captchaImage.src = captchaImage.src.split('?')[0] + '?' + new Date().getTime();
                    }
                    countdown = 60;
                }
            }, 1000); // Update every second
        });

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const passwordType = passwordInput.getAttribute('type');
            if (passwordType === 'password') {
                passwordInput.setAttribute('type', 'text');
                passwordInput.classList.add('password-visible');
            } else {
                passwordInput.setAttribute('type', 'password');
                passwordInput.classList.remove('password-visible');
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
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

        document.getElementById('login-form').addEventListener('submit', function(event) {
            const btn = document.querySelector('.btn');
            btn.classList.add('loading');
            btn.querySelector('span').style.display = 'none';
            btn.querySelector('.loader').style.display = 'block';
        });
    </script>

    <script>
        // Cegah klik kanan
        document.addEventListener("contextmenu", function(event) {
            alert("Inspect element tidak diizinkan!");
            event.preventDefault();
        });

        // Cegah tombol F12
        document.addEventListener("keydown", function(event) {
            if (event.key === "F12" || event.keyCode === 123) {
                alert("Inspect element tidak diizinkan!");
                event.preventDefault();
            }
        });

        // Cegah tombol ctrl+shift+i
        document.addEventListener("keydown", function(event) {
            if (event.ctrlKey && event.shiftKey && event.key === "I") {
                alert("Inspect element tidak diizinkan!");
                event.preventDefault();
            }
        });
    </script>

</body>

</html>
