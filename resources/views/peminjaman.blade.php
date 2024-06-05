@extends('layouts.app')
<title>Data Peminjaman</title>
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-12 col-lg-5">
                    <h5 class="card-title fw-semibold mb-4">Data Peminjaman</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <div>
                            <form action="{{ route('peminjaman') }}" method="get">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="search" placeholder="Cari peminjaman"
                                        aria-label="Cari peminjaman" aria-describedby="searchButton">
                                    <button class="btn btn-outline-secondary" type="submit" id="searchButton">Cari</button>
                                </div>
                            </form>
                        </div>
                        <div>
                            <a href="{{ route('Peminjaman.search') }}" class="btn btn-primary py-2">
                                <i class="ti ti-plus"></i>
                                Peminjaman baru
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
                            <th scope="col" style="white-space: nowrap;">Resi</th>
                            <th scope="col" style="white-space: nowrap;">Judul buku</th>
                            <th scope="col" class="text-center">Jumlah</th>
                            <th scope="col" style="white-space: nowrap;">Tanggal peminjaman</th>
                            <th scope="col">Tenggat</th>
                            <th scope="col" class="text-center">Status</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @forelse ($peminjamans as $peminjaman)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>
                                    <a href="#" class="text-primary-emphasis text-decoration-underline">
                                        <p><b>{{ $peminjaman->member->name }}</b></p>
                                    </a>
                                </td>
                                <td>
                                    <a href="#">
                                        <p class="text-primary-emphasis text-decoration-underline">
                                            <b>{{ $peminjaman->book->title }} ({{ $peminjaman->book->year }})</b>
                                        </p>
                                        <p class="text-body">Author: {{ $peminjaman->book->author }}</p>
                                    </a>
                                </td>
                                <td class="text-center">{{ $peminjaman->jmlh_buku }}</td>
                                <td>
                                    <b>{{ $peminjaman->created_at->format('d-m-Y') }}</b><br>
                                    <b>{{ $peminjaman->created_at->format('H:i') }}</b>
                                </td>
                                <td>
                                    <b>{{ $peminjaman->created_at->addDays(14)->format('d-m-Y') }}</b>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-success rounded-3 fw-semibold">Normal</span>
                                </td>
                                <td>
                                    <a href="#" class="d-block btn btn-primary w-100 mb-2">Detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="8"><b>Tidak ada data</b></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ $peminjamans->links() }}
        </div>
    </div>
@endsection
