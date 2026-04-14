<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use App\Models\DaftarPoli;
use App\Models\Periksa;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $id_dokter = Auth::id();

        // Mengambil data jadwal untuk tabel dan card
        $jadwal_periksa = JadwalPeriksa::where('id_dokter', $id_dokter)->get();
        $total_jadwal = $jadwal_periksa->count();

        // Menghitung pasien menunggu (DaftarPoli yang belum ada di tabel Periksa)
        $pasien_menunggu = DaftarPoli::whereHas('jadwalPeriksa', function($q) use ($id_dokter) {
            $q->where('id_dokter', $id_dokter);
        })->whereDoesntHave('periksa')->count();

        // Menghitung total riwayat pasien yang sudah diperiksa oleh dokter ini
        $total_riwayat = Periksa::whereHas('daftarPoli.jadwalPeriksa', function($q) use ($id_dokter) {
            $q->where('id_dokter', $id_dokter);
        })->count();

        return view('dokter.dashboard', compact(
            'jadwal_periksa', 
            'total_jadwal', 
            'pasien_menunggu', 
            'total_riwayat'
        ));
    }
}