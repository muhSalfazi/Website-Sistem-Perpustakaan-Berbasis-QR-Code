<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>welcome</title>
</head>

<body>

    <h1>halaman utama</h1>
    <h2>Lorem ipsum dolor sit amet consectetur adipisicing elit. Porro nam quia obcaecati quae at earum, omnis sit enim eveniet debitis inventore quo magnam delectus, eaque illo, quas blanditiis hic aliquam.</h2>
    <script>
        window.onload = function() {
            // Mengganti entri terbaru dalam history dengan halaman selamat datang
            window.history.replaceState(null, null, window.location.href);

            // Mengarahkan pengguna kembali ke halaman selamat datang saat tombol "back" ditekan
            window.addEventListener('popstate', function() {
                window.location.replace("{{ route('welcome') }}");
            });
        };
    </script>


</body>

</html>
