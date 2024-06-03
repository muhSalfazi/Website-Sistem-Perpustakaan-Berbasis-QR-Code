<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Member;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class PeminjamanController extends Controller
{
    public function index()
    {
        return view('peminjaman');
    }

    public function search()
    {
        return view('peminjaman.search');
    }

    public function searchMemberByEmail(Request $request)
    {
        // Validasi input email
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $email = $request->input('email');

        // Lakukan pencarian anggota berdasarkan alamat email
        $member = Member::where('email', $email)->first();

        // Mengembalikan respon dalam bentuk JSON
        return response()->json(['member' => $member]);
    }

    // Metode untuk memproses hasil pemindaian QR code dan pencarian berdasarkan email
    public function scanMemberByQRCode(Request $request)
    {
        // Validasi input QR code
        $validator = Validator::make($request->all(), [
            'qr_code' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $qrCodeContent = $request->input('qr_code');

        // Dekripsi data QR code
        try {
            $decryptedData = Crypt::decryptString($qrCodeContent);
            $data = json_decode($decryptedData, true);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid QR code'], 400);
        }

        // Lakukan pencarian anggota berdasarkan data yang didekripsi
        $member = Member::where('email', $data['email'])->first();

        // Jika anggota ditemukan, kembalikan data anggota
        if ($member) {
            return response()->json(['member' => $member]);
        } else {
            return response()->json(['error' => 'Member not found'], 404);
        }
    }
}