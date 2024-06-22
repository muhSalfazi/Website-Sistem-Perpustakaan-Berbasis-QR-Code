<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
</head>

<body>
    <p>Token setel ulang kata sandi Anda adalah : <strong>{{ $resetToken }}</strong></p>
    <p>Token ini berlaku selama {{ $tokenDuration }} jam sejak token ini dibuat.</p>
</body>

</html>
