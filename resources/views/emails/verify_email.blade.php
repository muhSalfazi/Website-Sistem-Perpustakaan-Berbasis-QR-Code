<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            /* background-color: #f4f4f4; */
            text-align: center;
            padding: 20px;
        }

        h2 {
            color: #333;
        }

        p {
            color: #666;
        }

        .otp {
            font-size: 20px;
            font-weight: bold;
            color: #007bff;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    {{-- <img src="{{ asset('img/logoTitle.png') }}" alt="Logo" class="logo"> --}}
    <h2>Verifikasi Email</h2>
    <p>Kode OTP untuk verifikasi email Anda adalah: <span class="otp">{{ $otp }}</span></p>
    <p>Terima kasih.</p>
</body>

</html>
