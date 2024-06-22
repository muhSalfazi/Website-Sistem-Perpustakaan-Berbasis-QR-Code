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
        // Define the dates for the ikhtisar (overview)
        $ikhtisarDays = $request->input('days', 7);  // default 7 days if no input
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

        $totalDenda = Denda::sum('uang_yg_dibyrkn');
        $totalTunggakan = Denda::sum('denda_yg_dibyr');
        $lastYearTotalDenda = Denda::whereYear('created_at', now()->subYear()->year)->sum('uang_yg_dibyrkn');
        $lastYearTotalTunggakan = Denda::whereYear('created_at', now()->subYear()->year)->sum('denda_yg_dibyr');

        // Data to be passed to the view
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
            'ikhtisarDays'
        );

        return view('dashboard', $data);
    }
}