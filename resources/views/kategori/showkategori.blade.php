@extends('layouts.app')

@section('title', 'Daftar Kategori Buku')

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
                    <h5 class="card-title fw-semibold mb-4">Data Kategori Buku</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <div>
                            <a href="{{ route('categories.create') }}" class="btn bt-sm btn-primary py-2 mt-1">
                                <i class="ti ti-plus"></i> Tambah Kategori
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="categoryTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col" class="text-center">NO</th>
                            <th scope="col" class="text-center">Kategori</th>
                            <th scope="col" class="text-center">Jumlah Buku</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $category->name }}</td>
                                <td class="text-center">{{ $category->books_count }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-sm btn-primary edit-category mt-1"
                                        data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                        data-id="{{ $category->id }}" data-name="{{ $category->name }}">Edit</a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="post"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mt-1"
                                            onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Category Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editCategoryForm" method="post">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title" id="editCategoryModalLabel">Edit Kategori Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="name" name="name" required>
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
            const dataTable = new simpleDatatables.DataTable("#categoryTable");

            $('#editCategoryModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var category_id = button.data('id');
                var name = button.data('name');
                var modal = $(this);

                modal.find('.modal-body #name').val(name);

                var form = modal.find('#editCategoryForm');
                var action = '{{ route('categories.update', ':id') }}';
                action = action.replace(':id', category_id);
                form.attr('action', action);
            });
        });
    </script>

@endsection
