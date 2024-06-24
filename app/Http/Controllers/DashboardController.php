<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Menghitung jumlah anggota baru yang dibuat hari ini
        $newMembersCountToday = Member::whereDate('created_at', today())->count();

        // Menghitung jumlah buku yang sedang dipinjam hari ini
        $borrowingBooksCountToday = Peminjaman::whereDate('created_at', today())
            ->whereNull('return_date') // hanya yang belum dikembalikan
            ->count();

        // Menghitung jumlah buku yang telah dikembalikan hari ini
        $returnBooksCountToday = Peminjaman::whereDate('return_date', today())->count();

        // Menghitung jumlah buku yang terlambat dikembalikan (denda)
        $overdueBooksCountToday = Peminjaman::where('created_at', '<', Carbon::now()->subDays(7))->count();

        // Menghitung jumlah member yang memiliki peminjaman yang sudah jatuh tempo
        $overdueMembersCountToday = Peminjaman::where('return_date', null)
            ->where('created_at', '<', Carbon::now()->subDays(7))
            ->distinct('member_id')
            ->count('member_id');

        // Define the dates for the ikhtisar (overview)
        $ikhtisarDays = $request->input('days', 30);  // default 7 days if no input
        $startDate = now()->subDays($ikhtisarDays);
        $endDate = now();

        // Get the necessary data
        $newMembersCount = Member::whereDate('created_at', '>=', $startDate)->count();
        $borrowingBooksCount = Peminjaman::whereDate('created_at', '>=', $startDate)->count();
        $returnBooksCount = Peminjaman::whereDate('return_date', '>=', $startDate)->count();
        $overdueBooksCount = Peminjaman::where('created_at', '<', Carbon::now()->subDays(7))->count();
        $overdueMembersCount = Peminjaman::where('created_at', '<', Carbon::now()->subDays(7))
            ->whereNull('return_date')
            ->distinct('member_id')
            ->count('member_id');

        $totalDenda = Denda::whereColumn('denda_yg_dibyr', '<=', 'uang_yg_dibyrkn')
            ->orWhere('denda_yg_dibyr', 0) // tambahkan kondisi jika denda_yg_dibyr = 0 (menghindari pembagian dengan nol)
            ->sum('denda_yg_dibyr');

        // Hitung total tunggakan, hanya kasus di mana pembayaran cukup besar
        $totalTunggakan = Denda::whereColumn('denda_yg_dibyr', '>', 'uang_yg_dibyrkn')
            ->orWhere('denda_yg_dibyr', 0) // tambahkan kondisi jika denda_yg_dibyr = 0 (menghindari pembagian dengan nol)
            ->sum('denda_yg_dibyr');

        $lastYearTotalDenda = Denda::whereYear('created_at', now()->subYear()->year)->sum('uang_yg_dibyrkn');
        $lastYearTotalTunggakan = Denda::whereYear('created_at', now()->subYear()->year)
            ->whereColumn('denda_yg_dibyr', '>', 'uang_yg_dibyrkn')
            ->orWhere('denda_yg_dibyr', 0) // tambahkan kondisi jika denda_yg_dibyr = 0
            ->sum('denda_yg_dibyr');

        // Data yang akan dikirimkan ke tampilan
        $data = compact(
            'newMembersCount',
            'borrowingBooksCount',
            'returnBooksCount',
            'overdueBooksCount',
            'overdueMembersCount',
            'totalDenda',
            'totalTunggakan',
            'lastYearTotalDenda',
            'lastYearTotalTunggakan',
            'ikhtisarDays',
            'newMembersCountToday',
            'borrowingBooksCountToday',
            'returnBooksCountToday',
            'overdueBooksCountToday',
            'overdueMembersCountToday'
        );

        return view('dashboard', $data);
    }
}