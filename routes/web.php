<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\RedirectIfAuthenticated;

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
    Route::get('/welcome', [AuthController::class, 'index'])->name('welcome');
});