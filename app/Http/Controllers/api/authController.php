<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\RateLimiter;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $credentials = $request->only('email', 'password');
        $email = $credentials['email'];

        $key = 'login-attempts:' . $email;

        if (RateLimiter::tooManyAttempts($key, 3)) {
            return response()->json(['error' => 'Terlalu banyak upaya login. Silakan coba lagi nanti.'], 429);
        }

        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            RateLimiter::hit($key);
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Ensure only users with proper roles can login
        if ($user->role != 'member') {
            RateLimiter::hit($key);
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Clear rate limit hits on successful login
        RateLimiter::clear($key);

        // Update last_login timestamp
        $user->last_login = now();
        $user->save();

        // Generate JWT
        $payload = [
            'iss' => "your-issuer",
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60 * 60, // Token expiration: 1 hour
        ];

        $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');

        return response()->json([
            'message' => 'Login successful',
            'user' => $user,
            'token' => $jwt,
        ], 200);
    }

    // Method to request a password reset link
   public function forgetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|email',
    ]);

    // Cari user berdasarkan email
    $user = User::where('email', $request->email)->first();

    // Jika user tidak ditemukan
    if (!$user) {
        return response()->json(['message' => 'Email tidak ditemukan'], 404);
    }

    // Generate 5-digit random token
    $token = rand(10000, 99999);

    // Simpan token ke user
    $user->reset_token = $token;
    $user->reset_token_created_at = now();
    $user->save();

    // Durasi token (1 jam)
    $tokenDuration = 1; // dalam jam

    // Send email
    Mail::to($user->email)->send(new ResetPasswordMail($token, $tokenDuration));

    return response()->json(['message' => 'Tautan setel ulang kata sandi dikirimkan ke alamat email Anda.'], 200);
}


    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'reset_token' => 'required|string',
            'password' => 'required|string|min:4|confirmed',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('reset_token', $request->reset_token)
            ->where('reset_token_created_at', '>', now()->subHours(1))
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Token tidak valid atau kedaluwarsa'], 400);
        }

        // Set new password and clear reset token
        $user->password = Hash::make($request->password);
        $user->reset_token = null;
        $user->reset_token_created_at = null;
        $user->save();

        return response()->json(['message' => 'Password reset successfully'], 200);
    }

}