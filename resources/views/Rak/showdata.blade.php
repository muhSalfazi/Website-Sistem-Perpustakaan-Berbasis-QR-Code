@extends('layouts.app')

@section('title', 'Daftar Rak Buku')

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

    <div class="card animate__animated animate__fadeIn">
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-12 col-lg-5">
                    <h5 class="card-title fw-semibold mb-4 animate__animated animate__fadeInLeft">Data Rak</h5>
                </div>
                <div class="col-12 col-lg-7">
                    <div class="d-flex gap-2 justify-content-md-end animate__animated animate__fadeInRight">
                        <div>
                            <a href="{{ route('Rak.createRak') }}" class="btn btn-custom btn-sm py-2 mt-1 btn-pulse animate__animated animate__bounceIn">
                                <i class="ti ti-plus"></i> Tambah Rak
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive animate__animated animate__fadeInUp">
                <table class="table table-hover table-striped" id="rackTable">
                    <thead class="table-light animate__animated animate__fadeInDown">
                        <tr>
                            <th scope="col" class="text-center">NO</th>
                            <th scope="col" class="text-center">Nama Rak</th>
                            <th scope="col" class="text-center">Lantai</th>
                            <th scope="col" class="text-center">Jumlah Buku</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $counter = 0 @endphp
                        @foreach ($racks as $rack)
                            <tr class="animate__animated animate__fadeIn" style="animation-duration: 1s; animation-delay: {{ $counter * 0.2 }}s; animation-timing-function: ease-in-out;">
                                @php $counter++ @endphp
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center animate__animated animate__fadeInLeft">{{ $rack->name }}</td>
                                <td class="text-center animate__animated animate__fadeInRight">{{ $rack->rak }}</td>
                                <td class="text-center animate__animated animate__fadeInLeft">{{ $rack->books_count }}</td>
                                <td class="text-center animate__animated animate__fadeInRight">
                                    <a href="#" class="btn btn-custom btn-sm mt-1 edit-rack"
                                        data-bs-toggle="modal" data-bs-target="#editRackModal"
                                        data-id="{{ $rack->id }}" data-name="{{ $rack->name }}" data-rak="{{ $rack->rak }}">
                                        <i class="ti ti-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('racks.destroy', $rack->id) }}" method="post" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-custom btn-sm btn-danger mt-1"
                                            onclick="return confirm('Are you sure you want to delete this rack?')">
                                            <i class="ti ti-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Edit Rack Modal -->
    <div class="modal fade" id="editRackModal" tabindex="-1" aria-labelledby="editRackModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content fade animate__animated animate__fadeIn">
                <form id="editRackForm" method="post" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="rack_id" id="rack_id">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editRackModalLabel">Edit Rak Buku</h5>
                        <button type="button" class="btn-close btn-custom" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama Rak</label>
                            <input type="text" class="form-control" id="name" name="rack_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="rak" class="form-label">Lantai</label>
                            <input type="text" class="form-control" id="rak" name="rak" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-custom btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-custom btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        .btn-custom {
            background: linear-gradient(90deg, rgba(58, 123, 213, 1) 0%, rgba(0, 212, 255, 1) 100%);
            border: none;
            color: white;
            font-weight: bold;
        }

        .btn-custom:hover {
            background: linear-gradient(90deg, rgba(0, 212, 255, 1) 0%, rgba(58, 123, 213, 1) 100%);
        }

        .btn-custom.btn-close {
            padding: 0;
            border: none;
            background: none;
        }

        .btn-custom.btn-danger {
            background: #dc3545;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        .btn-pulse {
            animation: pulse 1s infinite;
        }
    </style>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dataTable = new simpleDatatables.DataTable("#rackTable");

            $('#editRackModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var rack_id = button.data('id');
                var name = button.data('name');
                var rak = button.data('rak');
                var modal = $(this);
                modal.find('form').attr('action', `/racks/${rack_id}`);
                modal.find('.modal-body #rack_id').val(rack_id);
                modal.find('.modal-body #name').val(name).attr('placeholder', name);
                modal.find('.modal-body #rak').val(rak).attr('placeholder', rak);
            });
        });
    </script>
@endsection
