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
                                        style="max-width: 100px; height: 80px; border-radius=10%">
                                        <img class="mx-auto mh-100" src="{{ asset('storage/' . $book->book_cover) }}"
                                            alt="{{ $book->title }}">
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
                                        <i class="ti ti-eye"></i> Detail
                                    </a>
                                    <a class=" btn btn-sm btn-primary mt-1" data-bs-toggle="modal"
                                        data-bs-target="#editBookModal" data-id="{{ $book->id }}">
                                        <i class="ti ti-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('books.destroy', $book) }}" method="post"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn  btn-sm btn-danger mt-1 w-50 ">
                                            <i class="ti ti-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    {{ $books->links('vendor.pagination.bootstrap-4') }}
                </ul>
            </nav>
        </div>

        <!-- Edit Book Modal -->
        <div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="editBookForm" method="post" enctype="multipart/form-data">
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
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>
                            <div class="mb-3">
                                <label for="isbn" class="form-label">ISBN</label>
                                <input type="text" class="form-control" id="isbn" name="isbn" required>
                            </div>
                            <div class="mb-3">
                                <label for="category" class="form-label">Kategori</label>
                                <select class="form-select" id="category" name="category_id" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="rack" class="form-label">Rak</label>
                                <select class="form-select" id="rack" name="rack_id" required>
                                    @foreach ($racks as $rack)
                                        <option value="{{ $rack->id }}">{{ $rack->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="jumlah" class="form-label">Jumlah</label>
                                <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                            </div>
                            <div class="mb-3">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" class="form-control" id="author" name="author" required>
                            </div>
                            <div class="mb-3">
                                <label for="publisher" class="form-label">Publisher</label>
                                <input type="text" class="form-control" id="publisher" name="publisher" required>
                            </div>
                            <div class="mb-3">
                                <label for="year" class="form-label">Year</label>
                                <input type="number" class="form-control" id="year" name="year" required>
                            </div>
                            <div class="mb-3">
                                <label for="book_cover" class="form-label">Cover Buku</label>
                                <input type="file" class="form-control" id="book_cover" name="book_cover">
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
                const dataTable = new simpleDatatables.DataTable("#bookTable");

                const editBookModal = document.getElementById('editBookModal');
                editBookModal.addEventListener('show.bs.modal', function(event) {
                    const button = event.relatedTarget;
                    const bookId = button.getAttribute('data-id');
                    const editBookForm = document.getElementById('editBookForm');

                    // Fetch book data and populate the form
                    fetch(`/books/${bookId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            console.log('Fetched data:', data); // Log fetched data for debugging
                            editBookForm.action = `/books/${data.book.id}`;
                            editBookForm.querySelector('#id').value = data.book.id;
                            editBookForm.querySelector('#title').value = data.book.title;
                            editBookForm.querySelector('#isbn').value = data.book.isbn;
                            editBookForm.querySelector('#category').value = data.book.category_id;
                            editBookForm.querySelector('#rack').value = data.book.rack_id;
                            editBookForm.querySelector('#jumlah').value = data.book.book_stock
                                .jmlh_tersedia;
                            editBookForm.querySelector('#author').value = data.book.author;
                            editBookForm.querySelector('#publisher').value = data.book.publisher;
                            editBookForm.querySelector('#year').value = data.book.year;
                        })
                        .catch(error => {
                            console.error('There was a problem with the fetch operation:', error);
                        });
                });
            });
        </script>
    </div>
@endsection
