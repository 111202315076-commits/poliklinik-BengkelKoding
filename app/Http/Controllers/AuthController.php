<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // FORM LOGIN
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // FORM REGISTER
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('dashboard');
            } elseif ($user->role === 'doctor') {
                return redirect()->route('doctor.dashboard');
            } else {
                return redirect()->route('pasien.dashboard');
            }
        }

        return back()->withErrors(['email' => 'Email atau Password Salah!']);
    }

    // PROSES REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'no_ktp' => ['required', 'string', 'max:30'],
            'no_hp' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed'],
        ]);

        // cek no ktp
        if (User::where('no_ktp', $request->no_ktp)->exists()) {
            return back()->withErrors(['no_ktp' => 'No KTP sudah terdaftar!']);
        }

        User::create([
            'name' => $request->nama,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'pasien',
        ]);

        return redirect()->route('login');
    }

    // LOGOUT
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}