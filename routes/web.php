<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    // Rute untuk menampilkan halaman login
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');

    // Rute untuk proses login
    Route::post('/', [AuthController::class, 'login']);
});

Route::middleware(['auth'])->group(function () {
    // Halaman selamat datang hanya dapat diakses setelah login
    Route::get('/dashboard', [AuthController::class, 'index'])->name('welcome');

    //route member
    Route::get('/member', [MemberController::class, 'index'])->name('member');
    Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');


    // peminjaman buku
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
    Route::get('/peminjaman/search', [PeminjamanController::class, 'search'])->name('Peminjaman.search');

    // pengembalian buku
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');



});