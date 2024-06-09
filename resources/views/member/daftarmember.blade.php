@extends('layouts.app')

@section('title', 'Daftar Member')

@section('content')
    <div class="pb-2">
        @if (session('msg'))
            <div class="alert {{ session('error') ? 'alert-danger' : 'alert-success' }} alert-dismissible fade show"
                role="alert">
                {{ session('msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-12 col-lg-5">
                        <h5 class="card-title fw-semibold mb-4">Daftar Anggota Perpustakaan</h5>
                    </div>

                    <!-- Table with stripped rows -->
                    <div class="table-responsive">
                        <table class="table datatable table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" class="text-center">No</th>
                                    <th scope="col" class="text-center">Foto Profil</th>
                                    <th scope="col" class="text-center">Nama</th>
                                    <th scope="col" class="text-center">Email</th>
                                    <th scope="col" class="text-center">Telepon</th>
                                    <th scope="col" class="text-center">Alamat</th>
                                    <th scope="col" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-group-divider">
                                @forelse ($members as $index => $member)
                                    <tr>
                                        <th scope="row">{{ $index + 1 }}</th>
                                        <td class="text-center">
                                            @if ($member->imageProfile)
                                                <img src="{{ asset('storage/profiles/' . $member->imageProfile) }}"
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
                                            <form action="{{ route('member.destroy', $member->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger delete-btn"
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

@endsection
