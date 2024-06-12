@extends('layouts.app')
@section('title', 'History Transaksi')

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
                    <h5 class="card-title fw-semibold mb-4">History Transaksi</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <!-- Tambahkan elemen tambahan jika diperlukan -->
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table datatable table-hover table-striped">
                        <thead class="custom-thead">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Resi</th>
                                <th scope="col">Nama Anggota</th>
                                <th scope="col">Judul Buku</th>
                                <th scope="col">Tanggal Peminjaman</th>
                                <th scope="col">Tanggal Pengembalian</th>
                                <th scope="col">Denda yang Dibayar</th>
                                <th scope="col">Uang yang Dibayar</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans as $peminjaman)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $peminjaman->peminjaman->resi_pjmn }}</td>
                                    <td>{{ $peminjaman->peminjaman->member->first_name ?? 'Unknown' }}
                                        {{ $peminjaman->peminjaman->member->last_name ?? '' }}</td>
                                    <td>{{ $peminjaman->peminjaman->book->title }}</td>
                                    <td>{{ $peminjaman->peminjaman->created_at->format('d-m-Y') }}</td>
                                    <td>{{ $peminjaman->peminjaman->return_date ? \Carbon\Carbon::parse($peminjaman->peminjaman->return_date)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td>{{ $peminjaman->denda_yg_dibyr }}</td>
                                    <td>{{ $peminjaman->uang_yg_dibyrkn }}</td>
                                    <td>
                                        @if ($peminjaman->status == 'lunas')
                                            <span class="badge bg-success">{{ $peminjaman->status }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $peminjaman->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Placeholder Paginasi -->
            {{ $peminjamans->links() }}
        </div>
    </div>
@endsection
