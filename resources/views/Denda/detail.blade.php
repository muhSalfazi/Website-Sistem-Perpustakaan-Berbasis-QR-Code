@extends('layouts.app')
<title>Bayar Denda</title>
@section('content')
<style>
.custom-thead {
    background-color: #f8faf8 !important;
    /* Ubah ini ke warna abu-abu yang diinginkan */
}
</style>
<div class="card">
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-12">
                <h5 class="card-title fw-semibold mb-4">Bayar Denda</h5>
            </div>
        </div>
        <div class="table-responsive mb-4">
            <table class="table table-hover table-striped">
                <thead class="custom-thead">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col" style="white-space: nowrap;">Nama Peminjam</th>
                        <th scope="col" style="white-space: nowrap;">Judul Buku</th>
                        <th scope="col" class="text-center" style="white-space: nowrap;">Jumlah Buku</th>
                        <th scope="col" style="white-space: nowrap;">Tanggal Peminjaman</th>
                        <th scope="col">Keterlambatan</th>
                        <th scope="col">Denda</th>
                        <th scope="col" class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <!-- Contoh Baris -->
                    <tr>
                        <th scope="row">1</th>
                        <td>
                            <a href="#" class="text-primary-emphasis text-decoration-underline">
                                <p style="white-space: nowrap;">
                                    <b>Nama Peminjam</b>
                                </p>
                            </a>
                        </td>
                        <td>
                            <a href="#">
                                <p class="text-primary-emphasis text-decoration-underline" style="white-space: nowrap;">
                                    <b>Judul Buku (Tahun)</b>
                                </p>
                                <p class="text-body">Author: Nama Author</p>
                            </a>
                        </td>
                        <td class="text-center">Jumlah Buku</td>
                        <td>
                            <b>Tgl Pinjam</b><br>
                            <b>Tgl Pinjam</b>
                        </td>
                        <td><b>Tgl Tenggat</b></td>
                        <td class="text-center">
                            <span class="badge bg-danger rounded-3 fw-semibold">1.000RP</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-warning rounded-3 fw-semibold">Belum Lunas</span>
                        </td>
                    </tr>
                    <!-- Akhir Contoh Baris -->
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 mb-4">
                <h5 class="fw-semibold">Formulir Pembayaran</h5>
                <form action="" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="paymentAmount" class="form-label">Jumlah Pembayaran</label>
                        <input type="number" class="form-control" id="paymentAmount" name="paymentAmount"
                            placeholder="Masukkan jumlah pembayaran" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                </form>
            </div>
            <div class="col-12 col-md-6">
                <h5 class="fw-semibold">Ringkasan Pembayaran</h5>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Nama Peminjam:
                        <span class="fw-semibold">Nama Peminjam</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Judul Buku:
                        <span class="fw-semibold">Judul Buku</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Keterlambatan:
                        <span class="fw-semibold">X Hari</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Denda:
                        <span class="fw-semibold">1.000RP</span>
                    </li>
                </ul>
                <div class="col-md-5">
                    <label class="form-label"><b>QR Code Member:</b></label>
                    <img src="{{ asset('img/R.png') }}" alt="QR Code" class="img-fluid" style="max-width: 100px;">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection