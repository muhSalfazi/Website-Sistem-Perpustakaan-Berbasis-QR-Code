<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denda;

class HistoryTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $peminjamans = Denda::with('peminjaman.member', 'peminjaman.book')->paginate(10);

        return view('Denda.history', compact('peminjamans'));
    }
}