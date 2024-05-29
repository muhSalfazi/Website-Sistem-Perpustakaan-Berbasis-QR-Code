<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User; // Ensure this path is correct
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage; // Include for storage functionality
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter as PngResponseWriter; // Use correct writer

class MemberController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|string|max:255',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:members',
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string',
            'date_of_birth' => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $member = User::create($request->all());

        // Generate QR Code
        $qrCode = new QrCode($member->id);
        $writer = new PngResponseWriter(); // Use the correct writer class

        $qrCodeData = $writer->write($qrCode)->getString(); // Get image data as string

        // Save QR code image data to storage
        $qrCodePath = 'public/qrcodes/' . $member->id . '.png'; // Note the 'public/' prefix
        Storage::put($qrCodePath, $qrCodeData);

        $member->qr_code = $qrCodePath;
        $member->save();

        // Generate JWT (unchanged)
        $payload = [
            'iss' => "your-issuer", // Issuer of the token
            'sub' => $member->id, // Subject of the token
            'iat' => time(), // Issued at time
            'exp' => time() + 60 * 60,
        ];

        $jwt = JWT::encode($payload, env('JWT_SECRET'), 'HS256');
        // Get QR code path from member object
        $qrCodePath = $member->qr_code;

        // Generate public URL for the QR code image
        $qrCodeUrl = Storage::url($qrCodePath);

        return response()->json([
            'member' => $member,
            'qr_code_url' => $qrCodeUrl,
            'token' => $jwt
        ], 201);

    }

    public function getQrCode($id)
    {
        $member = User::findOrFail($id);

        // Get QR code path from member object
        $qrCodePath = $member->qr_code;

        // Retrieve QR code image data from storage
        $qrCodeData = Storage::get($qrCodePath);

        // Return QR code image with appropriate content type
        return response($qrCodeData)->header('Content-Type', 'image/png');
    }

    // Other CRUD methods...
}