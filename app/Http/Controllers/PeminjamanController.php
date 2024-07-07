<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Member;
use App\Models\Peminjaman;
use App\Models\Book;
use App\Models\Kategori;
use App\Models\Denda;
use App\Models\User;
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
        $peminjamans = Peminjaman::whereNull('return_date')->get();

        $peminjamans = $query->get();

        return view('Peminjaman.daftarpeminjaman', compact('peminjamans'));
    }

    public function search()
    {
        return view('Peminjaman.search');
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

        // Lakukan pencarian anggota berdasarkan user_id
        $member = Member::where('user_id', $data['user_id'])->first();

        if ($member) {
            $user = User::find($data['user_id']);

            if ($user->qr_code !== $data['qr_code']) {
                return response()->json(['error' => 'QR code expired or invalid'], 400);
            }

            $updatedAt = new \DateTime($data['updated_at']);
            $now = new \DateTime();
            $timeDifference = $now->getTimestamp() - $updatedAt->getTimestamp();
            $minuteDifference = floor($timeDifference / 60);

            if ($minuteDifference > 1) {
                return response()->json(['error' => 'QR code expired'], 400);
            }

            // Kembalikan data anggota
            return response()->json(['member' => $member], 200);
        } else {
            return response()->json(['error' => 'Member not found'], 404);
        }
    }



    public function searchBookPage(Request $request)
    {
        // Mendapatkan nama anggota dari member_id yang diterima dari request
        $memberId = $request->input('member_id');
        $member = Member::find($memberId);

        // Mendapatkan input pencarian
        $search = $request->input('search');

        // Membangun query untuk pencarian buku
        $query = Book::query();

        if ($search) {
            $query->where('title', 'like', "%$search%")
                ->orWhere('publisher', 'like', "%$search%")
                ->orWhere('author', 'like', "%$search%")
                ->orWhereHas('category', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                });
        }

        $books = $query->paginate(10);

        // Mendapatkan semua kategori untuk dropdown filter
        $categories = Kategori::all();

        return view('Peminjaman.searchBook', compact('memberId', 'member', 'books', 'categories'));
    }

    // Metode pengontrol untuk menangani peminjaman buku
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

        // Periksa apakah anggota mempunyai buku yang sudah lewat jatuh tempo
        $borrowedBooksCount = Peminjaman::where('member_id', $memberId)
            ->whereNull('return_date')
            ->count();

        // Periksa apakah anggota memiliki denda yang belum dibayar
        $unpaidFinesCount = Denda::whereHas('peminjaman', function ($query) use ($memberId) {
            $query->where('member_id', $memberId);
        })->where('status', 'belum lunas')->count();

        // Membolehkan peminjaman apabila anggota mempunyai kurang dari 3 buku yang belum dikembalikan dan tidak ada denda yang belum dibayar
        if ($borrowedBooksCount >= 3) {
            return redirect()->back()->with('error', 'Anggota masih memiliki 3 atau lebih peminjaman yang belum dikembalikan.');
        }

        if ($unpaidFinesCount > 0) {
            return redirect()->back()->with('error', 'Anggota masih memiliki tunggakan denda.');
        }

        // Periksa apakah anggota sudah meminjam buku yang sama
        $existingLoan = Peminjaman::where('member_id', $memberId)
            ->where('book_id', $bookId)
            ->whereNull('return_date')
            ->first();

        if ($existingLoan) {
            return redirect()->back()->with('error', 'Anggota sudah meminjam buku yang sama.');
        }

        // Check if the book is available
        if ($book->bookStock->jmlh_tersedia <= 0) {
            return redirect()->back()->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        // Buat catatan peminjaman baru
        $peminjaman = new Peminjaman();
        $uniqueCode = Str::random(5); // Generate a random string of 10 characters

        // Periksa apakah kode yang dihasilkan sudah ada di database
        while (Peminjaman::where('resi_pjmn', $uniqueCode)->exists()) {
            // Jika kode sudah ada, buat yang baru
            $uniqueCode = Str::random(5);
        }

        // Sekarang $uniqueCode berisi nilai unik untuk kolom resi_pjmn
        $peminjaman->resi_pjmn = $uniqueCode;
        $peminjaman->member_id = $memberId;
        $peminjaman->book_id = $bookId;

        // Mengurangi jumlah buku yang tersedia
        $bookStock = $book->bookStock;
        $bookStock->jmlh_tersedia -= 1;
        $bookStock->save();

        $peminjaman->save();

        $qrCodeData = [
            'resi_pjmn' => $uniqueCode,
            'nama_member' => $member->first_name . ' ' . $member->last_name,
            'judul_buku' => $book->judul_buku,
            // Add more data as needed
        ];

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