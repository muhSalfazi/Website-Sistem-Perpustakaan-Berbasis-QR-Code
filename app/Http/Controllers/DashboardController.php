<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Denda;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Menghitung jumlah anggota baru yang dibuat hari ini
        $newMembersCount = Member::whereDate('created_at', today())->count();

        // Menghitung jumlah buku yang sedang dipinjam hari ini
        $borrowingBooksCount = Peminjaman::whereDate('created_at', today())->count();

        // Menghitung jumlah buku yang telah dikembalikan hari ini
        $returnBooksCount = Peminjaman::whereDate('return_date', today())->count();

        // Menghitung jumlah buku yang terlambat dikembalikan (denda)
        $overdueBooksCount = Peminjaman::where('created_at', '<', Carbon::now()->subDays(7))->count();

        // Menghitung jumlah member yang memiliki peminjaman yang sudah jatuh tempo
        $overdueMembersCount = Peminjaman::where('created_at', '<', Carbon::now())
            ->whereNull('return_date') // memastikan buku belum dikembalikan
            ->distinct('member_id') // memastikan menghitung anggota unik
            ->count('member_id');

        // Mendapatkan ikhtisar 7 hari terakhir atau berdasarkan bulan yang dipilih
        $ikhtisarDays = $request->input('days', 7);  // default 7 hari jika tidak ada input
        $startDate = now()->subDays($ikhtisarDays);
        $endDate = now();

        $ikhtisar = Peminjaman::whereBetween('created_at', [$startDate, $endDate])->get();

        // Total Pendapatan Denda
        $totalDenda = Denda::sum('uang_yg_dibyrkn');

        // Total Tunggakan
        $totalTunggakan = Denda::sum('denda_yg_dibyr');

        // Total Pendapatan Denda Tahun Lalu
        $lastYearTotalDenda = Denda::whereYear('created_at', now()->subYear()->year)->sum('uang_yg_dibyrkn');

        // Total Tunggakan Tahun Lalu
        $lastYearTotalTunggakan = Denda::whereYear('created_at', now()->subYear()->year)->sum('denda_yg_dibyr');

        // Data untuk dikirim ke view
        $data = compact(
            'newMembersCount',
            'borrowingBooksCount',
            'returnBooksCount',
            'overdueBooksCount',
            'overdueMembersCount',
            'ikhtisar',
            'totalDenda',
            'totalTunggakan',
            'lastYearTotalDenda',
            'lastYearTotalTunggakan',
            'ikhtisarDays'
        );

        return view('dashboard', $data);
    }
}