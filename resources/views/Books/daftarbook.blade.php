@extends('layouts.app')

@section('title', 'Daftar Buku')

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
        @php
            $categories = App\Models\Kategori::all();
            $racks = App\Models\Rack::all();
        @endphp
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-12 col-lg-5">
                    <h5 class="card-title fw-semibold mb-4">Data Buku</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <div>
                            <a href="{{ route('books.create') }}" class="btn btn-primary py-2 mt-2">
                                <i class="ti ti-plus"></i> Tambah Data Buku
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped" id="bookTable">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Cover Buku</th>
                            <th scope="col">Judul</th>
                            <th scope="col">Kategori</th>
                            <th scope="col">Rak</th>
                            <th scope="col">Jumlah</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @forelse ($books as $index => $book)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center"
                                        style="max-width: 100px; height: 80px;">
                                        <img class="mx-auto mh-100" src="{{ asset($book->book_cover) }}"
                                            alt="{{ $book->title }}" style="max-height: 100%; max-width: 100%;">
                                    </div>
                                </td>
                                <td>
                                    <p class="text-primary-emphasis text-decoration-underline">
                                        <b>{{ $book->title }} ({{ $book->year }})</b>
                                    </p>
                                    <p class="text-body">Author: {{ $book->author }}</p>
                                </td>
                                <td>{{ optional($book->category)->name ?? '0' }}</td>
                                <td>{{ optional($book->rack)->name ?? '0' }}</td>
                                <td>{{ optional($book->bookStock)->jmlh_tersedia ?? '0' }}</td>
                                <td>
                                    <a href="{{ route('Books.showDetail', $book->id) }}" class="btn btn-sm btn-info mt-1">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a class="btn btn-sm btn-primary mt-1" data-bs-toggle="modal"
                                        data-bs-target="#editBookModal" data-book="{{ json_encode($book) }}">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <form action="{{ route('books.destroy', $book) }}" method="post"
                                        onsubmit="return confirm('Are you sure?');" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger mt-1">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No books available</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

        <!-- Edit Book Modal -->
        <div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editBookForm" method="post" enctype="multipart/form-data" action="">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="id">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editBookModalLabel">Edit Buku</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Judul</label>
                                <input type="text" class="form-control" id="title" name="title" value="">
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" class="form-control" id="author" name="author" value="">
                            </div>
                            <div class="mb-3">
                                <label for="year" class="form-label">Tahun</label>
                                <input type="number" class="form-control" id="year" name="year" value="">
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="rack_id" class="form-label">Rak</label>
                                <select class="form-control" id="rack_id" name="rack_id">
                                    @foreach ($racks as $rack)
                                        <option value="{{ $rack->id }}">{{ $rack->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah"
                                    value="">
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
                $('#editBookModal').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var book = button.data('book');
                    var modal = $(this);

                    modal.find('form').attr('action', `/books/${book.id}`);
                    modal.find('#id').val(book.id);
                    modal.find('#title').val(book.title);
                    modal.find('#author').val(book.author);
                    modal.find('#year').val(book.year);
                    modal.find('#category_id').val(book.category_id);
                    modal.find('#rack_id').val(book.rack_id);
                    modal.find('#jumlah').val(book.book_stock ? book.book_stock.jmlh_tersedia : 0);
                });
            });
        </script>
    </div>
@endsection
