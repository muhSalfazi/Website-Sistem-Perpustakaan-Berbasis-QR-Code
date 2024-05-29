<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MemberController;
use App\Http\Controllers\API\AuthController;

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
// Protected Routes
Route::middleware(['jwt.auth'])->group(function () {
    Route::get('/members', [MemberController::class, 'index']);
    Route::get('/members/{id}', [MemberController::class, 'show']);
    Route::put('/members/{id}', [MemberController::class, 'update']);
    Route::delete('/members/{id}', [MemberController::class, 'destroy']);
    
});