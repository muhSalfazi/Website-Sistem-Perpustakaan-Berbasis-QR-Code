<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Response;

class MemberController extends Controller
{
    // Metode untuk registrasi anggota baru
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|max:255|unique:tbl_users,email',
            'password' => 'required|string|min:4|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Hash the password before storing it
        $hashedPassword = Hash::make($request->password);

        // Create the user with hashed password
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $hashedPassword,
            'role' => 'member',
        ]);

        // Generate QR code for the user
        $qrCodeData = $this->generateEncryptedQRCodeData($user->id);
        $user->qr_code = $qrCodeData;
        $user->save();

        // Create a corresponding member record
        Member::create([
            'user_id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'qr_code' => $user->qr_code,
        ]);

        $qrCodeUrl = asset('qrcodes/' . $user->qr_code); // Mengubah path untuk bisa diakses secara publik

        // Return the created user data
        return response()->json([
            'message' => 'Akun berhasil Terdaftar di libranation',
            'member' => $user,
            'qr_code_url' => $qrCodeUrl,
        ], 201);
    }
    // Metode untuk memperbarui informasi anggota
    public function update(Request $request, $id)
    {
        $member = User::find($id);

        if (!$member) {
            return response()->json(['message' => 'Pengguna tidak ditemukan'], 404);
        }

        // Check if user is trying to change readonly fields
        if ($request->has('first_name') && $request->first_name !== $member->first_name) {
            return response()->json(['message' => 'Nama depan tidak dapat diubah'], 400);
        }
        if ($request->has('last_name') && $request->last_name !== $member->last_name) {
            return response()->json(['message' => 'Nama belakang tidak dapat diubah'], 400);
        }
        if ($request->has('email') && $request->email !== $member->email) {
            return response()->json(['message' => 'Email tidak dapat diubah'], 400);
        }

        $validator = Validator::make($request->all(), [
            'password' => 'sometimes|string|min:5',
            'phone' => 'sometimes|string|max:20',
            'address' => 'sometimes|string',
            'tgl_lahir' => 'sometimes|date',
            'imageProfile' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:5120', // Maksimum 5 MB
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        if ($request->hasFile('imageProfile')) {
            $imageFile = $request->file('imageProfile');

            // Memeriksa apakah file gambar terlalu besar
            if ($imageFile->getSize() > 5120 * 1024) {
                return response()->json(['message' => 'Ukuran gambar terlalu besar. Ukuran maksimalnya adalah 5MB.'], 400);
            }

            // Buat nama file gambar profil acak dengan menggunakan Str::random()
            $imageFileName = Str::random(40) . '.' . $imageFile->getClientOriginalExtension();
            $imagePath = $imageFile->storeAs('public/profiles', $imageFileName);

            // Hapus file gambar profil lama jika ada
            if ($member->imageProfile) {
                Storage::delete('public/profiles/' . $member->imageProfile);
            }

            $member->imageProfile = $imageFileName;

            // Tambahkan pernyataan log untuk memeriksa lokasi penyimpanan gambar
            info('Berkas berhasil diunggah. Disimpan di: ' . $imagePath);
        } else {
            info('Tidak ada file gambar yang diunggah.');
        }

        // Generate and save QR code if necessary
        if (!$member->qr_code || $request->has('first_name') || $request->has('last_name') || $request->has('email')) {
            $qrCodeData = $this->generateEncryptedQRCodeData($member->id);
            $member->qr_code = $qrCodeData;
        }

        // Update other fields...
        if ($request->has('password')) {
            $member->password = Hash::make($request->password);
        }
        if ($request->has('phone')) {
            $member->phone = $request->phone;
        }
        if ($request->has('address')) {
            $member->address = $request->address;
        }
        if ($request->has('tgl_lahir')) {
            $member->tgl_lahir = $request->tgl_lahir;
        }

        $member->save();

        $qrCodeUrl = asset('qrcodes/' . $member->qr_code); // Mengubah path untuk bisa diakses secara publik
        $imageProfileUrl = asset('storage/profiles/' . $member->imageProfile); // URL untuk image profile

        return response()->json([
            'message' => 'Member updated successfully',
            'member' => $member,
            'qr_code_url' => $qrCodeUrl,
            'image_profile_url' => $imageProfileUrl, 
        ], 200);
    }


    private function generateEncryptedQRCodeData($memberId)
    {
        $member = User::find($memberId);

        $data = [
            'first_name' => $member->first_name,
            'last_name' => $member->last_name,
            'email' => $member->email,
            'imageProfile' => $member->imageProfile ? asset('storage/profiles/' . $member->imageProfile) : null,
        ];

        $encryptedData = Crypt::encryptString(json_encode($data));
        $qrCode = new QrCode($encryptedData);
        $writer = new PngWriter();

        // Ubah format nama file QR code menjadi sesuai dengan data anggota
        $qrCodeFileName = $member->first_name . '-' . $member->last_name . '.png';

        $qrCodePath = 'qrcodes/' . $qrCodeFileName; // Mengubah lokasi penyimpanan QR code

        $qrCodeData = $writer->write($qrCode)->getString();

        file_put_contents(public_path($qrCodePath), $qrCodeData);

        return $qrCodeFileName;
    }
}