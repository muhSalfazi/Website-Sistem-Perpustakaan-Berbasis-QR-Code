<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            session()->flash('error', 'Email atau password harus diisi.');
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                Auth::logout();
                session()->flash('error', 'Hanya admin yang dapat mengakses halaman ini.');
                return redirect()->route('login');
            }

            User::where('id', $user->id)->update(['last_login' => Carbon::now()]);
            Session::put('lastActivityTime', Carbon::now());

            session()->flash('success', 'Login berhasil!');
            return redirect()->route('dashboard');
        }

        session()->flash('error', 'Email atau password salah');
        return redirect()->route('login')->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session()->flash('success', 'Logout berhasil');
        return redirect()->route('login');
    }
}