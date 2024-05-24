<!-- resources/views/create_member.blade.php -->
@extends('layouts.app')
<title>Tambah Anggota</title>
@section('content')
    <a href="{{ route('member') }}" class="btn btn-outline-primary mb-3">
        <i class="ti ti-arrow-left"></i>
        Kembali
    </a>

    <div class="pb-2">
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Pesan error di sini
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title fw-semibold">Form Anggota Baru</h5>
            <form action="admin/members" method="post">
                @csrf
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="first_name" class="form-label">Nama depan</label>
                        <input type="text" class="form-control is-invalid" id="first_name" name="first_name"
                            value="" placeholder="John Doe" required>
                        <div class="invalid-feedback">
                            Pesan error nama depan di sini
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="last_name" class="form-label">Nama belakang</label>
                        <input type="text" class="form-control is-invalid" id="last_name" name="last_name"
                            value="">
                        <div class="invalid-feedback">
                            Pesan error nama belakang di sini
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control is-invalid" id="email" name="email"
                            value="" placeholder="johndoe@gmail.com" required>
                        <div class="invalid-feedback">
                            Pesan error email di sini
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label for="phone" class="form-label">Nomor telepon</label>
                        <input type="tel" class="form-control is-invalid" id="phone" name="phone"
                            value="" placeholder="+628912345" required>
                        <div class="invalid-feedback">
                            Pesan error nomor telepon di sini
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea class="form-control is-invalid" id="address" name="address" required></textarea>
                    <div class="invalid-feedback">
                        Pesan error alamat di sini
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-md-6 mb-3">
                        <label for="date_of_birth" class="form-label">Tanggal lahir</label>
                        <input type="date" class="form-control is-invalid" id="date_of_birth" name="date_of_birth"
                            value="" required>
                        <div class="invalid-feedback">
                            Pesan error tanggal lahir di sini
                        </div>
                    </div>
                    <div class="col-12 col-md-6 mb-3">
                        <label class="form-label">Jenis kelamin</label>
                        <div class="my-2 is-invalid">
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="male" name="gender"
                                    value="1" required>
                                <label class="form-check-label" for="male">
                                    Laki-laki
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" class="form-check-input" id="female" name="gender"
                                    value="2" required>
                                <label class="form-check-label" for="female">
                                    Perempuan
                                </label>
                            </div>
                        </div>
                        <div class="invalid-feedback">
                            Pesan error jenis kelamin di sini
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-2">Simpan</button>
            </form>
        </div>
    </div>
@endsection
