@extends('layouts.app')

@section('title', 'Tambah Kategori Buku')

@section('content')
<a href="{{ route('categories.index') }}" class="btn btn-custom mb-3">
    <i class="ti ti-arrow-left"></i>
    Kembali
</a>
@if (session('msg'))
    <div class="pb-2">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('msg') }}
            <button type="button" class="btn-close btn-custom" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
@endif
<div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold">Tambah Kategori</h5>
        <form action="{{ route('categories.store') }}" method="post">

            @csrf
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="my-3">
                        <label for="kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="kategori" name="name"
                            value="{{ old('name') }}" placeholder="'komik', 'novel'">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-custom">Simpan</button>
        </form>
    </div>
</div>

<!-- Custom CSS -->
<style>
    .btn-custom {
        background: linear-gradient(90deg, rgba(58,123,213,1) 0%, rgba(0,212,255,1) 100%);
        border: none;
        color: white;
        font-weight: bold;
    }
    .btn-custom:hover {
        background: linear-gradient(90deg, rgba(0,212,255,1) 0%, rgba(58,123,213,1) 100%);
    }
    .btn-custom.btn-close {
        padding: 0;
        border: none;
        background: none;
    }
</style>

@endsection
