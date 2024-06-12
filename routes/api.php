<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ShowBookController;
use App\Http\Controllers\API\ShowPeminjamanController;

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

Route::post('/login', [AuthController::class, 'login']);

// Reset Password Route
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Forget Password Route
Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
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
});