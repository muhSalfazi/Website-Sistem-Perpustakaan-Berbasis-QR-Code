@extends('layouts.app')

@section('title', 'Search Peminjaman')

@section('content')
    <div class="container-fluid">
        <!-- Content Start -->
        <a href="{{ route('peminjaman') }}" class="btn btn-outline-primary mb-3">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>

        <div class="pb-2">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                Your Flash Message Here
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <h5 class="card-title fw-semibold">Scan QR peminjaman / anggota</h5>
                        <div>
                            <div id="reader" class="border border-2 border-primary my-4 position-relative"
                                style="max-width: 400px; min-height: 400px; border-radius: 10px; overflow: hidden;">
                                <div id="highlight" class="position-absolute" style="display: none; border: 2px solid red;">
                                </div>
                            </div>
                            <button class="btn btn-primary mb-3 mt-2" style="display: none;" id="resumeBtn"
                                onclick="html5QrcodeScanner.resume(); this.style.display = 'none'; document.getElementById('highlight').style.display = 'none';">
                                Scan ulang
                            </button>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <h5 class="card-title fw-semibold mb-4">Atau cari anggota / buku</h5>
                        <div class="mb-3">
                            <label for="search" class="form-label">Cari UID, nama, email, judul buku</label>
                            <input type="text" class="form-control" id="search" name="search"
                                placeholder="'Ikhsan', 'xibox@gmail.com', 'Lorem ipsum'">
                            <div class="invalid-feedback"></div>
                        </div>
                        <button class="btn btn-primary"
                            onclick="getReturns(document.querySelector('#search').value)">Cari</button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div id="returnsResult">
                            <p class="text-center mt-4">Data peminjaman muncul disini</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/libs/html5-qrcode/html5-qrcode.min.js') }}"></script>
    <script>
        function getReturns(param) {
            console.log(param);

            jQuery.ajax({
                url: "{{ url('peminjaman/search') }}",
                type: 'get',
                data: {
                    'param': param
                },
                success: function(response, status, xhr) {
                    $('#returnsResult').html(response);

                    $('html, body').animate({
                        scrollTop: $("#returnsResult").offset().top
                    }, 500);
                },
                error: function(xhr, status, thrown) {
                    console.log(thrown);
                    $('#returnsResult').html(thrown);
                }
            });
        }

        function onScanSuccess(decodedText, decodedResult) {
            console.log(`Code matched = ${decodedText}`, decodedResult);

            html5QrcodeScanner.pause(true);

            document.querySelector('#resumeBtn').style.display = 'block';

            // Highlight detected barcode
            const highlight = document.getElementById('highlight');
            highlight.style.top = `${decodedResult.resultPoints[0].y}px`;
            highlight.style.left = `${decodedResult.resultPoints[0].x}px`;
            highlight.style.width = `${decodedResult.resultPoints[1].x - decodedResult.resultPoints[0].x}px`;
            highlight.style.height = `${decodedResult.resultPoints[2].y - decodedResult.resultPoints[0].y}px`;
            highlight.style.display = 'block';

            getReturns(decodedText);
        }

        function onScanFailure(error) {
            console.warn(`Code scan error = ${error}`);
        }

        function setupHtml5Qrcode() {
            Html5Qrcode.getCameras().then(cameras => {
                if (cameras && cameras.length) {
                    // Select the front camera, if available
                    let frontCameraId = cameras.find(camera => camera.label.toLowerCase().includes('front'))?.id ||
                        cameras[0].id;
                    const html5QrcodeScanner = new Html5QrcodeScanner(
                        "reader", {
                            formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE]
                        }, {
                            fps: 30,
                            qrbox: {
                                width: 250,
                                height: 250
                            },
                            disableFlip: true // Disable mirroring
                        },
                        false
                    );

                    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
                }
            }).catch(err => {
                console.error("Error getting cameras: ", err);
            });
        }

        setupHtml5Qrcode();

        setTimeout(() => {
            const startBtn = document.querySelector('#html5-qrcode-button-camera-start');
            const stopBtn = document.querySelector('#html5-qrcode-button-camera-stop');
            const fileBtn = document.querySelector('#html5-qrcode-button-file-selection');

            startBtn.classList.add('btn', 'btn-primary', 'mb-2', 'mt-2');
            stopBtn.classList.add('btn', 'btn-primary', 'mb-2');
            fileBtn.classList.add('btn', 'btn-primary', 'mb-2');
        }, 3000);
    </script>
@endsection
