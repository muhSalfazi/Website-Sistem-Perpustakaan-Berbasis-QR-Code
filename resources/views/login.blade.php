<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Animated Glassmorphism Login Page | @codingstella</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    .swal2-popup {
        font-size: 1rem;
        width: auto !important;
        max-width: 300px;
    }

    .swal2-title {
        font-size: 1.3rem;
    }

    .swal2-content {
        font-size: 1rem;
    }

    /* Gaya untuk pesan error */
    .error-message {
        background-color: #ffe6e6;
        /* Warna latar belakang */
        border: 1px solid #ff4d4d;
        /* Warna border */
        color: #cc0000;
        /* Warna teks */
        padding: 10px;
        /* Padding */
        border-radius: 5px;
        /* Border radius */
        margin-bottom: 10px;
        /* Margin bawah */
        font-size: 14px;
        /* Ukuran font */
    }

    /* Gaya untuk tanda seru */
    .exclamation {
        color: red;
        /* Warna merah */
        font-size: 20px;
        /* Ukuran font */
        margin-right: 5px;
        /* Margin kanan */
    }

    /* Gaya untuk border merah */
    input.error {
        border: 1px solid #ff4d4d !important;
    }
</style>

<body>
    <section>
        <img src="{{ asset('img/bg.jpg') }}" class="bg">
        <div class="login">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                @if (session('error'))
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: '{{ session('error') }}',
                            customClass: {
                                popup: 'swal2-popup',
                                title: 'swal2-title',
                                content: 'swal2-content'
                            }
                        });
                    </script>
                @endif

                <div class="logo-container">
                    <img src="{{ asset('img/logo.png') }}" class="logo">
                </div>
                <h2>Sign In</h2>
                <div class="inputBox">
                    <input type="text" placeholder="email" name="email" value="{{ old('email') }}"
                        class="@error('password') error @enderror">
                    {{-- @error('email')
                        <div class="error-message"><span class="exclamation">!</span>The email field is required.</div>
                    @enderror --}}
                </div>
                <div class="inputBox">
                    <input type="password" placeholder="Password" name="password"
                        class="@error('password') error @enderror">
                    @error('password')
                        <div class="error-message"><span class="exclamation">!</span>email & password wajib di isi.</div>
                    @enderror
                </div>
                <div class="inputBox">
                    <input type="submit" value="Login" id="btn">
                </div>
            </form>
        </div>
    </section>
</body>

</html>
