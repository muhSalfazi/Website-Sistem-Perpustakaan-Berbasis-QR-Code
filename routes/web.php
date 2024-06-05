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
use App\Http\Controllers\KategoriController;

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
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::put('/books/{id}', [BookController::class, 'update'])->name('books.update');
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::get('/books/{id}/getBook', [BookController::class, 'getBook']);


    // rakbuku
    Route::get('/rak', [RakbukuController::class, 'index'])->name('Rak.showdata');
    Route::get('/rak/create', [RakbukuController::class, 'create'])->name('Rak.createRak');
    Route::post('/rak/create', [RakbukuController::class, 'store'])->name('Rak.storeRak');
    Route::delete('/racks/{rack}', [RakbukuController::class, 'destroy'])->name('racks.destroy');
    Route::get('/books/{id}', [BookController::class, 'getBook']);
    // Mengupdate rak yang diubah
    Route::put('/racks/{rack}', [RakbukuController::class, 'update'])->name('racks.update');


    // kategori 

    Route::get('/categories', [KategoriController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [KategoriController::class, 'create'])->name('categories.create');
    Route::post('/categories/create', [KategoriController::class, 'store'])->name('categories.store');
    // Route::get('/categories/{category}/edit', [KategoriController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [KategoriController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [KategoriController::class, 'destroy'])->name('categories.destroy');

    // denda
    Route::get('/denda', [DendaController::class, 'index'])->name('denda');

});