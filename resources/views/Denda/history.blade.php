@extends('layouts.app')

@section('title', 'History Transaksi')

@section('content')
    <div class="pb-2">
        @if (session('msg'))
            <div class="alert {{ session('error') ? 'alert-danger' : 'alert-success' }} alert-dismissible fade show animate__animated animate__fadeIn" role="alert">
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
                                <th scope="col" class="text-center">No</th>
                                <th scope="col" class="text-center">Resi</th>
                                <th scope="col" class="text-center">Email</th>
                                <th scope="col" class="text-center">Judul Buku</th>
                                <th scope="col" class="text-center">Tanggal Peminjaman</th>
                                <th scope="col" class="text-center">Tanggal Pengembalian</th>
                                <th scope="col" class="text-center">Denda yang Dibayar</th>
                                <th scope="col" class="text-center">Uang yang Dibayarkan</th>
                                <th scope="col" class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $counter = 0 @endphp
                            @foreach ($peminjamans as $peminjaman)
                                <tr class="animate__animated animate__fadeIn" style="animation-duration: 1s; animation-delay: {{ $counter * 0.2 }}s; animation-timing-function: ease-in-out;">
                                    @php $counter++ @endphp
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td class="text-center">{{ $peminjaman->peminjaman ? $peminjaman->peminjaman->resi_pjmn : '-' }}</td>
                                    <td class="text-center">
                                        @if ($peminjaman->peminjaman && $peminjaman->peminjaman->member)
                                            {{ $peminjaman->peminjaman->member->email ?? 'Unknown' }}
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $peminjaman->peminjaman ? $peminjaman->peminjaman->book->title : '-' }}</td>
                                    <td class="text-center">
                                        @if ($peminjaman->peminjaman && $peminjaman->peminjaman->created_at)
                                            {{ \Carbon\Carbon::parse($peminjaman->peminjaman->created_at)->format('d-m-Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if ($peminjaman->peminjaman && $peminjaman->peminjaman->return_date)
                                            {{ \Carbon\Carbon::parse($peminjaman->peminjaman->return_date)->format('d-m-Y') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-center">Rp{{ number_format($peminjaman->denda_yg_dibyr, 0, ',', '.') }}</td>
                                    <td class="text-center">Rp{{ number_format($peminjaman->uang_yg_dibyrkn, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        @if ($peminjaman->status == 'lunas')
                                            <span class="badge badge-lunas animate__animated animate__fadeIn">{{ $peminjaman->status }}</span>
                                        @else
                                            <span class="badge badge-belum-lunas animate__animated animate__fadeIn">{{ $peminjaman->status }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .badge {
            padding: 5px 10px;  /* Reduced padding */
            border-radius: 15px;  /* Smaller border-radius */
            color: white;
            font-weight: bold;
            font-size: 12px;  /* Reduced font-size */
            text-transform: uppercase;
        }

        .badge-lunas {
            background: linear-gradient(45deg, #4caf50, #81c784);
            box-shadow: 0px 4px 15px rgba(76, 175, 80, 0.4);
        }

        .badge-belum-lunas {
            background: linear-gradient(45deg, #f44336, #e57373);
            box-shadow: 0px 4px 15px rgba(244, 67, 54, 0.4);
        }

        .badge .ti-alert {
            margin-left: 5px;
            animation: bounceIcon 1.5s infinite;
        }

        @keyframes bounceIcon {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-5px);
            }
        }
    </style>
@endsection
