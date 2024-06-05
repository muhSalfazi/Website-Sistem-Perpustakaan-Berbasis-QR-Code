@extends('layouts.app')
<title>Detail Denda Buku</title>
@section('content')
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">Detail Denda Buku</h5>
        <div class="mb-3">
            <label class="form-label"><b>Nama Peminjam:</b></label>
            <p>Nama Peminjam</p>
        </div>
        <div class="mb-3">
            <label class="form-label"><b>Judul Buku:</b></label>
            <p>Judul Buku (Tahun)</p>
        </div>
        <div class="mb-3">
            <label class="form-label"><b>Tanggal Peminjaman:</b></label>
            <p>Tanggal Peminjaman</p>
        </div>
        <div class="mb-3">
            <label class="form-label"><b>Tanggal Pengembalian:</b></label>
            <p>Tanggal Pengembalian</p>
        </div>
        <div class="mb-3">
            <label class="form-label"><b>Keterlambatan:</b></label>
            <p>Jumlah Hari Keterlambatan</p>
        </div>
        <div class="mb-3">
            <label class="form-label"><b>Denda:</b></label>
            <p>Jumlah Denda RP</p>
        </div>
        <div class="mb-3">
            <label class="form-label"><b>Status Denda:</b></label>
            <p>Status Denda (Lunas/Belum Lunas)</p>
        </div>
        <a href="#" class="btn btn-success">Tandai sebagai Lunas</a>
        <a href="#" class="btn btn-danger">Batalkan Denda</a>
    </div>
</div>
@endsection