<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Firebase\JWT\JWT;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

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

        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }

        // Ensure only users can login
        if ($user->role == 'user') {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

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

    // Metode untuk meminta reset password
    public function forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Reset password link sent to your email address.'], 200);
        }

        return response()->json(['message' => 'Unable to send reset password link.'], 400);
    }

    // Metode untuk menyetel ulang password
    public function resetPassword(Request $request, $token)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:4|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = User::where('reset_token', $token)
            ->where('reset_token_created_at', '>', now()->subHours(1))
            ->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid or expired token'], 400);
        }

        // Set new password and clear reset token
        $user->password = Hash::make($request->password);
        $user->reset_token = null;
        $user->reset_token_created_at = null;
        $user->save();

        return response()->json(['message' => 'Password reset successfully'], 200);
    }
}