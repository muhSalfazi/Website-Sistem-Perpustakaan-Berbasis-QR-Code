<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denda;

class HistoryTransaksiController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil hanya data Denda yang memiliki status 'lunas'
        $peminjamans = Denda::with('peminjaman.member', 'peminjaman.book')
            ->where('status', 'lunas')
            ->get();

        return view('Denda.history', compact('peminjamans'));
    }
}