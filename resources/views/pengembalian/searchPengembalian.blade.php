@extends('layouts.app')

@section('title', 'Search Pengembalian')

@section('content')
    <div class="container-fluid">
        <!-- Content Start -->
        <a href="{{ route('peminjaman') }}" class="btn btn-outline-primary mb-3">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>

        <div class="card shadow-sm mb-4">
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
                    <div class="col-12 col-md-8">
                        <h5 class="card-title fw-semibold mb-4 text-center">Pengembalian Buku</h5>
                        <!-- Form pencarian -->
                        <form id="searchForm" action="{{ route('pengembalian.cari') }}" method="GET">
                            <div class="mb-3">
                                <label for="keyword" class="form-label">Masukkan Resi Peminjaman atau Email Anggota</label>
                                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Resi Peminjaman atau Email">
                                <div class="invalid-feedback"></div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Cari</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tampilkan data peminjaman jika ditemukan -->
        @isset($peminjaman)
            <div class="card mt-3 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center">Detail Peminjaman</h5>
                    <div class="table-responsive">
                        <table class="table text-center table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">Nomor</th>
                                    <th scope="col">Cover Buku</th>
                                    <th scope="col">Resi Peminjaman</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Nama Buku</th>
                                    <th scope="col">Tanggal Pinjam</th>
                                    <th scope="col">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peminjaman as $key => $item)
                                    <tr class="fade-in">
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if ($item->book && $item->book->book_cover)
                                                <img src="{{ asset($item->book->book_cover) }}" alt="Cover Buku" style="width: 50px; height: auto;">
                                            @endif
                                        </td>
                                        <td>{{ $item->resi_pjmn }}</td>
                                        <td>{{ $item->member->email }}</td>
                                        <td>{{ $item->book->title ?? 'Unknown' }}</td>
                                        <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                        <td>
                                            <form action="{{ route('pengembalian.simpan', $item) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-outline-success">
                                                    <i class="bi bi-check2-circle"></i> Pilih
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
    <style>
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
@endsection
