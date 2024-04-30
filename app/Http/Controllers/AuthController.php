<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Jika validasi gagal, redirect kembali ke halaman login dengan pesan error
        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Email atau password harus diisi.');
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Jika berhasil login
            return redirect()->route('welcome')->with('success', 'Login successful!');
        }

        // Jika gagal login, redirect kembali ke halaman login dengan parameter error=true
        return redirect()->route('login')->withInput()->with('error', 'Email atau password salah');
    }
}