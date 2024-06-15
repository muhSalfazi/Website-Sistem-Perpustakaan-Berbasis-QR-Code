<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\RateLimiter;

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
        $ip = $request->ip();
        $key = 'login-attempts:' . $ip;

        // Check rate limit
        if (RateLimiter::tooManyAttempts($key, 3)) {
            return redirect()->route('login')->with('error', 'Terlalu banyak upaya login. Silakan coba lagi nanti.');
        }

        // Validate input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            RateLimiter::hit($key, 120); // Hit rate limit
            session()->flash('error', 'Email atau password harus diisi.');
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }

        // Attempt to authenticate user
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Check role
            if ($user->role !== 'admin') {
                Auth::logout();
                RateLimiter::hit($key, 120); // Hit rate limit
                session()->flash('error', 'Hanya admin yang dapat mengakses halaman ini.');
                return redirect()->route('login');
            }

            // Clear rate limit on successful login
            RateLimiter::clear($key);

            // Update last login time
            User::where('id', $user->id)->update(['last_login' => Carbon::now()]);
            Session::put('lastActivityTime', Carbon::now());

            session()->flash('success', 'Login berhasil!');
            return redirect()->route('dashboard');
        }

        // Failed login attempt
        RateLimiter::hit($key, 120); // Hit rate limit
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