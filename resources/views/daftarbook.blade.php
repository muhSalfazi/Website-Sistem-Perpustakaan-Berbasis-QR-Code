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
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-12 col-lg-5">
                    <h5 class="card-title fw-semibold mb-4">Data Buku</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <div>
                            <form action="" method="get">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="search"
                                        value="{{ request('search') }}" placeholder="Cari buku" aria-label="Cari buku"
                                        aria-describedby="searchButton">
                                    <button class="btn btn-outline-secondary" type="submit" id="searchButton">Cari</button>
                                </div>
                            </form>
                        </div>
                        <div>
                            <a href="{{ route('books.create') }}" class="btn btn-primary py-2">
                                <i class="ti ti-plus"></i> Tambah Data Buku
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
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
                                <th scope="row">{{ $loop->iteration + $books->firstItem() - 1 }}</th>
                                <td>
                                    <a href="#">
                                        <div class="d-flex justify-content-center align-items-center"
                                            style="max-width: 150px; height: 120px;">
                                            <img class="mx-auto mh-100" src="{{ asset('storage/' . $book->book_cover) }}"
                                                alt="{{ $book->title }}">
                                        </div>
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        <p class="text-primary-emphasis text-decoration-underline">
                                            <b>{{ $book->title }} ({{ $book->year }})</b>
                                        </p>
                                        <p class="text-body">Author: {{ $book->author }}</p>
                                    </a>
                                </td>
                                <td>{{ optional($book->category)->name ?? 'N/A' }}</td>
                                <td>{{ optional($book->rack)->name ?? 'N/A' }}</td>
                                <td>{{ optional($book->stock)->stok_buku ?? 'N/A' }}</td>

                                <td>
                                    <button class="d-block btn btn-primary w-100 mb-2" data-bs-toggle="modal"
                                        data-bs-target="#editBookModal" data-id="{{ $book->id }}">
                                        <i class="ti ti-pencil"></i> Edit
                                    </button>
                                    <form action="{{ route('books.destroy', $book) }}" method="post"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger w-100">
                                            <i class="ti ti-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="7"><b>Tidak ada data</b></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    {{ $books->links('vendor.pagination.bootstrap-5') }}
                </ul>
            </nav>
        </div>
    </div>

    <!-- Edit Book Modal -->
    <div class="modal fade" id="editBookModal" tabindex="-1" aria-labelledby="editBookModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editBookForm" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title" id="editBookModalLabel">Edit Buku</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="bookId">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label for="author" class="form-label">Author</label>
                            <input type="text" class="form-control" id="author" name="author" required>
                        </div>
                        <div class="mb-3">
                            <label for="category_id" class="form-label">Kategori</label>
                            <input type="text" class="form-control" id="category_id" name="category_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="rack_id" class="form-label">Rak</label>
                            <input type="text" class="form-control" id="rack_id" name="rack_id" required>
                        </div>
                        <div class="mb-3">
                            <label for="year" class="form-label">Tahun</label>
                            <input type="text" class="form-control" id="year" name="year" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Jumlah</label>
                            <input type="text" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="mb-3">
                            <label for="book_cover" class="form-label">Sampul Buku</label>
                            <input type="file" class="form-control" id="book_cover" name="book_cover">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
