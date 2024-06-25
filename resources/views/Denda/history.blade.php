@extends('layouts.app')

@section('title', 'History Transaksi')

@section('content')
    <div class="pb-2">
        @if (session('msg'))
            <div class="alert {{ session('error') ? 'alert-danger' : 'alert-success' }} alert-dismissible fade show animate__animated animate__fadeIn"
                role="alert">
                {{ session('msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>
    <div class="card animate__animated animate__fadeIn">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-12 col-lg-5">
                    <h5 class="card-title fw-semibold mb-4 animate__animated animate__fadeInLeft">History Transaksi</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end animate__animated animate__fadeInRight">
                        <!-- Tambahkan elemen tambahan jika diperlukan -->
                    </div>
                </div>
                <div class="table-responsive animate__animated animate__fadeInUp">
                    <table class="table datatable table-hover table-striped">
                        <thead class="custom-thead animate__animated animate__fadeInDown">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Resi</th>
                                <th scope="col">Email</th>
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
                                <tr class="animate__animated animate__fadeIn">
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $peminjaman->peminjaman ? $peminjaman->peminjaman->resi_pjmn : '-' }}</td>
                                    <!--<td>-->
                                    <!--    @if ($peminjaman->peminjaman && $peminjaman->peminjaman->member)-->
                                    <!--        {{ $peminjaman->peminjaman->member->first_name ?? 'Unknown' }}-->
                                    <!--        {{ $peminjaman->peminjaman->member->last_name ?? '' }}-->
                                    <!--    @else-->
                                    <!--        Unknown-->
                                    <!--    @endif-->
                                    <!--</td>-->
                                    <td>
                                        @if ($peminjaman->peminjaman && $peminjaman->peminjaman->member)
                                            {{ $peminjaman->peminjaman->member->email ?? 'Unknown' }}
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    <td>{{ $peminjaman->peminjaman ? $peminjaman->peminjaman->book->title : '-' }}</td>
                                    <td>
                                        @if ($peminjaman->peminjaman && $peminjaman->peminjaman->created_at)
                                            {{ \Carbon\Carbon::parse($peminjaman->peminjaman->created_at)->format('d-m-Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        @if ($peminjaman->peminjaman && $peminjaman->peminjaman->return_date)
                                            {{ \Carbon\Carbon::parse($peminjaman->peminjaman->return_date)->format('d-m-Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>Rp{{ number_format( $peminjaman->denda_yg_dibyr, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format( $peminjaman->uang_yg_dibyrkn, 0, ',', '.') }}</td>
                                    <td>
                                        @if ($peminjaman->status == 'lunas')
                                            <span class="badge bg-success animate__animated animate__fadeIn">{{ $peminjaman->status }}</span>
                                        @else
                                            <span class="badge bg-danger animate__animated animate__fadeIn">{{ $peminjaman->status }}</span>
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
