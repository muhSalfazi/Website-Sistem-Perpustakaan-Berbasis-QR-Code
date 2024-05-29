<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;

// Route::resource('books', BookController::class);



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
Route::middleware('guest')->group(function () {
    // Rute untuk menampilkan halaman login
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');

    // Rute untuk proses login
    Route::post('/', [AuthController::class, 'login']);
});


Route::middleware('auth')->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Halaman dashboard hanya dapat diakses setelah login
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    //route member
    Route::get('/member', [MemberController::class, 'index'])->name('member');
    Route::get('/members/create', [MemberController::class, 'create'])->name('members.create');


    // peminjaman buku
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
    Route::get('/peminjaman/search', [PeminjamanController::class, 'search'])->name('Peminjaman.search');

    // pengembalian buku
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');
    
    
    // books
    Route::get('/book', [BookController::class, 'index'])->name('daftarbook');
    Route::get('book/create', [BookController::class, 'create'])->name('books.create');
    Route::delete('books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
});