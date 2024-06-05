@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
    <div class="container mt-5">
          <a href="{{ route('books.index') }}" class="btn btn-outline-primary mb-3">
        <i class="ti ti-arrow-left"></i>
        Kembali
    </a>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h4 class="card-title mb-0">{{ $book->title }} ({{ $book->year }})</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img class="img-fluid rounded" src="{{ asset('storage/' . $book->book_cover) }}"
                                    alt="{{ $book->title }}">
                            </div>
                            <div class="col-md-8">
                                <p><strong>Judul:</strong> {{ $book->title }}</p>
                                <p><strong>Penulis:</strong> {{ $book->author }}</p>
                                <p><strong>Penerbit:</strong> {{ $book->publisher }}</p>
                                <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                                <p><strong>Kategori:</strong> {{ optional($book->category)->name }}</p>
                                <p><strong>Rak:</strong> {{ optional($book->rack)->name }}</p>
                                <p><strong>Jumlah Tersedia:</strong> {{ optional($book->bookStock)->jmlh_tersedia }}</p>
                                <p><strong>Deskripsi:</strong> {{ $book->description }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
