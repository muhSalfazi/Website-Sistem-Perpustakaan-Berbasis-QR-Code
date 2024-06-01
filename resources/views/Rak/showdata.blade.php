@extends('layouts.app')

@section('title', 'Daftar Rak Buku')

@section('content')
    <div class="pb-2">
        @if (session('msg'))
            <div class="alert {{ session('error') ? 'alert-danger' : 'alert-success' }} alert-dismissible fade show"
                role="alert">
                {{ session('msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-12 col-lg-5">
                    <h5 class="card-title fw-semibold mb-4">Data Rak</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <div>
                            <form action="" method="get">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="search"
                                        value="{{ request('search') }}" placeholder="Cari rak" aria-label="Cari rak"
                                        aria-describedby="searchButton">
                                    <button class="btn btn-outline-secondary" type="submit" id="searchButton">Cari</button>
                                </div>
                            </form>
                        </div>
                        <div>
                            <a href="{{ route('Rak.createRak') }}" class="btn btn-primary py-2">
                                <i class="ti ti-plus"></i> Tambah Rak
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">NO</th>
                            <th scope="col">Nama Rak</th>
                            <th scope="col">Lantai</th>
                            <th scope="col">Jumlah Buku</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($racks as $rack)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $rack->name }}</td>
                                <td>{{ $rack->rak }}</td>
                                <td>{{ $rack->books_count }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-primary edit-rack"
                                       data-bs-toggle="modal" data-bs-target="#editRackModal"
                                       data-id="{{ $rack->id }}"
                                       data-name="{{ $rack->name }}"
                                       data-rak="{{ $rack->rak }}">Edit</a>

                                    <form action="{{ route('racks.destroy', $rack->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this rack?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

   <!-- Edit Rack Modal -->
<div class="modal fade" id="editRackModal" tabindex="-1" aria-labelledby="editRackModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editRackForm" method="post" action="{{ route('racks.update', 'rack_id') }}">
                @csrf
                @method('PUT')
                <input type="hidden" name="rack_id" id="rack_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="editRackModalLabel">Edit Rak Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="rack_name" class="form-label">Nama Rak</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="rak" class="form-label">Lantai</label>
                        <input type="text" class="form-control" id="rak" name="rak" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#editRackModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var rack_id = button.data('id');
        var name = button.data('name');
        var rak = button.data('rak');
        var modal = $(this);
        modal.find('.modal-body #rack_id').val(rack_id);
        modal.find('.modal-body #name').val(name).attr('placeholder', name);
        modal.find('.modal-body #rak').val(rak).attr('placeholder', rak);
    });
</script>

@endsection
