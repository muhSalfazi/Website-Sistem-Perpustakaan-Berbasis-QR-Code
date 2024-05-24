<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    //
    public function index()
    {
        // Fetch members data from the database
        // $members = User::all(); // Mengambil semua data anggota dari database

        return view('peminjaman');
    }

     public function search()
    {
        // Fetch members data from the database
        // $members = User::all(); // Mengambil semua data anggota dari database

        return view('peminjaman.search');
    }

    

}