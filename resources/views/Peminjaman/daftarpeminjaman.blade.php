@extends('layouts.app')
@section('title', 'Data Peminjaman')

@section('content')
    <div class="card">
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row mb-2">
                <div class="col-12 col-lg-5">
                    <h5 class="card-title fw-semibold mb-4">Data Peminjaman</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
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
                <table class="table datatable table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Resi Peminjaman</th>
                            <th scope="col">Nama Member</th>
                            <th scope="col">Email</th>
                            <th scope="col">Nama Buku</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Status</th>
                            {{-- <th scope="col">Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjamans as $key => $peminjaman)
                            @if (is_null($peminjaman->return_date))
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $peminjaman->resi_pjmn }}</td>
                                    <td>
                                        @if ($peminjaman->member)
                                            {{ $peminjaman->member->first_name ?? 'Unknown' }}
                                            {{ $peminjaman->member->last_name ?? '' }}
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    <td>
                                        @if ($peminjaman->member)
                                            {{ $peminjaman->member->email ?? 'Unknown' }}
                                        @else
                                            Unknown
                                        @endif
                                    </td>

                                    <td>
                                        @if ($peminjaman->book)
                                            {{ $peminjaman->book->title ?? 'Unknown' }}
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    <td>{{ $peminjaman->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @if ($peminjaman->created_at->diffInDays() > 7)
                                            <span class="badge bg-danger">Telat <i class="ti-alert"></i></span>
                                        @else
                                            <span class="badge bg-success">Normal <i class="ti-alert"></i></span>
                                        @endif
                                    </td>
                                    {{-- <td>
                                        <form action="{{ route('peminjaman.destroy', $peminjaman->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger mt-1 w-40"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                <i class="ti ti-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td> --}}
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Pagination links if needed -->
            {{ $peminjamans->links() }}
        </div>
    </div>
@endsection
