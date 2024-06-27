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
            <div class="card animate__animated animate__fadeIn">
                <div class="card-body">
                    <div class="col-12 col-lg-5">
                        <h5 class="card-title fw-semibold mb-4 animate__animated animate__fadeInLeft">Daftar Anggota
                            Perpustakaan</h5>
                    </div>

                    <!-- Table with stripped rows -->
                    <div class="table-responsive animate__animated animate__fadeInUp">
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
                                    <tr class="animate__animated animate__fadeIn">
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td class="text-center">
                                            @if ($member->imageProfile)
                                                <img src="{{ asset('/profiles/' . $member->imageProfile) }}"
                                                    alt="{{ $member->first_name }}"
                                                    style="max-width: 50px; border-radius:5%;">
                                            @else
                                                <span>Tidak ada foto profil</span>
                                            @endif
                                        </td>
                                        <td class="text-center">{{ $member->first_name ?? 'N/A' }}
                                            {{ $member->last_name ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $member->email ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $member->phone ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $member->address ?? 'N/A' }}</td>
                                        <td class="text-center">
                                            <span
                                                class="badge {{ $member->status == 'new' ? 'bg-success' : 'bg-secondary' }}">{{ $member->status }}</span>
                                        </td>
                                        <td class="text-center">
                                            <form action="{{ route('member.destroy', $member->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-custom btn-sm delete-btn"
                                                    onclick="return confirmDelete()">
                                                    <i class="ti ti-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
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
    </style>
@endsection
