@extends('layouts.app')

@section('title', 'Cari Peminjaman')

@section('content')
    <div class="container-fluid">
        <!-- Tombol Kembali -->
        <a href="{{ route('peminjaman') }}"
            class="btn btn-outline-primary mb-3 animate__animated animate__fadeInLeft modern-btn">
            <i class="ti ti-arrow-left"></i> Kembali
        </a>

        <!-- Kartu Utama -->
        <div class="card shadow-lg rounded-lg border-0 animate__animated animate__fadeInUp">
            <!-- Menampilkan Kesalahan -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX" role="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Menampilkan Pesan Kesalahan dari Session -->
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX"
                    role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Alert Member Ditemukan dan Tidak Ditemukan -->
            <div id="memberFoundAlert"
                class="alert alert-success alert-dismissible fade show d-none animate__animated animate__fadeInDown"
                role="alert">
                Member ditemukan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div id="memberNotRegisteredAlert"
                class="alert alert-danger alert-dismissible fade show d-none animate__animated animate__fadeInDown"
                role="alert">
                Member tidak ditemukan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>

            <div class="card-body">
                <div class="row justify-content-center">
                    <!-- Kolom Scan QR -->
                    <div class="col-12 col-md-6 mb-4 text-center">
                        <h5 class="card-title fw-bold">Scan QR peminjaman / anggota</h5>
                        <div id="reader"
                            style="width: 100%; height: 320px; border: 2px dashed #007bff; border-radius: 10px;"></div>
                        <button id="start-scan"
                            class="btn btn-outline-primary mt-3 animate__animated animate__bounceIn modern-btn">Mulai
                            Scan</button>
                        <button id="stop-scan"
                            class="btn btn-outline-danger mt-3 d-none animate__animated animate__bounceIn modern-btn">Berhenti
                            Scan</button>
                    </div>

                    <!-- Kolom Pencarian Email -->
                    <div class="col-12 col-md-6 mb-4">
                        <h5 class="card-title fw-bold mb-4 text-center">Atau cari anggota / buku</h5>
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Masukkan Email Anggota">
                            <button class="btn btn-outline-primary animate__animated animate__pulse modern-btn"
                                onclick="searchMemberByEmail()">Cari</button>
                        </div>
                        <div class="invalid-feedback"></div>
                    </div>
                </div>

                <!-- Tabel Anggota -->
                <div class="row justify-content-center d-none" id="memberTableContainer">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table text-center table-hover table-striped">
                                <thead class="table-white">
                                    <tr>
                                        <th scope="col">ID</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Telepon</th>
                                        <th scope="col">Alamat</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="memberTableBody">
                                    <!-- Baris tabel akan dimasukkan secara dinamis -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CSS Styles -->
    <style>
        .profile-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }

        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }

        .modern-btn {
            background: linear-gradient(90deg, rgba(58, 123, 213, 1) 0%, rgba(0, 212, 255, 1) 100%);
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 30px;
            transition: all 0.3s ease;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        .modern-btn .ti {
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .modern-btn:hover {
            background: linear-gradient(90deg, rgba(0, 212, 255, 1) 0%, rgba(58, 123, 213, 1) 100%);
            transform: scale(1.05);
        }

        .modern-btn:hover .ti-plus {
            transform: rotate(90deg);
        }
    </style>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/libs/html5-qrcode/html5-qrcode.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let html5QrCode;
        let qrCodeSuccessCallback;

        $(document).ready(function() {
            // Initialize the QR Code scanner instance
            html5QrCode = new Html5Qrcode("reader");

            // Event listener for starting the scan
            $('#start-scan').click(function() {
                $('#start-scan').addClass('d-none');
                $('#stop-scan').removeClass('d-none');
                startQrCodeScanner();
            });

            // Event listener for stopping the scan
            $('#stop-scan').click(function() {
                stopQrCodeScanner();
                $('#start-scan').removeClass('d-none');
                $('#stop-scan').addClass('d-none');
            });
        });

        function startQrCodeScanner() {
            qrCodeSuccessCallback = function(decodedText, decodedResult) {
                stopQrCodeScanner();
                $('#start-scan').removeClass('d-none');
                $('#stop-scan').addClass('d-none');
                handleQrCodeScanned(decodedText);
            };

            html5QrCode.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250
                    } // Adjust the qrbox size for mobile
                },
                qrCodeSuccessCallback
            ).catch(err => {
                console.error(`Error starting QR code scanner: ${err}`);
            });
        }

        function stopQrCodeScanner() {
            html5QrCode.stop().then(ignore => {
                console.log("QR Code scanning stopped.");
            }).catch(err => {
                console.error(`Error stopping QR code scanner: ${err}`);
            });
        }

        function handleQrCodeScanned(decodedText) {
            // Kosongkan isi tabel sebelum menampilkan hasil pemindaian QR code yang baru
            $('#memberTableBody').empty();
            // Sembunyikan alert jika sebelumnya ditampilkan
            $('#memberFoundAlert').addClass('d-none');
            $('#memberNotRegisteredAlert').addClass('d-none');
            // Sembunyikan kepala tabel jika tidak ada hasil
            $('thead').addClass('d-none');

            $.ajax({
                url: "{{ route('scan.member.by.qrcode') }}",
                type: 'GET',
                data: {
                    qr_code: decodedText
                },
                success: function(response) {
                    if (response.member) {
                        // Check if updated_at is more than 1 minute ago
                        let updatedAt = new Date(response.member.updated_at);
                        let now = new Date();
                        let timeDifference = now.getTime() - updatedAt.getTime();
                        let minuteDifference = Math.floor((timeDifference / 1000) / 60);

                        if (minuteDifference > 1) {
                            // Tampilkan pesan kedaluwarsa jika lebih dari 1 menit telah berlalu
                            Swal.fire({
                                icon: 'error',
                                title: 'QR Code Expired',
                                text: 'Kode QR telah kedaluwarsa. Silakan coba lagi.',
                                showConfirmButton: true,
                                timer: 4500
                            });
                        } else {
                            // Tampilkan data anggota di halaman
                            $('#memberTableBody').html(`
                            <tr>
                                <td>${response.member.id}</td>
                                <td>${response.member.first_name} ${response.member.last_name}</td>
                                <td>${response.member.email}</td>
                                <td>${response.member.phone}</td>
                                <td>${response.member.address}</td>
                                <td>
                                    <img src="{{ asset('/profiles') }}/${response.member.imageProfile}" alt="Profile Image" class="profile-image">
                                </td>
                                <td>
                                    <form action="{{ route('search.book.page') }}" method="GET">
                                        <input type="hidden" name="member_id" value="${response.member.id}">
                                        <button type="submit" class="btn btn-outline-success animate__animated animate__heartBeat">
                                            <i class="bi bi-check2-circle"></i> Pilih
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        `);
                            // Tampilkan pemberitahuan bahwa anggota ditemukan
                            Swal.fire({
                                icon: 'success',
                                title: 'Member ditemukan',
                                showConfirmButton: true,
                                timer: 3500
                            });
                            // Tampilkan kepala tabel
                            $('thead').removeClass('d-none');
                            // Tampilkan tabel
                            $('#memberTableContainer').removeClass('d-none');
                        }
                    } else {
                        // Tampilkan pemberitahuan bahwa nama qr-code tidak ditemukan
                        Swal.fire({
                            icon: 'error',
                            title: 'Member tidak ditemukan',
                            text: 'Nama QR Code tidak terdaftar',
                            showConfirmButton: true,
                            timer: 2500
                        });
                    }
                },
                error: function(xhr, status, thrown) {
                    console.log(thrown);
                    Swal.fire({
                        icon: 'error',
                        title: 'member tidak terdaftar',
                        text: 'Silakan coba lagi.',
                        showConfirmButton: true,
                        timer: 3500
                    });
                }
            });
        }

        function searchMemberByEmail() {
            const email = $('#email').val();
            // Clear table content before displaying new search result
            $('#memberTableBody').empty();
            // Hide alert if previously shown
            $('#memberFoundAlert').addClass('d-none');
            $('#memberNotRegisteredAlert').addClass('d-none');
            // Hide table head if no result
            $('thead').addClass('d-none');

            $.ajax({
                url: "{{ route('search.member.by.email') }}",
                type: 'GET',
                data: {
                    email: email
                },
                success: function(response) {
                    if (response.member) {
                        // Display member data on the page
                        $('#memberTableBody').html(`
                        <tr>
                            <td>${response.member.id}</td>
                            <td>${response.member.first_name} ${response.member.last_name}</td>
                            <td>${response.member.email}</td>
                            <td>${response.member.phone}</td>
                            <td>${response.member.address}</td>
                            <td>
                                <img src="{{ asset('/profiles') }}/${response.member.imageProfile}" alt="Profile Image" class="profile-image">
                            </td>
                            <td>
                                <form action="{{ route('search.book.page') }}" method="GET">
                                    <input type="hidden" name="member_id" value="${response.member.id}">
                                    <button type="submit" class="btn btn-outline-success animate__animated animate__heartBeat">
                                        <i class="bi bi-check2-circle"></i> Pilih
                                    </button>
                                </form>
                            </td>
                        </tr>
                    `);
                        // Display alert that member was found
                        Swal.fire({
                            icon: 'success',
                            title: 'Member ditemukan',
                            showConfirmButton: true,
                            timer: 2500
                        });
                        // Show table head
                        $('thead').removeClass('d-none');
                        // Show table
                        $('#memberTableContainer').removeClass('d-none');
                    } else {
                        // Display alert that email is not registered
                        Swal.fire({
                            icon: 'error',
                            title: 'Member tidak ditemukan',
                            text: 'Email member tidak terdaftar',
                            showConfirmButton: true,
                            timer: 2500
                        });
                    }
                },
                error: function(xhr, status, thrown) {
                    console.log(thrown);
                    Swal.fire({
                        icon: 'error',
                        title: 'member tidak terdaftar',
                        text: 'Silakan coba lagi.',
                    });
                }
            });
        }
    </script>

@endsection
