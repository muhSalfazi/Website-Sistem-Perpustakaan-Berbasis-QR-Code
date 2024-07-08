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

    public function team()
    {
    $members = [
    [
    'id' => 'salman',
    'name' => 'M. Salman Fauzi',
    'role' => 'Back End Web Developer',
    'image' => 'salman.jpg',
    'instagram' => 'https://www.instagram.com/muh.salfazi/',
    'nim' => '22416255201063',
    'github' => 'https://github.com/MuhSalfazi',
    ],
     [
     'id' => 'dewi',
     'name' => 'Dewi Puspa Ningrum',
     'role' => 'Back End Mobile Developer',
     'image' => 'dewi.jpg',
     'instagram' => 'https://www.instagram.com/rangga/',
     'nim' => '22416255201276',
     'github' => 'https://github.com/rangga',
     ],
   
     [
     'id' => 'amir',
     'name' => 'Amir Syahrul Ramadhan',
     'role' => 'Front End Mobile Developer',
     'image' => 'amir.jpg',
     'instagram' => 'https://www.instagram.com/Amir Syahrul Ramadhan/',
    'nim' => '22416255201098',
     'github' => 'https://github.com/amirsr43',
     ],
      [
    'id' => 'nizar',
    'name' => 'Nizar Zul Islami',
  'role' => 'Systems design',
    'image' => 'nizar.jpg',
    'instagram' => 'https://www.instagram.com/nizarzull31/',
    'nim' => '22416255201074',
    'github' => 'https://github.com/nizar-art',
    ],
     [
     'id' => 'pipit',
     'name' => 'Pipit Fitria Zahara',
     'role' => 'Systems analysis',
     'image' => 'pipit.jpg',
     'instagram' => 'https://www.instagram.com//',
     'nim' => '22416255201126',
     'github' => 'https://github.com/rangga',
     ],
      [
      'id' => 'rangga',
      'name' => 'Rangga Egha Permana',
      'role' => 'Front End Web Developer',
      'image' => 'Rangga.jpg',
      'instagram' => 'https://www.instagram.com/rangga.eghaa_/',
      'nim' => '22416255201038',
      'github' => 'https://github.com/RanggaEgha',
      ],
     
    // Tambahkan anggota lainnya di sini
];
      return view('team', compact('members'));
    }
}