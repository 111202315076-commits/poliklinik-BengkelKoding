<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Poli;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Obat;


class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            // CARD
            'totalPoli'   => Poli::count(),
            'totalDokter' => User::where('role', 'dokter')->count(),
            'totalPasien' => User::where('role', 'pasien')->count(),
            'totalObat'   => Obat::count(),

            // DATA TABEL
            'dataPoli' => Poli::with('dokters')->latest()->take(5)->get(),
            'dokterTerbaru' => User::where('role', 'dokter')->latest()->take(5)->get(),
            'pasienTerbaru' => User::where('role', 'pasien')->latest()->take(5)->get(),
        ]);
    }
}