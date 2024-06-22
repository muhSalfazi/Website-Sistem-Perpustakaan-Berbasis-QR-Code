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

        .container-fluid {
            padding: 20px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
            margin-bottom: 20px;
            padding: 20px;
            background-color: white;
            overflow: hidden;
            position: relative;
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .card:hover {
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.2);
            transform: translateY(-10px) rotateX(10deg);
        }

        .card-header {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
            background: linear-gradient(135deg, transparent 0%, transparent 17%, rgba(87, 146, 234, 0.6) 17%, rgba(87, 146, 234, 0.6) 59%, transparent 59%, transparent 64%, rgba(34, 81, 222, 0.6) 64%, rgba(34, 81, 222, 0.6) 100%), linear-gradient(45deg, transparent 0%, transparent 2%, rgb(87, 146, 234) 2%, rgb(87, 146, 234) 46%, rgb(114, 178, 239) 46%, rgb(114, 178, 239) 54%, transparent 54%, transparent 63%, rgb(7, 48, 216) 63%, rgb(7, 48, 216) 100%), linear-gradient(90deg, rgb(255, 255, 255), rgb(255, 255, 255));
            color: white;
            padding: 15px;
            border-radius: 10px 10px 0 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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
            margin-top: 5px;
            transition: transform 0.5s;
        }

        .stat-box {
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            cursor: pointer;
            background: linear-gradient(45deg, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.1));
            position: relative;
            overflow: hidden;
            transform-style: preserve-3d;
        }

        .stat-box:hover {
            background: linear-gradient(45deg, rgba(0, 0, 0, 0.15), rgba(0, 0, 0, 0.15));
            transform: scale(1.05) translateZ(10px);
        }

        .stat-box:hover .stat-number {
            transform: scale(1.2);
        }

        .stat-box h4,
        .stat-box h3 {
            position: relative;
            z-index: 2;
        }

        .stat-box:before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: inherit;
            filter: blur(30px);
            z-index: 1;
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
            animation: slideIn 2s ease-out;
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
            animation: bounceIn 1s ease-out;
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

        .dollar-icon {
            font-size: 3rem;
        }

        .badge {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.375rem;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .badge-info {
            background-color: #17a2b8;
        }

        .badge-primary {
            background-color: #007bff;
        }

        .bg-light-success {
            background-color: rgba(6, 208, 1, 0.2) !important;
        }

        .bg-light-danger {
            background-color: rgba(231, 41, 41, 0.2) !important;
        }

        .round-20 {
            width: 20px;
            height: 20px;
            border-radius: 50%;
        }

        .text-white {
            color: white !important;
        }

        .fs-3 {
            font-size: 1.25rem;
        }

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
            padding-top: 60px;
        }

        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Tooltip styles */
        .tooltip {
            position: relative;
            display: inline-block;
            cursor: pointer;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #555;
            color: #fff;
            text-align: center;
            padding: 5px 0;
            border-radius: 6px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
    </style>

    <script>
         var newMembersCount = {!! json_encode($newMembersCount) !!};
        var borrowingBooksCount = {!! json_encode($borrowingBooksCount) !!};
        var returnBooksCount = {!! json_encode($returnBooksCount) !!};
        var overdueBooksCount = {!! json_encode($overdueBooksCount) !!};
        var overdueMembersCount = {!! json_encode($overdueMembersCount) !!};
        var ikhtisarDays = {!! json_encode($ikhtisarDays) !!};
        var totalDenda = {!! json_encode($totalDenda) !!};
        var totalTunggakan = {!! json_encode($totalTunggakan) !!};
        var lastYearTotalDenda = {!! json_encode($lastYearTotalDenda) !!};
        var lastYearTotalTunggakan = {!! json_encode($lastYearTotalTunggakan) !!};


        
    </script>

    <div class="container-fluid slide-in">
        <div class="col-12">
            <div class="card bounce-in">
                <div class="card-header bg-primary">
                    Laporan Hari Ini
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        @foreach ([['label' => 'Member Baru', 'count' => 'newMembersCount', 'bg' => 'bg-success'], ['label' => 'Pinjam Buku', 'count' => 'borrowingBooksCount', 'bg' => 'bg-info'], ['label' => 'Kembali Buku', 'count' => 'returnBooksCount', 'bg' => 'bg-info'], ['label' => 'Jatuh Tempo', 'count' => 'overdueMembersCount', 'bg' => 'bg-danger']] as $stat)
                            <div class="col-6 col-md-3">
                                <div class="stat-box {{ $stat['bg'] }} pulse"
                                    onclick="showModal('modal{{ $loop->index }}')">
                                    <h4 class="text-white"><b>{{ $stat['label'] }}</b></h4>
                                    <h3 id="{{ $stat['count'] }}" class="stat-number">0</h3>
                                </div>
                            </div>

                            <!-- Modal content -->
                            <div id="modal{{ $loop->index }}" class="modal">
                                <div class="modal-content">
                                    <span class="close" onclick="closeModal('modal{{ $loop->index }}')">&times;</span>
                                    <h2>{{ $stat['label'] }}</h2>
                                    <p>Informasi Detail Tentang {{ $stat['label'] }}...</p>
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
                               <h5 class="card-title fw-semibold">Ikhtisar Libranation Perbulan</h5>
                            </div>
                        </div>
                        <div id="chart">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="row">
                    @foreach ([['title' => 'Pemasukan', 'amount' => $totalDenda, 'change' => $lastYearTotalDenda, 'bg' => 'bg-light-success', 'icon' => 'ti-arrow-up-left', 'text' => 'success'], ['title' => 'Total Tunggakan', 'amount' => $totalTunggakan, 'change' => $lastYearTotalTunggakan, 'bg' => 'bg-light-danger', 'icon' => 'ti-arrow-down-right', 'text' => 'danger']] as $stat)
                        <div class="col-lg-12 {{ !$loop->first ? 'mt-4' : '' }}">
                            <div class="card bounce-in">
                                <div class="card-body">
                                    <div class="row align-items-start">
                                        <div class="col-8">
                                            <h5 class="card-title mb-4 fw-semibold">{{ $stat['title'] }}</h5>
                                            <h4 class="fw-semibold mb-3">
                                                Rp{{ number_format($stat['amount'], 0, ',', '.') }}</h4>
                                            <div class="d-flex align-items-center pb-1">
                                                <span
                                                    class="me-2 rounded-circle {{ $stat['bg'] }} round-20 d-flex align-items-center justify-content-center">
                                                    <i class="ti {{ $stat['icon'] }} text-{{ $stat['text'] }}"></i>
                                                </span>
                                                @if ($stat['change'] > 0)
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
                                                <div
                                                    class="text-white bg-secondary rounded-circle p-6 d-flex align-items-center justify-content-center dollar-icon">
                                                    <i class="ti ti-currency-dollar"></i>
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
