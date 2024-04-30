<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use App\Models\AdminModels;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function showLoginForm()
    {
        // Pengecekan apakah pengguna sudah login
        if (Auth::check()) {
            return redirect()->route('welcome'); // Alihkan ke halaman selamat datang jika sudah login
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
    // Update last_login
    $user = Auth::user();
    AdminModels::where('id', $user->id)->update(['last_login' => Carbon::now()]);

    // Redirect langsung ke halaman selamat datang setelah login berhasil
    // return redirect()->route('welcome')->with('success', 'Login successful!');
            return response()->view('welcome')->header('Cache-Control', 'no-cache, no-store, must-revalidate');
}
        // Jika gagal login, redirect kembali ke halaman login dengan parameter error=true
        return redirect()->route('login')->withInput()->with('error', 'Email atau password salah');
    }
}