@extends('layouts.app')
@section('title', 'Tambah Buku')

@section('content')
    <a href="{{ route('books.index') }}" class="btn btn-outline-primary mb-3">
        <i class="ti ti-arrow-left"></i>
        Kembali
    </a>
    <div class="card">
        <div class="card-header">Form Tambah Buku</div>

        <div class="card-body">
            <form action="{{ route('books.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Judul</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="author" class="form-label">Pengarang</label>
                    <input type="text" class="form-control" id="author" name="author" required>
                </div>
                <div class="mb-3">
                    <label for="publisher" class="form-label">Penerbit</label>
                    <input type="text" class="form-control" id="publisher" name="publisher" required>
                </div>
                <div class="mb-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" class="form-control" id="isbn" name="isbn" required>
                </div>
                <div class="mb-3">
                    <label for="year" class="form-label">Tahun Terbit</label>
                    <input type="number" class="form-control" id="year" name="year" required>
                </div>
                <div class="mb-3">
                    <label for="cover" class="form-label">Gambar Sampul Buku</label>
                    <input type="file" class="form-control" id="cover" name="cover" required> <!-- Updated field name -->
                </div>
                <div class="mb-3">
                    <label for="jmlh_tersedia" class="form-label">Jumlah Tersedia</label>
                    <input type="number" class="form-control" id="jmlh_tersedia" name="jmlh_tersedia" required>
                </div>
                <div class="mb-3">
                    <label for="rack_id" class="form-label">Rak</label>
                    <select class="form-select" id="rack_id" name="rack_id" required>
                        <option value="" selected disabled>Pilih rak buku</option>
                        @foreach ($racks as $rack)
                            <option value="{{ $rack->id }}">{{ $rack->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select class="form-select" id="category_id" name="category_id" required>
                        <option value="" selected disabled>Pilih kategori buku</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="5" required></textarea> <!-- Updated field name -->
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection
