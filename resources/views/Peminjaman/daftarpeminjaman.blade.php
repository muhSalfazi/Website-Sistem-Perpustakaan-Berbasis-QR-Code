@extends('layouts.app')
@section('title', 'Data Peminjaman')

@section('content')
    <div class="card shadow-sm rounded-3 animate__animated animate__fadeIn">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show animate__animated animate__fadeInDown"
                    role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row mb-4 animate__animated animate__fadeInLeft">
                <div class="col-12 d-flex flex-column flex-lg-row align-items-lg-center">
                    <div class="col-12 col-lg-5 mb-3 mb-lg-0">
                        <h5 class="card-title fw-bold">Data Peminjaman</h5>
                    </div>
                    <div class="col-12 col-lg-7 d-flex justify-content-lg-end align-items-center">
                        <a href="{{ route('Peminjaman.search') }}"
                            class="btn btn-custom-new py-2 px-4 animate__animated animate__zoomIn">
                            <i class="ti ti-plus me-2"></i>
                            Peminjaman Baru
                        </a>
                    </div>
                </div>
            </div>

            <div class="table-responsive animate__animated animate__fadeInUp">
                <table class="table datatable table-hover table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Resi Peminjaman</th>
                            <th scope="col">Nama Member</th>
                            <th scope="col">Email</th>
                            <th scope="col">Nama Buku</th>
                            <th scope="col">Tanggal Pinjam</th>
                            <th scope="col">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $counter = 0 @endphp
                        @foreach ($peminjamans as $index => $peminjaman)
                            @if (is_null($peminjaman->return_date))
                                @php $counter++ @endphp
                                <tr class="animate__animated animate__fadeIn" style="animation-duration: 1s; animation-delay: {{ $index * 0.2 }}s; animation-timing-function: ease-in-out;">
                                    <td>{{ $counter }}</td>
                                    <td class="animate__animated animate__fadeInLeft">{{ $peminjaman->resi_pjmn }}</td>
                                    <td class="animate__animated animate__fadeInLeft">
                                        @if ($peminjaman->member)
                                            {{ $peminjaman->member->first_name ?? 'Unknown' }}
                                            {{ $peminjaman->member->last_name ?? '' }}
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    <td class="animate__animated animate__fadeInLeft">
                                        @if ($peminjaman->member)
                                            {{ $peminjaman->member->email ?? 'Unknown' }}
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    <td class="animate__animated animate__fadeInRight">
                                        @if ($peminjaman->book)
                                            {{ $peminjaman->book->title ?? 'Unknown' }}
                                        @else
                                            Unknown
                                        @endif
                                    </td>
                                    <td class="animate__animated animate__fadeInRight">
                                        {{ $peminjaman->created_at->format('d-m-Y') }}</td>
                                    <td class="animate__animated animate__fadeInUp">
                                        @php
                                            $createdDate = \Carbon\Carbon::parse($peminjaman->created_at);
                                            $daysSinceLoan = \Carbon\Carbon::now()->diffInDays($createdDate);

                                            if ($createdDate->isToday()) {
                                                $status = 'New';
                                                $badgeClass = 'badge-new';
                                            } elseif ($daysSinceLoan < 7) {
                                                $status = 'Normal';
                                                $badgeClass = 'badge-normal';
                                            } else {
                                                $status = 'Jatuh Tempo';
                                                $badgeClass = 'badge-overdue';
                                            }
                                        @endphp
                                        <span class="badge {{ $badgeClass }} animate__animated animate__pulse">
                                            {{ $status }} <i class="ti-alert"></i>
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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

        .badge {
            padding: 5px 10px;
            border-radius: 15px;
            color: white;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }

        .badge-new {
            background: linear-gradient(45deg, #4caf50, #81c784);
            box-shadow: 0px 4px 15px rgba(76, 175, 80, 0.4);
        }

        .badge-normal {
            background: linear-gradient(45deg, #2196f3, #64b5f6);
            box-shadow: 0px 4px 15px rgba(33, 150, 243, 0.4);
        }

        .badge-overdue {
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Alert animation
            $('.alert').fadeIn('slow', function() {
                $(this).delay(3000).fadeOut('slow');
            });

            // Additional animation effects
            $('.table').on('mouseenter', 'tbody tr', function() {
                $(this).addClass('animate__animated animate__pulse');
            }).on('mouseleave', 'tbody tr', function() {
                $(this).removeClass('animate__animated animate__pulse');
            });
        });
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endsection
