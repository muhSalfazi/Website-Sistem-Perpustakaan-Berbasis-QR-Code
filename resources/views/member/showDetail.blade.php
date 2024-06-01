<!-- resources/views/create_member.blade.php -->
@extends('layouts.app')
<title>Detail Anggota</title>
<style>
    #qr-code {
        background-image: url(path/to/your/qr_code_image.jpg);
        /* Ganti dengan path gambar QR code Anda */
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        max-width: 500px;
        height: 300px;
    }
</style>
@section('content')
    <div class="row">
        <div class="col-12 col-lg-7">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title fw-semibold mb-4">Detail Anggota</h5>
                            <div class="row mb-3">
                                <div class="col-12 d-flex flex-wrap">
                                    <div class="col-12">
                                        <div class="w-100 mb-4">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <h5><b>Nama Lengkap</b></h5>
                                                    </td>
                                                    <td style="width:15px" class="text-center">
                                                        <h5><b>:</b></h5>
                                                    </td>
                                                    <td>
                                                        <h5><b>John Doe</b></h5>
                                                    </td> <!-- Ganti dengan nama lengkap anggota -->
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5><b>Email</b></h5>
                                                    </td>
                                                    <td style="width:15px" class="text-center">
                                                        <h5><b>:</b></h5>
                                                    </td>
                                                    <td>
                                                        <h5><b>johndoe@example.com</b></h5>
                                                    </td> <!-- Ganti dengan email anggota -->
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5><b>Nomor Telepon</b></h5>
                                                    </td>
                                                    <td style="width:15px" class="text-center">
                                                        <h5><b>:</b></h5>
                                                    </td>
                                                    <td>
                                                        <h5><b>1234567890</b></h5>
                                                    </td> <!-- Ganti dengan nomor telepon anggota -->
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5><b>Alamat</b></h5>
                                                    </td>
                                                    <td style="width:15px" class="text-center">
                                                        <h5><b>:</b></h5>
                                                    </td>
                                                    <td>
                                                        <h5><b>Jalan Contoh No. 123</b></h5>
                                                    </td> <!-- Ganti dengan alamat anggota -->
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5><b>Tanggal Lahir</b></h5>
                                                    </td>
                                                    <td style="width:15px" class="text-center">
                                                        <h5><b>:</b></h5>
                                                    </td>
                                                    <td>
                                                        <h5><b>20 Januari 1990</b></h5>
                                                    </td> <!-- Ganti dengan tanggal lahir anggota -->
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h5><b>Jenis Kelamin</b></h5>
                                                    </td>
                                                    <td style="width:15px" class="text-center">
                                                        <h5><b>:</b></h5>
                                                    </td>
                                                    <td>
                                                        <h5><b>Laki-laki</b></h5>
                                                    </td> <!-- Ganti dengan jenis kelamin anggota -->
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-xl-4">
                            <div class="card" style="height: 180px;">
                                <div class="card-body">
                                    <h2><i class="ti ti-book"></i></h2>
                                    <h5>Buku dipinjam:</h5>
                                    <h4>5</h4> <!-- Ganti dengan jumlah buku yang dipinjam -->
                                </div>
                            </div>
                        </div>
                        <!-- Tambahkan card lainnya sesuai kebutuhan -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-5">
            <div class="card">
                <div class="card-body">
                    <p class="text-center mb-4" style="line-break: anywhere;">UID : 123456789</p>
                    <!-- Ganti dengan UID anggota -->
                    <div id="qr-code" class="m-auto"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
