<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ShowBookController;
use App\Http\Controllers\API\ShowPeminjamanController;
use App\Http\Controllers\API\DendaController;
use App\Http\Controllers\API\showKategori;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post('/register', [MemberController::class, 'register']);
Route::post('/verify-email', [MemberController::class, 'verifyEmail']);

Route::post('/login', [AuthController::class, 'login']);

Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Protected Routes
Route::middleware(['jwt.auth'])->group(function () {

    // show profile
    Route::get('members/{id}', [MemberController::class, 'show']);
    // meember
    Route::post('/members/{id}', [MemberController::class, 'update']);
   
    // show book all 
    Route::get('/books', [ShowBookController::class, 'index']);
    Route::get('/books/{id}', [ShowBookController::class, 'show']);
    Route::get('/books/category/{categoryName}', [ShowBookController::class, 'showByCategory']);

    // show peminjaman berdasarkan member
    Route::get('peminjaman/{id}', [ShowPeminjamanController::class, 'index']);

    // Favorit book 
    Route::post('users/{userId}/books/{id}/favorite', [ShowBookController::class, 'favoriteBook']);
    Route::delete('users/{userId}/books/{id}/favorite', [ShowBookController::class, 'unfavoriteBook']);
    Route::get('users/{userId}/favorites', [ShowBookController::class, 'getFavoriteBooks']);

    //show denda
    Route::get('denda/user/{user_id}', [DendaController::class, 'getDendaByUserId']);

    // show kategori
    Route::get('kategori', [showKategori::class, 'index']);
    Route::get('kategori/{id}', [showKategori::class, 'show']);

});