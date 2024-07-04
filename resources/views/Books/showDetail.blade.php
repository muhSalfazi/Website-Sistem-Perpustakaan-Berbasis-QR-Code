@extends('layouts.app')

@section('title', 'Detail Buku')

@section('content')
    <div class="container mt-5 animate__animated animate__fadeIn">
        <a href="{{ route('books.index') }}" class="btn btn-outline-primary mb-3 animate__animated animate__fadeInLeft btn-hover-pulse">
            <i class="ti ti-arrow-left"></i>
            Kembali
        </a>
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-lg animate__animated animate__zoomIn card-hover-zoom">
                    <div class="card-header bg-primary text-white position-relative">
                        <h4 class="card-title mb-0 animate__animated animate__fadeInDown">{{ $book->title }} ({{ $book->year }})</h4>
                        <div class="header-overlay"></div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 animate__animated animate__fadeInLeft">
                                <img class="img-fluid rounded img-hover-zoom" src="{{ asset($book->book_cover) }}" alt="{{ $book->title }}">
                            </div>
                            <div class="col-md-8 animate__animated animate__fadeInRight">
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

    <!-- Custom CSS -->
    <style>
        .btn-hover-pulse {
            position: relative;
            overflow: hidden;
        }

        .btn-hover-pulse::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 300%;
            height: 300%;
            background: rgba(255, 255, 255, 0.15);
            transition: all 0.3s ease;
            border-radius: 50%;
            z-index: 0;
            transform: translate(-50%, -50%) scale(0);
        }

        .btn-hover-pulse:hover::before {
            transform: translate(-50%, -50%) scale(1);
        }

        .card-hover-zoom {
            transition: transform 0.3s ease;
        }

        .card-hover-zoom:hover {
            transform: scale(1.03);
        }

        .img-hover-zoom {
            transition: transform 0.3s ease;
        }

        .img-hover-zoom:hover {
            transform: scale(1.1);
        }

        .card-header {
            position: relative;
            overflow: hidden;
        }

        .header-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, rgba(58, 123, 213, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }

        .card-header::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, rgba(58, 123, 213, 1) 0%, rgba(0, 212, 255, 1) 100%);
        }
    </style>
@endsection
