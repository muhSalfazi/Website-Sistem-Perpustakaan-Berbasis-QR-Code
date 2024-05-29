<!-- resources/views/members/index.blade.php -->
@extends('layouts.app')
<title>Data Pengembalian</title>
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-12 col-lg-5">
                    <h5 class="card-title fw-semibold mb-4">Data Denda</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <div>
                            <form action="" method="get">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="search" placeholder="Cari peminjaman"
                                        aria-label="Cari peminjaman" aria-describedby="searchButton">
                                    <button class="btn btn-outline-secondary" type="submit" id="searchButton">Cari</button>
                                </div>
                            </form>
                        </div>
                        <div>
                            <a href="#" class="btn btn-primary py-2">
                                <i class="ti ti-plus"></i>
                                Peminjaman baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col" style="white-space: nowrap;">Nama peminjaman</th>
                            <th scope="col" style="white-space: nowrap;">Judul buku</th>
                            <th scope="col" class="text-center" style="white-space: nowrap;">Jumlah Buku</th>
                            <th scope="col" style="white-space: nowrap;">Tanggal
                                Peminjaman</th>
                            <th scope="col">Keterlambatan</th>
                            <th scope="col">Denda</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        <tr>
                            <td class="text-center" colspan="8"><b>Tidak ada data</b></td>
                        </tr>
                        <!-- Example Row -->
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
                                    <p class="text-body">
                                        Author: Nama Author</p>
                                </a>
                            </td>
                            <td class="text-center">Jumlah Buku</td>
                            <td>
                                <b>tgl pinjam</b><br>
                                <b>tgl Pinjam</b>
                            </td>
                            <td>
                                <b>Tgl Tenggat</b>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-success rounded-3 fw-semibold">Normal</span>
                            </td>
                            <td>
                                <a href="#" class="d-block btn btn-primary w-100 mb-2">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        <!-- End Example Row -->
                    </tbody>
                </table>
            </div>
            <!-- Pagination Placeholder -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
@endsection
