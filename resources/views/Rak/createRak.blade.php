@extends('layouts.app')

@section('title', 'Tambah Rak Buku')

@section('content')
<div class="container mt-4 animate__animated animate__fadeIn">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm animate__animated animate__fadeInUp">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Tambah Rak</h5>
                    <a href="{{ route('Rak.showdata') }}" class="btn btn-sm btn-outline-primary btn-custom">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    @if (session('msg'))
                    <div class="alert alert-danger alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                        {{ session('msg') }}
                        <button type="button" class="btn-close btn-custom" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <form action="{{ route('Rak.storeRak') }}" method="post" id="form-rak">
                        @csrf
                        <div class="mb-3">
                            <label for="rack" class="form-label">Nama Rak</label>
                            <input type="text" class="form-control" id="rack" name="name" value="{{ old('rack') }}" placeholder="'1A', 'A1'">
                            @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="floor" class="form-label">Lantai</label>
                            <input type="text" class="form-control" id="floor" name="rak" value="{{ old('rak') }}" placeholder="1">
                            @error('rak')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-custom">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    .btn-custom {
        background: linear-gradient(90deg, #36d1dc 0%, #5b86e5 100%);
        border: none;
        color: white;
        font-weight: bold;
        transition: background 0.3s ease;
    }
    .btn-custom:hover {
        background: linear-gradient(90deg, #5b86e5 0%, #36d1dc 100%);
    }
    .btn-close.btn-custom {
        padding: 0;
        border: none;
        background: none;
    }
    .card {
        border-radius: 15px;
        border: none;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        background-color: #ffffff;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
    }
    .card-title {
        color: #333;
    }
    .form-control {
        border-radius: 10px;
        border-color: #ced4da;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .form-control:focus {
        border-color: #36d1dc;
        box-shadow: 0 0 10px rgba(54, 209, 220, 0.2);
    }
    .animate__animated {
        animation-duration: 0.5s;
    }
    .animate__fadeInUp {
        animation-name: fadeInUp;
    }
    .animate__fadeInDown {
        animation-name: fadeInDown;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translate3d(0, 50%, 0);
        }
        to {
            opacity: 1;
            transform: none;
        }
    }
    @keyframes fadeInDown {
        from {
            opacity: 0;
            transform: translate3d(0, -50%, 0);
        }
        to {
            opacity: 1;
            transform: none;
        }
    }
</style>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function () {
        $('#form-rak').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: response.msg,
                        showClass: {
                            popup: 'animate__animated animate__zoomIn'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__zoomOut'
                        }
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            location.reload(); // Reload halaman setelah sukses
                        }
                    });
                },
                error: function (xhr) {
                    var errors = xhr.responseJSON.errors;
                    var errorMessage = '';

                    $.each(errors, function (key, value) {
                        errorMessage += value[0] + '<br>';
                    });

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        html: errorMessage,
                        showClass: {
                            popup: 'animate__animated animate__shakeX'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOut'
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
