<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use App\Models\User;
use Carbon\Carbon; // Import Carbon for timestamp handling
use Illuminate\Support\Facades\Storage;

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

        // Get QR code URL from user data
        $qrCodePath = 'qrcodes/' . $user->first_name . '_' . $user->id . '.png';
        $qrCodeUrl = asset('storage/' . $qrCodePath); // Full URL including domain

        // Check if QR code file exists
        if (!Storage::disk('public')->exists($qrCodePath)) {
            return response()->json(['error' => 'QR code not found'], 404);
        }

        return response()->json([
            'user' => $user,
            'token' => $jwt,
            'qr_code_url' => $qrCodeUrl,
        ], 200);
    }




}