@extends('layouts.app')

@section('title', 'Daftar Member')

@section('content')
    <div class="pb-2">
        @if (session('msg'))
            <div class="alert {{ session('error') ? 'alert-danger' : 'alert-success' }} alert-dismissible fade show animate__animated animate__fadeInDown"
                role="alert">
                {{ session('msg') }}
                <button type="button" class="btn-close btn-custom" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card animate__animated animate__fadeIn" style="animation-duration: 1s; animation-timing-function: ease-in-out;">
                <div class="card-body">
                    <div class="col-12 col-lg-5">
                        <h5 class="card-title fw-semibold mb-4 animate__animated animate__fadeInLeft" style="animation-duration: 1s; animation-timing-function: ease-in-out;">Daftar Anggota Perpustakaan</h5>
                    </div>

                    <!-- Table with stripped rows -->
                    <div class="table-responsive animate__animated animate__fadeInUp" style="animation-duration: 1s; animation-timing-function: ease-in-out;">
                        <table class="table datatable table-hover table-striped">
                            <thead class="custom-thead">
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Foto Profil</th>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Email</th>
                                    <th scope="col" class="text-center">Telepon</th>
                                    <th scope="col" class="text-center">Alamat</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @forelse ($members as $index => $member)
                                    <tr class="animate__animated animate__fadeIn" style="animation-duration: 1s; animation-delay: {{ $index * 0.2 }}s; animation-timing-function: ease-in-out;">
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td class="text-center">
                                            @if ($member->imageProfile)
                                                <img src="{{ asset('/profiles/' . $member->imageProfile) }}"
                                                    alt="{{ $member->first_name }}"
                                                    class="profile-img">
                                            @else
                                                <span>Tidak ada foto profil</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $member->first_name ?? 'N/A' }} {{ $member->last_name ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $member->email ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $member->phone ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $member->address ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <span class="badge status-badge {{ $member->status == 'new' ? 'bg-new' : 'bg-other' }} animate__animated animate__pulse" style="animation-duration: 1s; animation-timing-function: ease-in-out;">{{ ucfirst($member->status) }}</span>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('member.destroy', $member->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-custom btn-sm delete-btn" onclick="return confirmDelete()">
                                                    <i class="ti ti-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr class="animate__animated animate__fadeIn">
                                        <td colspan="8" class="text-center">Tidak ada anggota terdaftar</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <!-- End Table with stripped rows -->
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus anggota ini?");
        }
    </script>

    <!-- Animate.css for animations -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Custom CSS -->
    <style>
        .btn-custom {
            background: linear-gradient(90deg, rgba(58, 123, 213, 1) 0%, rgba(0, 212, 255, 1) 100%);
            border: none;
            color: white;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            background: linear-gradient(90deg, rgba(0, 212, 255, 1) 0%, rgba(58, 123, 213, 1) 100%);
            transform: scale(1.05);
        }

        .btn-custom.btn-close {
            padding: 0;
            border: none;
            background: none;
        }

        .profile-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #ddd;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .table-responsive {
            margin-top: 20px;
        }

        .table-group-divider tr {
            transition: background-color 0.3s;
        }

        .table-group-divider tr:hover {
            background-color: #f5f5f5;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            color: white;
            font-weight: bold;
            font-size: 12px;
            text-transform: uppercase;
        }

        .status-badge:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .bg-new {
            background: linear-gradient(45deg, #4caf50, #81c784);
            box-shadow: 0px 4px 15px rgba(76, 175, 80, 0.4);
        }

        .bg-other {
            background: linear-gradient(45deg, #f44336, #e57373);
            box-shadow: 0px 4px 15px rgba(244, 67, 54, 0.4);
        }
    </style>
    
@endsection
