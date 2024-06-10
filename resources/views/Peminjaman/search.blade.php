@extends('layouts.app')

@section('title', 'Search Peminjaman')

@section('content')
    <div class="container-fluid">
        <!-- Content Start -->
        <a href="{{ route('peminjaman') }}" class="btn btn-outline-primary mb-3">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>

        <div class="card">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div id="memberFoundAlert" class="alert alert-success alert-dismissible fade show d-none" role="alert">
                Member ditemukan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div id="memberNotRegisteredAlert" class="alert alert-danger alert-dismissible fade show d-none" role="alert">
                Member tidak ditemukan.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-6">
                        <h5 class="card-title fw-semibold">Scan QR peminjaman / anggota</h5>
                        <!-- QR Code scanning UI -->
                        <div id="reader" width="600px"></div>
                        <button id="start-scan" class="btn btn-primary mt-3">Start Scan</button>
                        <button id="stop-scan" class="btn btn-danger mt-3 d-none">Stop Scan</button>
                    </div>

                    <div class="col-12 col-md-6">
                        <h5 class="card-title fw-semibold mb-4">Atau cari anggota / buku</h5>
                        <!-- Search by email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Masukkan Email Anggota</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                            <div class="invalid-feedback"></div>
                        </div>
                        <button class="btn btn-primary" onclick="searchMemberByEmail()">Cari</button>
                    </div>
                </div>
                <div class="row justify-content-center d-none" id="memberTableContainer">
                    <!-- Hide table container initially -->
                    <div class="col-12">
                        <!-- Table to display member data -->
                        <div class="table-responsive"> <!-- Make table responsive -->
                            <table class="table text-center"> <!-- Center table content -->
                                <thead>
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
                                    <!-- Table rows will be inserted here dynamically -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/libs/html5-qrcode/html5-qrcode.min.js') }}"></script>

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
                    qrbox: 300
                }, qrCodeSuccessCallback)
                .catch(err => {
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
                        // Tampilkan data anggota di halaman
                        $('#memberTableBody').html(`
                            <tr>
                                <td>${response.member.id}</td>
                                <td>${response.member.first_name} ${response.member.last_name}</td>
                                <td>${response.member.email}</td>
                                <td>${response.member.phone}</td>
                                <td>${response.member.address}</td>
                                <td>
                                    <img src="{{ asset('/profiles') }}/${response.member.imageProfile}" alt="Profile Image" width="50">
                                </td>
                                <td>
                                    <form action="{{ route('search.book.page') }}" method="GET">
                                        <input type="hidden" name="member_id" value="${response.member.id}">
                                        <button type="submit" class="btn btn-outline-success">
                                            <i class="bi bi-check2-circle"></i> Pilih
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        `);
                        // Tampilkan pemberitahuan bahwa anggota ditemukan
                        $('#memberFoundAlert').removeClass('d-none');
                        // Tampilkan kepala tabel
                        $('thead').removeClass('d-none');
                        // Tampilkan tabel
                        $('#memberTableContainer').removeClass('d-none');
                    } else if (response.error === 'Email member tidak terdaftar') {
                        // Tampilkan pemberitahuan bahwa email tidak terdaftar
                        $('#memberNotRegisteredAlert').removeClass('d-none');
                    } else {
                        // Handle other possible errors
                        alert('Terjadi kesalahan. Silakan coba lagi.');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle Ajax error
                    console.error(error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        }

        function searchMemberByEmail() {
            var email = $('#email').val();

            // Cek apakah email telah diisi
            if (!email) {
                alert('Email belum diisi. Silakan masukkan email.');
                return;
            }

            // Kosongkan isi tabel sebelum melakukan pencarian baru
            $('#memberTableBody').empty();
            // Sembunyikan alert jika sebelumnya ditampilkan
            $('#memberFoundAlert').addClass('d-none');
            $('#memberNotRegisteredAlert').addClass('d-none');
            // Sembunyikan kepala tabel
            $('thead').addClass('d-none');

            $.ajax({
                url: "{{ route('search.member.by.email') }}",
                type: 'GET',
                data: {
                    email: email
                },
                success: function(response) {
                    if (response.member) {
                        // Member found, populate table row
                        $('#memberTableBody').html(
                            `<tr>
                            <td>${response.member.id}</td>
                            <td>${response.member.first_name} ${response.member.last_name}</td>
                            <td>${response.member.email}</td>
                            <td>${response.member.phone}</td>
                            <td>${response.member.address}</td>
                            <td>
                                <img src="{{ asset('/profiles') }}/${response.member.imageProfile}" alt="Profile Image" width="50">
                            </td>
                            <td>
                                <form action="{{ route('search.book.page') }}" method="GET">
                                    <input type="hidden" name="member_id" value="${response.member.id}">
                                    <button type="submit" class="btn btn-outline-success">
                                        <i class="bi bi-check2-circle"></i> Pilih
                                    </button>
                                </form>
                            </td>
                        </tr>`
                        );
                        // Show the "member found" alert
                        $('#memberFoundAlert').removeClass('d-none');
                        // Show the table
                        $('#memberTableContainer').removeClass('d-none');
                        // Show the table head
                        $('thead').removeClass('d-none');
                    } else {
                        // Member not found, display alert
                        $('#memberNotRegisteredAlert').removeClass('d-none');
                    }
                },
                error: function(xhr, status, thrown) {
                    console.log(thrown);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                    // Handle error if needed
                }
            });
        }

        function toggleSelect(button) {
            if ($(button).hasClass('btn-outline-success')) {
                $(button).removeClass('btn-outline-success').addClass('btn-success');
                $(button).html('<i class="bi bi-check-circle"></i> Dipilih');
            } else {
                $(button).removeClass('btn-success').addClass('btn-outline-success');
                $(button).html('<i class="bi bi-check2-circle"></i> Pilih');
            }
        }
    </script>

@endsection
