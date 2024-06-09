@extends('layouts.app')

@section('title', 'Daftar Pengembalian')

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
                    <h5 class="card-title fw-semibold mb-4">Data Pengembalian</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <div>
                            <a href="{{ route('pengembalian.search') }}" class="btn btn-primary py-2">
                                <i class="ti ti-plus"></i>
                                Pengembalian Buku
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
                            <th scope="col">Email</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Tanggal Kembali</th>
                            <th scope="col">Status</th>
                            <th scope="col">Telat (Hari)</th>
                            {{-- <th scope="col">Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                       @foreach ($pengembalians as $key => $pengembalian)
    <tr>
        <td>{{ $key + 1 }}</td>
        <td>{{ $pengembalian->resi_pjmn ?? '-' }}</td>
        <td>
            @if ($pengembalian->member)
                {{ $pengembalian->member->email ?? 'Unknown' }}
            @else
                Unknown
            @endif
        </td>
        <td>{{ isset($pengembalian->created_at) ? \Carbon\Carbon::parse($pengembalian->created_at)->format('d-m-Y') : '-' }}</td>
        <td>{{ isset($pengembalian->return_date) ? \Carbon\Carbon::parse($pengembalian->return_date)->format('d-m-Y') : '-' }}</td>
        <td>
            @php
                $tanggalPinjam = \Carbon\Carbon::parse($pengembalian->created_at);
                $tanggalKembali = \Carbon\Carbon::parse($pengembalian->return_date);
                $selisih = $tanggalKembali->diffInDays($tanggalPinjam);
                $telat = $selisih > 7 ? $selisih - 7 : 0;
            @endphp
            @if ($telat > 0)
                <span class="badge bg-danger">Telat <i class="ti-alert"></i></span>
            @else
                <span class="badge bg-success">Normal <i class="ti-alert"></i></span>
            @endif
        </td>
        <td>{{ $telat }}</td>
    </tr>
@endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
