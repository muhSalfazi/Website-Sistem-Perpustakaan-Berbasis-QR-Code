@extends('layouts.app')

@section('title', 'Daftar Kategori Buku')

@section('content')
  <div class="pb-2">
        @if (session('msg'))
            <div class="alert {{ session('suc') ? 'alert-danger' : 'alert-success' }} alert-dismissible fade show animate__animated animate__fadeInDown" role="alert">
                <button type="button" class="btn-close btn-custom" data-bs-dismiss="alert" aria-label="Close"></button>
                {{ session('msg') }}
            </div>
        @endif
    </div>
    <div class="card animate__animated animate__fadeIn">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-12 col-lg-5">
                    <h5 class="card-title fw-semibold mb-4">Data Kategori Buku</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <div>
                            <a href="{{ route('categories.create') }}" class="btn btn-custom py-2 mt-1">
                                <i class="ti ti-plus"></i> Tambah Kategori
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive animate__animated animate__fadeInUp">
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
                        @php $counter = 0 @endphp
                        @foreach ($categories as $category)
                            <tr class="animate__animated animate__fadeIn" style="animation-duration: 1s; animation-delay: {{ $counter * 0.2 }}s; animation-timing-function: ease-in-out;">
                                @php $counter++ @endphp
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $category->name }}</td>
                                <td class="text-center">{{ $category->books_count }}</td>
                                <td class="text-center">
                                    <a href="#" class="btn btn-custom btn-sm mt-1 edit-category"
                                        data-bs-toggle="modal" data-bs-target="#editCategoryModal"
                                        data-id="{{ $category->id }}" data-name="{{ $category->name }}">Edit</a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="post"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-custom btn-sm btn-danger mt-1"
                                            onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">Delete</button>
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
                        <button type="button" class="btn-close btn-custom" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-custom btn-primary">Simpan Perubahan</button>
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
        .btn-custom.btn-danger {
            background: linear-gradient(90deg, rgba(255,0,0,1) 0%, rgba(255,69,0,1) 100%);
            border: none;
            color: white;
            font-weight: bold;
        }
        .btn-custom.btn-danger:hover {
            background: linear-gradient(90deg, rgba(255,69,0,1) 0%, rgba(255,0,0,1) 100%);
        }
        /* Animations */
        .animate__animated {
            animation-duration: 0.5s;
        }
        .animate__fadeIn {
            animation-name: fadeIn;
        }
        .animate__fadeInDown {
            animation-name: fadeInDown;
        }
        .animate__fadeInUp {
            animation-name: fadeInUp;
        }
        .animate__fadeInLeft {
            animation-name: fadeInLeft;
        }
    </style>
@endsection
