@extends('layouts.app')
<title>Dashboard</title>
@section('content')
    <!--  Header End -->
    <div class="container-fluid">

        <div class="col-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h3 class="card-title"><b>Laporan Hari Ini</b></h3>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 col-md-3">
                            <h4 class="text-success"><b>Anggota Baru</b></h4>
                            <h3>90</h3>
                        </div>
                        <div class="col-6 col-md-3">
                            <h4 class="text-info"><b>Peminjaman</b></h4>
                            <h3>90</h3>
                        </div>
                        <div class="col-6 col-md-3">
                            <h4 class="text-info"><b>Return Books</b></h4>
                            <h3>90</h3>
                        </div>
                        <div class="col-6 col-md-3">
                            <h4 class="text-danger"><b>Jatuh Tempo</b></h4>
                            <h3>98</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--  Row 1 -->
        <div class="row">
            <div class="col-lg-8 d-flex align-items-strech">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="card-title fw-semibold">Ikhitsar 7 hari terakhir</h5>
                            </div>
                            <div>
                                <select class="form-select">
                                    <option value="1">March 2023</option>
                                    <option value="2">April 2023</option>
                                    <option value="3">May 2023</option>
                                    <option value="4">June 2023</option>
                                </select>
                            </div>
                        </div>
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Yearly Breakup -->
                        <div class="card overflow-hidden">
                            <div class="card-body p-4">
                                <h5 class="card-title mb-9 fw-semibold">Total Pendapatan Denda</h5>
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="fw-semibold mb-3">$36,358</h4>
                                        <div class="d-flex align-items-center mb-3">
                                            <span
                                                class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-arrow-up-left text-success"></i>
                                            </span>
                                            <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                                            <p class="fs-3 mb-0">last year</p>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="me-4">
                                                <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                                <span class="fs-2">2023</span>
                                            </div>
                                            <div>
                                                <span
                                                    class="round-8 bg-light-primary rounded-circle me-2 d-inline-block"></span>
                                                <span class="fs-2">2023</span>
                                            </div>
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
                        <!-- Monthly Earnings -->
                        <div class="card">
                            <div class="card-body">
                                <div class="row alig n-items-start">
                                    <div class="col-8">
                                        <h5 class="card-title mb-9 fw-semibold">Total Tunggakan</h5>
                                        <h4 class="fw-semibold mb-3">$6,820</h4>
                                        <div class="d-flex align-items-center pb-1">
                                            <span
                                                class="me-2 rounded-circle bg-light-danger round-20 d-flex align-items-center justify-content-center">
                                                <i class="ti ti-arrow-down-right text-danger"></i>
                                            </span>
                                            <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                                            <p class="fs-3 mb-0">last year</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="d-flex justify-content-end">
                                            <div
                                                class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center">
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
