<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DendaController extends Controller
{
    public function calculateFine($id_peminjaman)
    {
        // Validate $id_peminjaman to ensure it is an integer
        if (!ctype_digit((string) $id_peminjaman)) {
            return response()->json(['message' => 'ID yang diberikan tidak valid'], 400);
        }

        // Fetch Peminjaman record by id_peminjaman with eager loading of related models (member, book, denda)
        $peminjaman = Peminjaman::with(['member', 'book', 'denda'])
            ->where('id', $id_peminjaman)
            ->first();

        // Check if record exists
        if (!$peminjaman) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        // Ensure return_date is treated as DateTime
        $tgl_pengembalian = $peminjaman->return_date instanceof \DateTime
            ? $peminjaman->return_date->format('Y-m-d')
            : $peminjaman->return_date;

        // Calculate the difference in days between return_date and created_at
        $created_at = Carbon::parse($peminjaman->created_at);
        $return_date = Carbon::parse($peminjaman->return_date);
        $telat = $return_date->diffInDays($created_at) - 7; // subtract 7 days as grace period

        // Fetch Denda record associated with this Peminjaman
        $denda = $peminjaman->denda;

        // Determine if there is a fine and status from Denda model
        $denda_bayar = 0;
        $status_lunas = null;

        if ($denda) {
            $denda_bayar = $denda->denda_yg_dibyr;
            $status_lunas = $denda->status ? 'Lunas' : 'Belum Lunas';
        }

        // Prepare data for response
        $data = [
            'resi' => $peminjaman->resi_pjmn,
            'nama_member' => $peminjaman->member->name,
            'judul_buku' => $peminjaman->book->title,
            'author' => $peminjaman->book->author,
            'tgl_pengembalian' => $tgl_pengembalian,
            'denda_bayar' => $denda_bayar,
            'uang_yg_dibyrkn' => $denda ? $denda->uang_yg_dibyrkn : 0,
            'status_pengembalian' => $telat > 0 ? "Telat {$telat} hari dari batas pengembalian" : 'Tidak Telat',
            'status_lunas' => $status_lunas,
        ];

        return response()->json($data);
    }
}