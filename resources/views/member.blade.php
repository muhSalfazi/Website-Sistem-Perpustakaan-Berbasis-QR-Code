<!-- resources/views/members/index.blade.php -->
@extends('layouts.app')
<title>Data Member</title>
@section('content')
    <div class="container-fluid">
        <!-- Content Start -->
        <div class="card">
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-12 col-lg-5">
                        <h5 class="card-title fw-semibold mb-4">Data Anggota</h5>
                    </div>
                    <div class="col-12 col-lg-7">
                        <div class="d-flex gap-2 justify-content-md-end">
                            <div>
                                <form action="" method="get">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control" name="search" placeholder="Cari anggota"
                                            aria-label="Cari anggota" aria-describedby="searchButton">
                                        <button class="btn btn-outline-secondary" type="submit"
                                            id="searchButton">Cari</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama lengkap</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Alamat</th>
                                <th scope="col">Jenis kelamin</th>
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-group-divider">
                            <tr>
                                <td class="text-center" colspan="7"><b>Tidak ada data</b></td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>
                                    <a href="#" class="text-primary-emphasis text-decoration-underline">
                                        <b>John Doe</b>
                                    </a>
                                </td>
                                <td>johndoe@example.com</td>
                                <td>123-456-7890</td>
                                <td>123 Main St</td>
                                <td>Laki-laki</td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="#" method="post">
                                            <button type="submit" class="btn btn-danger"
                                                onclick="return confirm('Are you sure?');">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
@endsection
