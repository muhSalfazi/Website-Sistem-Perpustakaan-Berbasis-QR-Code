@extends('layouts.app')

@section('content')
    <a href="{{ route('admin.books.index') }}" class="btn btn-outline-primary mb-3">
        <i class="ti ti-arrow-left"></i>
        Kembali
    </a>

    @if (session()->has('msg'))
        <div class="pb-2">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session()->get('msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold">Form Tambah Buku</h5>
            <form action="{{ route('admin.books.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3 p-3">
                        <label for="cover" class="d-block" style="cursor: pointer;">
                            <div class="d-flex justify-content-center bg-light overflow-hidden h-100 position-relative">
                                <img id="bookCoverPreview" src="{{ asset(BOOK_COVER_URI . DEFAULT_BOOK_COVER) }}" alt="" height="300" class="z-1">
                                <p class="position-absolute top-50 start-50 translate-middle z-0">Pilih sampul</p>
                            </div>
                        </label>
                    </div>
                    <div class="col-12 col-md-6 col-lg-8 col-xl-9">
                        <div class="mb-3">
                            <label for="cover" class="form-label">Gambar sampul buku</label>
                            <input class="form-control @error('cover') is-invalid @enderror" type="file" id="cover" name="cover" onchange="previewImage()">
                            @error('cover')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Other form inputs -->
                    </div>
                </div>
                <!-- Remaining form inputs -->
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        function previewImage() {
            const fileInput = document.querySelector('#cover');
            const imagePreview = document.querySelector('#bookCoverPreview');

            const reader = new FileReader();
            reader.readAsDataURL(fileInput.files[0]);

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
            };
        }
    </script>
@endsection
