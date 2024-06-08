<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\PeminjamanController;
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

Route::get('/email/verify/{token}', 'Auth\VerificationController@verify')->name('verification.verify');
Route::post('/register', [MemberController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);

// Reset Password Route
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// Forget Password Route
Route::post('/forget-password', [AuthController::class, 'forgetPassword']);
// Protected Routes
Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/members', [MemberController::class, 'index']);
    Route::get('/members/{id}', [MemberController::class, 'show']);
    Route::post('/members/{id}', [MemberController::class, 'update']);
    Route::delete('/members/{id}', [MemberController::class, 'destroy']);
    Route::post('/peminjaman/scan', [PeminjamanController::class, 'scan']);
    
});