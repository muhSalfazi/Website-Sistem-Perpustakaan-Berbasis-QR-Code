<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function showLoginForm()
    {
        // Pengecekan apakah pengguna sudah login
        if (Auth::check()) {
            return redirect()->route('dashboard'); // Alihkan ke halaman dashboard jika sudah login
        }
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
            $user = Auth::user();

            // Cek apakah pengguna adalah admin
            if ($user->role !== 'admin') {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Hanya admin yang dapat mengakses halaman ini.');
            }

            // Update last_login
            User::where('id', $user->id)->update(['last_login' => Carbon::now()]);

            // Set session timeout to 1 hour
            Session::put('lastActivityTime', Carbon::now());

            // Redirect langsung ke halaman dashboard setelah login berhasil
            return redirect()->route('dashboard');
        }

        // Jika gagal login, redirect kembali ke halaman login dengan parameter error=true
        return redirect()->route('login')->withInput()->with('error', 'Email atau password salah');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke halaman login setelah logout
        return redirect()->route('login')->with('success', 'Logout berhasil');
    }
}