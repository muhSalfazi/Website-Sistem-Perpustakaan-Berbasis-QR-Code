<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    //
    public function index()
    {
        // Fetch members data from the database
        // $members = User::all(); // Mengambil semua data anggota dari database

        return view('pengembalian');
    }

}