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
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Email atau Password Salah!');
    }

    // PROSES REGISTER
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'alamat'   => 'required|string',
            'no_ktp'   => 'required|string|unique:users,no_ktp',
            'no_hp'    => 'required|string',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $lastPasien = User::where('role', 'pasien')
            ->orderBy('id', 'desc')
            ->first();

        $lastId = $lastPasien ? $lastPasien->id + 1 : 1;

        $no_rm = date('Ym') . '-' . str_pad($lastId, 3, '0', STR_PAD_LEFT);

        User::create([
            'name'     => $request->name,
            'alamat'   => $request->alamat,
            'no_ktp'   => $request->no_ktp,
            'no_hp'    => $request->no_hp,
            'no_rm'    => $no_rm,
            'role'     => 'pasien',
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login.');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}