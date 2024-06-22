@extends('layouts.app')

@section('title', 'Cari Buku')

@section('content')
<div class="container mt-4">
    <a href="{{ route('Peminjaman.search') }}" class="btn btn-outline-primary mb-4 animate__animated animate__fadeInLeft">
        <i class="ti ti-arrow-left"></i> Kembali
    </a>

    <div class="card shadow-lg border-0 animate__animated animate__fadeInUp">
        <div class="card-body">
            <h3 class="card-title fw-bold text-center">Cari Buku</h3>
            <form action="{{ route('search.book.page') }}" method="GET" class="mb-4">
                @csrf
                @if (request()->has('search') && request()->filled('search'))
                    <div class="mb-3">
                        <div class="list-group-item animate__animated animate__fadeInRight">
                            <h6 class="fw-semibold">Member</h6>
                            <p class="mb-1"><strong>Nama:</strong> {{ $member->first_name }} {{ $member->last_name }}</p>
                            <p class="mb-0"><strong>Email:</strong> {{ $member->email }}</p>
                        </div>
                    </div>
                @endif

                <input type="hidden" name="member_id" value="{{ $memberId }}">

                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari berdasarkan judul, penulis, penerbit, atau ISBN" name="search" value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Cari</button>
                </div>
            </form>

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show animate__animated animate__shakeX" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show animate__animated animate__shakeX" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (request()->has('search') && request()->filled('search'))
                @if (!empty($books) && $books->count() > 0)
                    <h5 class="mt-4 text-center">Hasil Pencarian</h5>
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        @foreach ($books as $book)
                            <div class="col animate__animated animate__zoomIn">
                                <div class="card h-100 shadow-sm border-0">
                                    <img src="{{ asset($book->book_cover) }}" class="card-img-top" alt="{{ $book->title }}" style="margin: 20px; max-width: 220px; height: auto;">

                                    <div class="card-body">
                                        <h5 class="card-title">{{ $book->title }}</h5>
                                        <p class="card-text"><strong>Penulis:</strong> {{ $book->author }}</p>
                                        <p class="card-text"><strong>Penerbit:</strong> {{ $book->publisher }}</p>
                                        <p class="card-text"><strong>ISBN:</strong> {{ $book->isbn }}</p>
                                        <p class="card-text"><strong>Kategori:</strong> {{ optional($book->category)->name }}</p>
                                        <p class="card-text"><strong>Rak:</strong> {{ optional($book->rack)->name }}</p>
                                        <p class="card-text"><strong>Jumlah Tersedia:</strong> {{ $book->bookStock->jmlh_tersedia }}</p>
                                        <p class="card-text"><strong>Deskripsi:</strong> {{ $book->description }}</p>
                                        <form action="{{ route('createPinjaman') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="member_id" value="{{ $memberId }}">
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <button type="submit" class="btn btn-outline-success">
                                                <i class="bi bi-check2-circle"></i> Simpan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{ $books->links() }}
                @else
                    <p class="text-muted text-center mt-4">-- Buku yang dicari tidak tersedia --</p>
                @endif
            @else
                <p class="text-muted text-center mt-4">-- Data buku akan muncul setelah pencarian --</p>
            @endif
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection
