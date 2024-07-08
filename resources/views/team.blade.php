<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="{{ asset('img/logoTitle.png') }}" />
    <title>Team Profile</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        body {
            background-color: #f5f5f5;
            color: #333;
        }

        .header {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .background-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-size: cover;
            background-position: center;
            z-index: 0;
            transition: opacity 1s ease-in-out;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1;
        }

        .header-content {
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            position: relative;
        }

        .header h1 {
            font-size: 4rem;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 3px;
            color: #fff;
            background: linear-gradient(90deg, #ff8a00, #e52e71);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: text-animation 3s ease-in-out infinite;
        }

        @keyframes text-animation {

            0%,
            100% {
                clip-path: inset(0 0 0 0);
            }

            50% {
                clip-path: inset(0 50% 0 50%);
            }
        }

        .header p {
            font-size: 1.5rem;
            max-width: 800px;
            margin: 0 auto;
            color: #ddd;
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

        .buttons-section {
            padding: 1rem 0;
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .buttons-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .btn {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 20px;
            background-color: #e0e0e0;
            color: #333;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #d0d0d0;
        }

        .btn.active {
            background-color: #007bff;
            color: #fff;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            gap: 1.5rem;
            padding: 2rem 1rem;
        }

        .gallery-item {
            position: relative;
            /* Tambahkan ini */
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: visible;
            /* Ubah dari hidden menjadi visible */
            width: calc(33% - 1rem);
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .gallery-item:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s;
            /* Tambahkan ini */
            border-bottom: 1px solid #e0e0e0;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
            /* Tambahkan ini untuk memperbesar gambar */
        }

        .gallery-item p {
            padding: 1rem;
            text-align: center;
            line-height: 1.5;
        }

        .role {
            font-weight: bold;
            color: #555;
        }

        .social-media {
            margin-top: 0.1rem;
            display: flex;
            justify-content: center;
        }

        .social-media a {
            margin: 0 0.5rem;
            color: #777;
            transition: color 0.3s;
        }

        .social-media a:hover {
            color: #333;
        }

        .more-details {
            margin-top: 20px;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 30px;
            background: linear-gradient(90deg, #00c6ff, #0072ff);
            color: #fff;
            cursor: pointer;
            transition: transform 0.3s, background 0.3s;
            position: absolute;
            bottom: 60px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 1rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .more-details:hover {
            background: linear-gradient(90deg, #0072ff, #00c6ff);
            transform: translateX(-50%) translateY(-5px);
        }

        .more-details .icon {
            width: 24px;
            height: 24px;
            fill: white;
            animation: bounce 2s infinite;
        }

        @keyframes bounce {

            0%,
            20%,
            50%,
            80%,
            100% {
                transform: translateY(0);
            }

            40% {
                transform: translateY(-10px);
            }

            60% {
                transform: translateY(-5px);
            }
        }

        @keyframes shake {

            0%,
            100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            50% {
                transform: translateX(5px);
            }

            75% {
                transform: translateX(-5px);
            }
        }

        .shake {
            animation: shake 0.5s;
        }
    </style>
</head>

<body>
    <header class="header" id="header">
        <div class="background-overlay" id="backgroundOverlay"
            style="background-image: url('{{ asset('img/us5.jpg') }}');"></div>
        <div class="background-overlay" id="backgroundOverlay2"
            style="opacity: 0; background-img: url('{{ asset('image/us6.jpg') }}');"></div>
        <div class="overlay"></div>
        <div class="header-content">
            <h1>Kelompok <strong>5</strong></h1>
            <p>Rangga Egha Permana, M.Salman Fauzi, Amir Ramadhan, M.Nizar, Pipit, Dewi</p>
            <button class="more-details" onclick="scrollToSection()">
                <span>Swipe Down For Details</span>
                <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <path d="M12 16.5l-6-6 1.41-1.42L12 13.67l4.59-4.59L18 10.5z" />
                </svg>
            </button>
        </div>
        <div class="scroll-icon" onclick="scrollToSection()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M12 16.5l-6-6 1.41-1.42L12 13.67l4.59-4.59L18 10.5z" />
            </svg>
        </div>
    </header>
    <section class="buttons-section">
        <div class="buttons-container">
            <button class="btn active" data-name="kelompok5">Kelompok 5</button>
            <button class="btn" data-name="salman">M. Salman Fauzi</button>
            <button class="btn" data-name="rangga">Rangga Egha Permana</button>
            <button class="btn" data-name="amir">Amir Syahrul Ramadhan</button>
            <button class="btn" data-name="nizar">Nizar Zul Islami</button>
            <button class="btn" data-name="pipit">Pipit Fitria Zahara</button>
            <button class="btn" data-name="dewi">Dewi Puspa Ningrum</button>
        </div>
    </section>
    <section class="gallery ">
        @foreach ($members as $member)
            <div class="gallery-item" id="{{ $member['id'] }}">
                <img src="{{ asset('img/' . $member['image']) }}" alt="{{ $member['name'] }}">
                <p>{{ $member['name'] }}<br>{{ $member['nim'] }}<br><span class="role">{{ $member['role'] }}</span>
                </p>
                <div class="social-media">
                    <a href="{{ $member['instagram'] }}" target="_blank"><i class="fab fa-instagram"></i></a>
                    {{-- <a href="{{ $member['facebook'] }}" target="_blank"><i class="fab fa-facebook"></i></a> --}}
                    <a href="{{ $member['github'] }}" target="_blank"><i class="fab fa-github"></i></a>
                </div>
            </div>
        @endforeach
    </section>
    <script>
        document.querySelectorAll('.btn').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.btn').forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                const name = button.getAttribute('data-name');
                const galleryItem = document.getElementById(name);
                if (galleryItem) {
                    galleryItem.classList.remove('shake');
                    void galleryItem.offsetWidth;
                    galleryItem.classList.add('shake');
                }
                if (name === 'kelompok5') {
                    document.querySelectorAll('.gallery-item').forEach(item => {
                        item.classList.remove('shake');
                        void item.offsetWidth;
                        item.classList.add('shake');
                    });
                }
            });
        });

        function scrollToSection() {
            document.querySelector('.buttons-section').scrollIntoView({
                behavior: 'smooth'
            });
        }

        const images = [
            '{{ asset('img/us.jpg') }}',
            '{{ asset('img/us5.jpg') }}',
            '{{ asset('img/us2.jpg') }}'
        ];

        let currentImageIndex = 0;
        const backgroundOverlay = document.getElementById('backgroundOverlay');
        const backgroundOverlay2 = document.getElementById('backgroundOverlay2');

        function changeBackgroundImage() {
            currentImageIndex = (currentImageIndex + 1) % images.length;
            const nextImage = images[currentImageIndex];
            if (backgroundOverlay.style.opacity == 1) {
                backgroundOverlay2.style.backgroundImage = `url(${nextImage})`;
                backgroundOverlay2.style.opacity = 1;
                backgroundOverlay.style.opacity = 0;
            } else {
                backgroundOverlay.style.backgroundImage = `url(${nextImage})`;
                backgroundOverlay.style.opacity = 1;
                backgroundOverlay2.style.opacity = 0;
            }
        }

        setInterval(changeBackgroundImage, 3000);
    </script>
</body>

</html>
