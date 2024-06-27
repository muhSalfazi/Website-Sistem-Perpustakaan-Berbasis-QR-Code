@extends('layouts.app')

@section('title', 'Daftar Pengembalian')

@section('content')
    <div class="card animate__animated animate__fadeIn">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show animate__animated animate__slideInDown"
                    role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row mb-2 animate__animated animate__fadeInLeft">
                <div class="col-12 col-lg-5">
                    <h5 class="card-title fw-semibold mb-4">Data Pengembalian</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end">
                        <div>
                            <a href="{{ route('pengembalian.search') }}"
                                class="btn btn-custom-new py-2 px-4 animate__animated animate__zoomIn">
                                <i class="ti ti-plus me-2"></i>
                                Pengembalian Buku
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive animate__animated animate__fadeInUp">
                <table class="table datatable table-hover table-striped">
                    <thead>
                        <tr class="animate__animated animate__fadeIn">
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
                            <tr class="animate__animated animate__fadeInUpBig">
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $pengembalian->resi_pjmn ?? '-' }}</td>
                                <td>
                                    @if ($pengembalian->member)
                                        {{ $pengembalian->member->email ?? 'Unknown' }}
                                    @else
                                        Unknown
                                    @endif
                                </td>
                                <td>{{ isset($pengembalian->created_at) ? \Carbon\Carbon::parse($pengembalian->created_at)->format('d-m-Y') : '-' }}
                                </td>
                                <td>{{ isset($pengembalian->return_date) ? \Carbon\Carbon::parse($pengembalian->return_date)->format('d-m-Y') : '-' }}
                                </td>
                                <td>
                                    @php
                                        $returnDate = \Carbon\Carbon::parse($pengembalian->return_date);
                                        $status = $returnDate->isToday() ? 'New' : 'old';
                                    @endphp
                                    <span
                                        class="badge bg-{{ $returnDate->isToday() ? 'success' : 'danger' }} animate__animated animate__bounce">
                                        {{ $status }} <i class="ti-alert"></i>
                                    </span>
                                </td>
                                <td>
                                    @php
                                        $tanggalPinjam = \Carbon\Carbon::parse($pengembalian->created_at);
                                        $tanggalKembali = \Carbon\Carbon::parse($pengembalian->return_date);
                                        $selisih = $tanggalKembali->diffInDays($tanggalPinjam);
                                        $telat = $selisih > 7 ? $selisih - 7 : 0;
                                    @endphp
                                    {{ $telat }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>


                </table>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .btn-custom-new {
            background: linear-gradient(90deg, rgba(58, 123, 213, 1) 0%, rgba(0, 212, 255, 1) 100%);
            border: none;
            color: white;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 30px;
            transition: all 0.3s ease;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
        }

        .btn-custom-new .ti {
            position: relative;
            z-index: 1;
            transition: transform 0.3s ease;
        }

        .btn-custom-new:hover {
            background: linear-gradient(90deg, rgba(0, 212, 255, 1) 0%, rgba(58, 123, 213, 1) 100%);
            transform: scale(1.05);
        }

        .btn-custom-new:hover .ti-plus {
            transform: rotate(90deg);
        }
    </style>

    <!-- jQuery for animation effects -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Alert animation
            $('.alert').fadeIn('slow', function() {
                $(this).delay(3000).fadeOut('slow');
            });

            // Table row animation
            $('.table').on('mouseenter', 'tbody tr', function() {
                $(this).addClass('animate__animated animate__shakeX');
            }).on('mouseleave', 'tbody tr', function() {
                $(this).removeClass('animate__animated animate__shakeX');
            });
        });
    </script>
    <!-- Animate.css for additional animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection
