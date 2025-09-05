<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Tampilkan form register
    public function showRegister()
    {
        return view('register');
    }

    // Proses register hanya untuk pengguna
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pengguna', // role default pengguna
        ]);


        return redirect()->route('login.form')->with('success', 'Registrasi berhasil! Silakan login.');

    }

    // Tampilkan form login
    public function showLogin()
    {
        return view('login');
    }

    // Proses login untuk pakar dan pengguna
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            $user = Auth::user();
    
            if ($user->role == 'pakar') {
                return redirect()->route('pakar.dashboard');
            } elseif ($user->role == 'kepala_puskesmas') {
                return redirect()->route('kepala.dashboard');
            } else {
                return redirect()->route('dashboard.user');
            }
        }
    
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }
    
    // Logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}
