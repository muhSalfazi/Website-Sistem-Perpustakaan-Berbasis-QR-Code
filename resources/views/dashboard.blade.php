@extends('layouts.app')
<title>Dashboard</title>
@section('content')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f2f5;
        color: #333;
        line-height: 1.6;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        transition: box-shadow 0.3s ease, transform 0.3s ease;
        margin-bottom: 20px;
        padding: 20px;
        background-color: white;
    }

    .card:hover {
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        transform: translateY(-5px);
    }

    .card-header {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 15px;
        background: linear-gradient(60deg, #3572EF, #050C9C);
        color: white;
        padding: 15px;
        border-radius: 10px 10px 0 0;
    }

    .card-title {
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    .card-body {
        font-size: 1rem;
        padding: 15px;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        animation: fadeIn 1s ease-in-out;
        margin-top: 5px;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .form-select {
        border-radius: 8px;
        padding: 10px;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .form-select:focus {
        background-color: #f1f1f1;
        border-color: #007bff;
    }

    .stat-box {
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        transition: background-color 0.3s ease, transform 0.3s ease;
        cursor: pointer;
    }

    .stat-box:hover {
        background-color: #f8f9fa;
        transform: scale(1.05);
    }

    .bg-light {
        background-color: #f8f9fa !important;
    }

    .bg-primary {
        background-color: #007bff !important;
        color: white;
    }

    .bg-success {
        background-color: #06D001 !important;
        color: white;
    }

    .bg-info {
        background-color: #FF9800 !important;
        color: white;
    }

    .bg-danger {
        background-color: #E72929 !important;
        color: white;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.05);
        }

        100% {
            transform: scale(1);
        }
    }

    .pulse {
        animation: pulse 3.5s infinite;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(30px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .slide-in {
        animation: slideIn 1s ease-out;
    }

    @keyframes bounceIn {
        from {
            opacity: 0;
            transform: scale(0.5);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .bounce-in {
        animation: bounceIn 0.5s ease-out;
    }

    .text-nowrap {
        white-space: nowrap;
    }
</style>

<div class="container-fluid slide-in">
    <div class="col-12">
        <div class="card bounce-in">
            <div class="card-header bg-primary">
                Laporan Hari Ini
            </div>
            <div class="card-body">
                <div class="row text-center">
                    @foreach ([
                    ['label' => 'Member Baru', 'count' => $newMembersCount, 'bg' => 'bg-success'],
                    ['label' => 'Pinjam Buku', 'count' => $borrowingBooksCount, 'bg' => 'bg-info'],
                    ['label' => 'Kembali Buku', 'count' => $returnBooksCount, 'bg' => 'bg-info'],
                    ['label' => 'Jatuh Tempo', 'count' => $overdueMembersCount, 'bg' => 'bg-danger']
                    ] as $stat)
                    <div class="col-6 col-md-3">
                        <div class="stat-box {{ $stat['bg'] }} pulse">
                            <h4 class="text-white"><b>{{ $stat['label'] }}</b></h4>
                            <h3 class="stat-number">{{ $stat['count'] }}</h3>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-lg-8 d-flex align-items-stretch">
            <div class="card w-100 bounce-in">
                <div class="card-body">
                    <div class="d-sm-flex d-block align-items-center justify-content-between mb-4">
                        <div class="mb-3 mb-sm-0">
                            <h5 class="card-title fw-semibold">Ikhtisar {{ $ikhtisarDays }} hari terakhir</h5>
                        </div>
                        <div>
                            <form action="{{ route('dashboard') }}" method="GET">
                                <select name="days" class="form-select" onchange="this.form.submit()">
                                    @foreach ([7, 30, 90] as $days)
                                    <option value="{{ $days }}" {{ $ikhtisarDays == $days ? 'selected' : '' }}>
                                        {{ $days }} Hari
                                    </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>
                    <div id="chart">
                        <!-- Implementasi chart jika diperlukan -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="row">
                @foreach ([
                ['title' => 'Total Denda', 'amount' => $totalDenda, 'change' => $lastYearTotalDenda, 'bg' => 'bg-light-success', 'icon' => 'ti-arrow-up-left', 'text' => 'success'],
                ['title' => 'Total Tunggakan', 'amount' => $totalTunggakan, 'change' => $lastYearTotalTunggakan, 'bg' => 'bg-light-danger', 'icon' => 'ti-arrow-down-right', 'text' => 'danger']
                ] as $stat)
                <div class="col-lg-12 {{ !$loop->first ? 'mt-4' : '' }}">
                    <div class="card bounce-in">
                        <div class="card-body">
                            <div class="row align-items-start">
                                <div class="col-8">
                                    <h5 class="card-title mb-4 fw-semibold">{{ $stat['title'] }}</h5>
                                    <h4 class="fw-semibold mb-3">${{ $stat['amount'] }}</h4>
                                    <div class="d-flex align-items-center pb-1">
                                        <span class="me-2 rounded-circle {{ $stat['bg'] }} round-20 d-flex align-items-center justify-content-center">
                                            <i class="ti {{ $stat['icon'] }} text-{{ $stat['text'] }}"></i>
                                        </span>
                                        @if($stat['change'] > 0)
                                        <p class="text-dark me-1 fs-3 mb-0">
                                            +{{ number_format((($stat['amount'] - $stat['change']) / $stat['change']) * 100, 2) }}%
                                        </p>
                                        @else
                                        <p class="text-dark me-1 fs-3 mb-0">NULL</p>
                                        @endif
                                        <p class="fs-3 mb-0">last year</p>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="d-flex justify-content-end">
                                        <div class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
                                            <i class="ti ti-currency-dollar fs-6"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="{{ $loop->first ? 'breakup' : 'earning' }}"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
