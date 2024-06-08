@extends('layouts.app')

@section('title', 'Cari Buku')

@section('content')
<a href="{{ route('Peminjaman.search') }}" class="btn btn-outline-primary mb-3">
    <i class="ti ti-arrow-left"></i>
    Kembali
</a>

<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold">Member</h5>
        <form action="{{ route('search.book.page') }}" method="GET">
            @csrf
            <div class="input-group mb-3">
                <div class="mb-3">
                    {{-- Data anggota hanya ditampilkan jika pencarian telah dilakukan --}}
                    @if(request()->has('search') && request()->filled('search'))
                        <div>
                            <p class="mb-1"><strong>Nama:</strong> {{ $member->first_name }} {{ $member->last_name }}</p>
                            <p class="mb-0"><strong>Email:</strong> {{ $member->email }}</p>
                        </div>
                    @endif
                </div>
                <input type="text" class="form-control" name="member_id" value="{{ $memberId }}" hidden>
            </div>
            <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Cari berdasarkan judul, penulis, penerbit, atau ISBN" name="search" value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        {{-- Tampilkan pesan kesalahan --}}
        @if (session('error'))
            <div class="alert alert-danger" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

        {{-- Tampilkan hasil pencarian buku hanya jika ada hasil pencarian --}}
        @if(request()->has('search') && request()->filled('search'))
            @if (!empty($books) && $books->count() > 0)
                <h5 class="mt-4">Hasil Pencarian</h5>
                <ul class="list-group">
                    @foreach ($books as $book)
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-4">
                                    <img class="img-fluid rounded" src="{{ asset('storage/' . $book->book_cover) }}" alt="{{ $book->title }}">
                                </div>
                                <div class="col-md-8">
                                    <p><strong>Judul:</strong> {{ $book->title }}</p>
                                    <p><strong>Penulis:</strong> {{ $book->author }}</p>
                                    <p><strong>Penerbit:</strong> {{ $book->publisher }}</p>
                                    <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                                    <p><strong>Kategori:</strong> {{ optional($book->category)->name }}</p>
                                    <p><strong>Rak:</strong> {{ optional($book->rack)->name }}</p>
                                    <p><strong>Jumlah Tersedia:</strong> {{ $book->bookStock->jmlh_tersedia }}</p>
                                    <p><strong>Deskripsi:</strong> {{ $book->description }}</p>
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
                        </li>
                    @endforeach
                </ul>
                {{ $books->links() }}
            @else
                <p>-- buku yang di cari tidak tersedia --</p>
            @endif
            @else
              <p>-- Data buku akan muncul setelah pencarian --</p>
        @endif
    </div>
</div>
@endsection
