@extends('layouts.app')
<title>Data Peminjaman</title>
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-12 col-lg-5">
                    <h5 class="card-title fw-semibold mb-4">Data Pengembalian</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <div>
                            <a href="{{ route('Peminjaman.search') }}" class="btn btn-primary py-2">
                                <i class="ti ti-plus"></i>
                                Peminjaman baru
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table datatable table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Resi Peminjaman</th>
                            <th scope="col">Nama Member</th>
                            <th scope="col">Jumlah Buku</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Status</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>Brandon Jacob</td>
                            <td>Designer</td>
                            <td>28</td>
                            <td>2016-05-25</td>
                            <td>2016-05-25</td>
                            <td>
                                <form action="" method="post" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger mt-1"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus Data Peminjaman  ini?')">
                                        <i class="ti ti-trash"></i> Delete</button>
                                </form>

                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
