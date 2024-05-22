<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class MemberController extends Controller
{
    // Metode untuk menampilkan daftar anggota
    public function index()
    {
        // Fetch members data from the database
        $members = User::all(); // Mengambil semua data anggota dari database

        return view('member');
    }

    // Metode untuk menampilkan form pembuatan anggota baru
    public function create()
    {
        return view('member.create');
    }

    // Metode untuk menyimpan anggota baru
    public function store(Request $request)
    {
        // Validasi dan penyimpanan logika di sini
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:1,2',
        ]);

        // Contoh penyimpanan data ke dalam database
        User::create($request->all());

        return redirect()->route('members.index')->with('msg', 'Anggota berhasil ditambahkan!');
    }
}