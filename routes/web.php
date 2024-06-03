<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\DendaController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\RakbukuController;


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


Route::middleware(['auth', AdminMiddleware::class])->group(function () {
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
    Route::get('/search-member-by-email', [PeminjamanController::class, 'searchMemberByEmail'])->name('search.member.by.email');
    Route::get('/scan/member', [PeminjamanController::class, 'scanMemberByQRCode'])->name('scan.member.by.qrcode');



    // pengembalian buku
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');


    // books
    Route::get('/book', [BookController::class, 'index'])->name('daftarbook');
    Route::get('book/create', [BookController::class, 'create'])->name('books.create');
    Route::delete('books/{book}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::delete('books/{book}/edit', [BookController::class, 'edit'])->name('books.update');


    // rakbuku
    Route::get('/rak', [RakbukuController::class, 'index'])->name('Rak.showdata');
    Route::get('/rak/create', [RakbukuController::class, 'create'])->name('Rak.createRak');
    Route::post('/rak/create', [RakbukuController::class, 'store'])->name('Rak.storeRak');
    Route::put('/rak/{id}', [RakbukuController::class, 'update'])->name('racks.update');
    Route::delete('/rak/{id}', [RakbukuController::class, 'destroy'])->name('racks.destroy');


    Route::delete('/racks/{rack}', [RakbukuController::class, 'destroy'])->name('racks.destroy');
    Route::put('/racks/{rack}', [RakbukuController::class, 'update'])->name('racks.update');


    // denda
    Route::get('/denda', [DendaController::class, 'index'])->name('denda');

});