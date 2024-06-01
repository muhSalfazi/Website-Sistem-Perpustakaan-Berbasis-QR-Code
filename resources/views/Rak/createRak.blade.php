@extends('layouts.app')

@section('title', 'Tambah Rak Buku')

@section('content')
  <a href="{{ route('Rak.showdata') }}" class="btn btn-outline-primary mb-3">
  <i class="ti ti-arrow-left"></i>
  Kembali
</a>
  @if (session('msg'))
    <div class="pb-2">
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('msg') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    </div>
  @endif

  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold">Tambah Rak</h5>
     <form action="{{ route('Rak.storeRak') }}" method="post">

        @csrf
        <div class="row">
          <div class="col-12 col-md-6">
            <div class="my-3">
              <label for="rack" class="form-label">Nama rak</label>
              <input type="text" class="form-control" id="rack" name="name" value="{{ old('rack') }}" placeholder="'1A', 'A1'">
              @error('name')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
          <div class="col-12 col-md-6">
            <div class="my-3">
              <label for="rak" class="form-label">Lantai</label>
              <input type="text" class="form-control" id="floor" name="rak" value="{{ old('rak') }}" placeholder="1">
              @error('rak')
                <div class="invalid-feedback d-block">{{ $message }}</div>
              @enderror
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
      </form>
    </div>
  </div>
  <script>
    $(document).ready(function () {
        $('form').on('submit', function (e) {
            e.preventDefault();

            $.ajax({
                type: "POST",
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: response.msg,
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: xhr.responseJSON.errors,
                    });
                }
            });
        });
    });
</script>

@endsection
