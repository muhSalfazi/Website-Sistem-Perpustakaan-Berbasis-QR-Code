@extends('layouts.app')

@section('title', 'Search Pengembalian')

@section('content')
    <div class="container-fluid">
        <!-- Content Start -->
        <a href="{{ route('peminjaman') }}" class="btn btn-outline-primary mb-3">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>

        <div class="card">
            <!-- Menampilkan pesan kesalahan jika ada -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Menampilkan respon jika peminjaman ditemukan -->
            @isset($peminjaman)
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Peminjaman ditemukan.
                    <!-- Tampilkan data peminjaman -->
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endisset

            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-12">
                        <h5 class="card-title fw-semibold mb-4">Pengembalian Buku</h5>
                        <!-- Form pencarian -->
                        <form id="searchForm" action="{{ route('pengembalian.cari') }}" method="GET">
                            <div class="mb-3">
                                <label for="resi_pnjmn" class="form-label">Masukkan Resi Peminjaman Anggota</label>
                                <input type="text" class="form-control" id="resi_pnjmn" name="resi_pnjmn" placeholder="Resi Peminjaman">
                                <div class="invalid-feedback"></div>
                            </div>
                            <button type="submit" class="btn btn-primary">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tampilkan data peminjaman jika ditemukan -->
        @isset($peminjaman)
            <div class="card mt-3">
                <div class="card-body">
                    <h5 class="card-title">Detail Peminjaman</h5>
                    <div class="table-responsive">
                        <table class="table text-center">
                            <thead>
                                <tr>
                                    <th scope="col">Nomor</th>
                                    <th scope="col">Resi Peminjaman</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Nama Buku</th>
                                    <th scope="col">Tanggal Pinjam</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>{{ $peminjaman->resi_pjmn }}</td>
                                    <td>{{ $peminjaman->member->email }}</td>
                                    <td>
                                        @if ($peminjaman->book)
                                            {{ $peminjaman->book->title ?? 'Unknown' }}
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    <td>{{ $peminjaman->created_at }}</td>
                                    <td>
                                        <form action="{{ route('pengembalian.simpan', $peminjaman) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="id" value="{{ $peminjaman->id }}">
                                            <button type="submit" class="btn btn-outline-success">
                                                <i class="bi bi-check2-circle"></i> Pilih
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endisset
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection
