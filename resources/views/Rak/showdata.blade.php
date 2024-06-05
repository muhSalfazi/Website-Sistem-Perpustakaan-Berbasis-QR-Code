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
                            <a href="{{ route('Rak.createRak') }}" class="btn bt-sm btn-primary py-2 mt-1">
                                <i class="ti ti-plus"></i> Tambah Rak
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="rackTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center">NO</th>
                            <th scope="col" class="text-center">Nama Rak</th>
                            <th scope="col" class="text-center">Lantai</th>
                            <th scope="col" class="text-center">Jumlah Buku</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($racks as $rack)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $rack->name }}</td>
                                <td class="text-center">{{ $rack->rak }}</td>
                                <td class="text-center">{{ $rack->books_count }}</td>
                                <td class="text-center">

                                    <a href="#" class="btn btn-sm btn-primary edit-rack mt-1" data-bs-toggle="modal"
                                        data-bs-target="#editRackModal" data-id="{{ $rack->id }}"
                                        data-name="{{ $rack->name }}" data-rak="{{ $rack->rak }}">
                                        <i class="ti ti-pencil"></i>Edit </a>


                                    <form action="{{ route('racks.destroy', $rack->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mt-1"
                                            onclick="return confirm('Are you sure you want to delete this rack?')">  <i class="ti ti-trash"></i> Delete</button>
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
                <form id="editRackForm" method="post" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="rack_id" id="rack_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRackModalLabel">Edit Rak Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Rak</label>
                            <input type="text" class="form-control" id="name" name="rack_name" required>
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
        document.addEventListener('DOMContentLoaded', function() {
            const dataTable = new simpleDatatables.DataTable("#rackTable");

            $('#editRackModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var rack_id = button.data('id');
                var name = button.data('name');
                var rak = button.data('rak');
                var modal = $(this);
                modal.find('form').attr('action', `/racks/${rack_id}`);
                modal.find('.modal-body #rack_id').val(rack_id);
                modal.find('.modal-body #name').val(name).attr('placeholder', name);
                modal.find('.modal-body #rak').val(rak).attr('placeholder', rak);
            });
        });
    </script>
@endsection
