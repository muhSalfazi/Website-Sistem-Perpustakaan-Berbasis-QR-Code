<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DendaController extends Controller
{
    public function getDendaByUserId($user_id)
    {
        // Validate $user_id to ensure it is an integer
        if (!ctype_digit((string) $user_id)) {
            return response()->json(['message' => 'ID yang diberikan tidak valid'], 400);
        }

        // Fetch Member by user_id
        $member = Member::where('user_id', $user_id)->first();

        // Check if member exists   
        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }

        // Get peminjamans for the member
        $peminjamans = $member->peminjamans()->with(['book', 'denda'])->get();

        // Prepare response data
        $data = [];
        foreach ($peminjamans as $peminjaman) {
            $tgl_pengembalian = $peminjaman->return_date instanceof \DateTime
                ? $peminjaman->return_date
                : Carbon::parse($peminjaman->return_date);

            // Calculate the difference in days between return_date and created_at
            $created_at = Carbon::parse($peminjaman->created_at);
            $return_date = Carbon::parse($peminjaman->return_date);
            $telat = $return_date->diffInDays($created_at) - 7; // subtract 7 days as grace period

            // Skip peminjaman if not late
            if ($telat <= 0) {
                continue;
            }

            // Fetch Denda record associated with this Peminjaman
            $denda = $peminjaman->denda;

            // Determine if there is a fine and status from Denda model
            $denda_bayar = 0;
            $status_lunas = 'Belum Lunas'; // Default value

            if ($denda) {
                $denda_bayar = $denda->denda_yg_dibyr;
                $status_lunas = $denda->status === 'lunas' ? 'Lunas' : 'Belum Lunas';
            }

            $data[] = [
                'resi' => $peminjaman->resi_pjmn,
                'nama_member' => $member->first_name . ' ' . $member->last_name,
                'judul_buku' => $peminjaman->book->title,
                'author' => $peminjaman->book->author,
                'tgl_pinjam' => $created_at,
                'tgl_pengembalian' => $tgl_pengembalian,
                'denda_bayar' => $denda_bayar,
                'uang_yg_dibyrkn' => $denda && $denda->uang_yg_dibyrkn > 0 ? $denda->uang_yg_dibyrkn : 'belum bayar',
                'status_pengembalian' => "Telat {$telat} hari dari batas pengembalian",
                'status_lunas' => $status_lunas,
            ];
        }

        // Check if there are no fines to display
        if (empty($data)) {
            return response()->json(['message' => 'Tidak ada denda untuk member ini'], 404);
        }

        return response()->json($data);
    }
}