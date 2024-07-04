<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BookController; // Perbaiki namespace disini
use App\Http\Controllers\DendaController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\RakbukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\HistoryTransaksiController;




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
Route::middleware(['guest'])->group(function () {
// Rute untuk menampilkan halaman login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');

// Rute untuk proses login
Route::post('/', [AuthController::class, 'login']);
Route::get('/captcha/refresh', function () {
return response()->json(['captcha' => captcha_src()]);
});
});



Route::middleware(['auth', 'throttle:50,1',AdminMiddleware::class])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Halaman dashboard hanya dapat diakses setelah login
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //route member
    Route::get('/member', [MemberController::class, 'index'])->name('member');
    Route::delete('/members/{id}', [MemberController::class, 'destroy'])->name('member.destroy');

    // peminjaman buku
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');
    Route::get('/peminjaman/search', [PeminjamanController::class, 'search'])->name('Peminjaman.search');
    Route::get('/search-member-by-email', [PeminjamanController::class, 'searchMemberByEmail'])->name('search.member.by.email');
    Route::get('/scan/member', [PeminjamanController::class, 'scanMemberByQRCode'])->name('scan.member.by.qrcode');
    Route::get('/search-books', [PeminjamanController::class, 'searchBookPage'])->name('search.book.page');
    Route::post('/store-peminjaman', [PeminjamanController::class, 'storePeminjaman'])->name('createPinjaman');
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])->name('peminjaman.destroy');




    // pengembalian buku
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');
    Route::get('/pengembalian/search', [PengembalianController::class, 'search'])->name('pengembalian.search');
    Route::get('/pengembalian/cari', [PengembalianController::class, 'cari'])->name('pengembalian.cari');
    Route::put('/pengembalian/simpan', [PengembalianController::class, 'simpan'])->name('pengembalian.simpan');
    Route::delete('pengembalian/hapus/{id}', [PengembalianController::class, 'hapus'])->name('pengembalian.hapus');




    //daftar buku
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
    Route::get('/books/create', [BookController::class, 'create'])->name('books.create');
    Route::get('/book/{id}/', [BookController::class, 'showDetail'])->name('Books.showDetail');
    Route::get('/books/{id}update', [BookController::class, 'getBook'])->name('books.getBook');
    Route::post('/books', [BookController::class, 'store'])->name('books.store');
    Route::delete('/books/{id}', [BookController::class, 'destroy'])->name('books.destroy');
    Route::put('/books/{book}', [BookController::class, 'update'])->name('books.books.update');



    // rakbuku
    Route::get('/rak', [RakbukuController::class, 'index'])->name('Rak.showdata');
    Route::get('/rak/create', [RakbukuController::class, 'create'])->name('Rak.createRak');
    Route::post('/rak/create', [RakbukuController::class, 'store'])->name('Rak.storeRak');
    Route::delete('/racks/{rack}', [RakbukuController::class, 'destroy'])->name('racks.destroy');
    Route::get('/books/{id}', [BookController::class, 'getBook']);
    Route::put('/racks/{rack}', [RakbukuController::class, 'update'])->name('racks.update');


    // kategori 

    Route::get('/categories', [KategoriController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [KategoriController::class, 'create'])->name('categories.create');
    Route::post('/categories/create', [KategoriController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [KategoriController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [KategoriController::class, 'destroy'])->name('categories.destroy');

    // denda
    Route::get('/denda', [DendaController::class, 'index'])->name('denda');
    Route::post('/denda/bayar', [DendaController::class, 'bayarDenda'])->name('denda.bayar');
    
    // history Transaksi
    Route::get('/history-transaksi', [HistoryTransaksiController::class, 'index'])->name('history.transaksi');
});