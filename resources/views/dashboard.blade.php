@extends('layouts.app')
<title>Dashboard</title>
@section('content')
    <div class="container-fluid">
        <div class="col-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h3 class="card-title"><b>Laporan Hari Ini</b></h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 col-md-3">
                            <h4 class="text-success"><b>New members</b></h4>
                            <h3>{{ $newMembersCount }}</h3>
                        </div>
                        <div class="col-6 col-md-3">
                            <h4 class="text-info"><b>Borrowing books</b></h4>
                            <h3>{{ $borrowingBooksCount }}</h3>
                        </div>
                        <div class="col-6 col-md-3">
                            <h4 class="text-info"><b>Return Books</b></h4>
                            <h3>{{ $returnBooksCount }}</h3>
                        </div>
                        <div class="col-6 col-md-3">
                            <h4 class="text-danger"><b>Jatuh Tempo</b></h4>
                            <h3>{{ $overdueBooksCount }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-8 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="card-title fw-semibold">Ikhtisar {{ $ikhtisarDays }} hari terakhir</h5>
                            </div>
                            <div>
                                <form action="{{ route('dashboard') }}" method="GET">
                                    <select name="days" class="form-select" onchange="this.form.submit()">
                                        <option value="7" {{ $ikhtisarDays == 7 ? 'selected' : '' }}>7 Hari</option>
                                        <option value="30" {{ $ikhtisarDays == 30 ? 'selected' : '' }}>30 Hari</option>
                                        <option value="90" {{ $ikhtisarDays == 90 ? 'selected' : '' }}>3 Bulan</option>
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
                    <div class="col-lg-12">
                        <div class="card overflow-hidden">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-9 fw-semibold">Total Pendapatan Denda</h5>
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="fw-semibold mb-3">${{ $totalDenda }}</h4>
                                        <div class="d-flex align-items-center mb-3">
                                            <span class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-arrow-up-left text-success"></i>
                                            </span>
                                            @if($lastYearTotalDenda > 0)
                                                <p class="text-dark me-1 fs-3 mb-0">+{{ number_format((($totalDenda - $lastYearTotalDenda) / $lastYearTotalDenda) * 100, 2) }}%</p>
                                            @else
                                                <p class="text-dark me-1 fs-3 mb-0">NULL</p>
                                            @endif
                                            <p class="fs-3 mb-0">last year</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-center">
                                            <div id="breakup"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-start">
                                    <div class="col-8">
                                        <h5 class="card-title mb-9 fw-semibold">Total Tunggakan</h5>
                                        <h4 class="fw-semibold mb-3">${{ $totalTunggakan }}</h4>
                                        <div class="d-flex align-items-center pb-1">
                                            <span class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-arrow-down-right text-danger"></i>
                                            </span>
                                            @if($lastYearTotalTunggakan > 0)
                                                <p class="text-dark me-1 fs-3 mb-0">+{{ number_format((($totalTunggakan - $lastYearTotalTunggakan) / $lastYearTotalTunggakan) * 100, 2) }}%</p>
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
                            <div id="earning"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
