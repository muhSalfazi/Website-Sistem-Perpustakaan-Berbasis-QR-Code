<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash; // Import Hash class
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; // Import Str class
use Firebase\JWT\JWT;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nim' => 'required|string|max:255',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|string|email|max:255|unique:tbl_members',
            'password' => 'required|string|min:5',
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string',
            'date_of_birth' => 'sometimes|date',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Generate random QR code data
        $qrCodeData = Str::random(32);

        // Hash the password before storing it
        $hashedPassword = Hash::make($request->password);

        // Create the user with hashed password and random QR code data
        $member = User::create([
            'nim' => $request->nim,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $hashedPassword,
            'phone' => $request->phone,
            'address' => $request->address,
            'date_of_birth' => $request->date_of_birth,
            'qr_code' => $qrCodeData,
        ]);

        // Generate QR Code image and save to storage
        $qrCode = new QrCode($qrCodeData);
        $writer = new PngWriter();

        // Concatenate first name with member ID for QR code filename
        $qrCodePath = 'qrcodes/' . $request->first_name . '_' . $member->id . '.png';

        $qrCodeData = $writer->write($qrCode)->getString();
        Storage::disk('public')->put($qrCodePath, $qrCodeData);

        // Get QR code URL
        $qrCodeUrl = Storage::url($qrCodePath);

        return response()->json([
            'member' => $member,
            'qr_code_url' => $qrCodeUrl,
        ], 201);
    }


    public function update(Request $request, $id)
    {
        // Find the user by ID
        $member = User::find($id);

        // If user not found, return 404 error
        if (!$member) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'nim' => 'sometimes|string|max:255',
            'first_name' => 'sometimes|string|max:100',
            'last_name' => 'sometimes|string|max:100',
            'email' => 'sometimes|string|email|max:255|unique:tbl_members,email,' . $member->id,
            'password' => 'sometimes|string|min:5',
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string',
            'date_of_birth' => 'sometimes|date',
        ]);

        // If validation fails, return 400 error
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Update the member's information if provided in the request
        if ($request->has('nim')) {
            $member->nim = $request->nim;
        }
        if ($request->has('first_name')) {
            $member->first_name = $request->first_name;
        }
        if ($request->has('last_name')) {
            $member->last_name = $request->last_name;
        }
        if ($request->has('email')) {
            $member->email = $request->email;
        }
        if ($request->has('password')) {
            $hashedPassword = Hash::make($request->password);
            $member->password = $hashedPassword;
        }
        if ($request->has('phone')) {
            $member->phone = $request->phone;
        }
        if ($request->has('address')) {
            $member->address = $request->address;
        }
        if ($request->has('date_of_birth')) {
            $member->date_of_birth = $request->date_of_birth;
        }

        // Save the updated member information
        $member->save();

        // Return the updated member data
        return response()->json(['message' => 'Member updated successfully', 'member' => $member], 200);
    }


}