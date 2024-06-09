<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Member;
use App\Models\Peminjaman;
use App\Models\Book;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Peminjaman::with(['member']);

        if ($search) {
            $query->whereHas('member', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%");
            });
        }
        $peminjamans = Peminjaman::whereNull('return_date')->paginate(10);

        $peminjamans = $query->paginate(10);

        return view('Peminjaman.daftarpeminjaman', compact('peminjamans'));
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
        $member = Member::where('email', $data['email'])->get();

        // Jika anggota ditemukan, kembalikan data anggota
        if ($member->isNotEmpty()) {
            // Menggunakan get() untuk mendapatkan satu hasil
            return response()->json(['member' => $member->first()]);
        } else {
            return response()->json(['error' => 'Member not found'], 404);
        }
    }

    public function searchBookPage(Request $request)
    {
        // Mendapatkan nama anggota dari member_id yang diterima dari request
        $memberId = $request->input('member_id');
        $member = Member::find($memberId);
        // Lakukan pencarian buku berdasarkan request dan kirim data ke tampilan
        $search = $request->input('search');
        $books = Book::where('title', 'like', "%$search%")
            ->orWhere('publisher', 'like', "%$search%")
            ->orWhere('author', 'like', "%$search%")
            ->paginate(10);

        return view('Peminjaman.searchBook', compact('memberId', 'member', 'books'));
    }


    // Controller method to handle book borrowing
    public function storePeminjaman(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|exists:tbl_members,id',
            'book_id' => 'required|exists:tbl_books,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $memberId = $request->input('member_id');
        $bookId = $request->input('book_id');

        // Temukan anggota berdasarkan member_id
        $member = Member::find($memberId);

        // Pastikan anggota ditemukan
        if (!$member) {
            return redirect()->back()->with('error', 'Anggota tidak ditemukan.');
        }

        $book = Book::find($bookId);

        // Pastikan buku ditemukan
        if (!$book) {
            return redirect()->back()->with('error', 'Buku tidak ditemukan.');
        }

        // Check if the member has reached maximum borrowing limit
        $borrowedBooksCount = Peminjaman::where('member_id', $memberId)->count();
        if ($borrowedBooksCount >= 3) {
            return redirect()->back()->with('error', 'Anggota telah mencapai batas maksimal peminjaman (3 buku).');
        }

        // Check if the book is available
        if ($book->bookStock->jmlh_tersedia <= 0) {
            return redirect()->back()->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        // Create a new borrowing record
        $peminjaman = new Peminjaman();
        $uniqueCode = Str::random(10); // Generate a random string of 10 characters

        // Check if the generated code already exists in the database
        while (Peminjaman::where('resi_pjmn', $uniqueCode)->exists()) {
            // If the code already exists, generate a new one
            $uniqueCode = Str::random(10);
        }

        // Now $uniqueCode contains a unique value for the resi_pjmn column
        $peminjaman->resi_pjmn = $uniqueCode;
        $peminjaman->member_id = $memberId;
        $peminjaman->book_id = $bookId;

        // Mengurangi jumlah buku yang tersedia
        $bookStock = $book->bookStock;
        $bookStock->jmlh_tersedia -= 1;
        $bookStock->save();

        $peminjaman->save();

        // Generate QR code for the borrowing transaction
        $qrCodeData = [
            'resi_pjmn' => $uniqueCode,
            'nama_member' => $member->first_name . ' ' . $member->last_name,
            'judul_buku' => $book->judul_buku,
            // Add more data as needed
        ];

        // // Create QR code
        // $qrCode = new QrCode(json_encode($qrCodeData));
        // $qrCode->setSize(300);

        // // Set the writer
        // $writer = new PngWriter();

        // // Set the QR code file path
        // $qrCodePath = 'qrcodePJMN/' . $uniqueCode . '.png';

        // // Write the QR code to the specified path
        // $qrCodeData = $writer->write($qrCode)->getString();
        // file_put_contents(public_path($qrCodePath), $qrCodeData);

        // // Save the QR code path to the database
        // DB::table('tbl_peminjaman')
        //     ->where('resi_pjmn', $uniqueCode)
        //     ->update(['qr_code' => $qrCodePath]);

        // Mengirim email
       
        return redirect()->back()->with('success', 'Buku berhasil dipinjam.');
    }

    public function destroy($id)
    {
        // Temukan data peminjaman berdasarkan ID
        $peminjaman = Peminjaman::find($id);

        // Pastikan data peminjaman ditemukan
        if (!$peminjaman) {
            return redirect()->back()->with('error', 'Data peminjaman tidak ditemukan.');
        }

        // Kembalikan jumlah buku yang tersedia saat peminjaman dihapus
        $bookStock = $peminjaman->book->bookStock;
        $bookStock->jmlh_tersedia += 1;
        $bookStock->save();

        // Hapus data peminjaman
        $peminjaman->delete();

        return redirect()->back()->with('success', 'Data peminjaman berhasil dihapus.');
        
    }
}