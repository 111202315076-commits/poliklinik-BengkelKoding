<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\JadwalPeriksa;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller 
{
    public function index()
    {
        $user = Auth::user();

        $pasienId = $user->id;

        $antrianAktif = DaftarPoli::where('id_pasien', $pasienId)
            ->where('status_periksa', '0') 
            ->with(['jadwalPeriksa.dokter.poli'])
            ->latest()
            ->first();

        // Ambil nomor antrian yang sedang dilayani untuk setiap jadwal
        $daftarJadwal = JadwalPeriksa::with(['dokter.poli'])->get()->map(function($jadwal) {
            $jadwal->antrian_sekarang = DaftarPoli::where('id_jadwal', $jadwal->id)
                ->where('status_periksa', '1')
                ->max('no_antrian') ?? 0;
            return $jadwal;
        });

        // Jika ada antrian aktif, tambahkan info antrian sekarang untuk jadwal tersebut
        if ($antrianAktif) {
            $antrianAktif->antrian_sekarang = DaftarPoli::where('id_jadwal', $antrianAktif->id_jadwal)
                ->where('status_periksa', '1')
                ->max('no_antrian') ?? 0;
        }

        return view('pasien.dashboard', compact('antrianAktif', 'daftarJadwal'));
    }
}