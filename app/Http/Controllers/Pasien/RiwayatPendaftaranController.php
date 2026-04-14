<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPendaftaranController extends Controller
{
    public function index()
    {
        $pasienId = Auth::id();
        
        $riwayats = DaftarPoli::with(['jadwalPeriksa.dokter.poli', 'periksa'])
            ->where('id_pasien', $pasienId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('pasien.riwayat_pendaftaran.index', compact('riwayats'));
    }

    public function show($id)
    {
        $pasienId = Auth::id();
        
        $riwayat = DaftarPoli::with(['jadwalPeriksa.dokter.poli', 'periksa.detailPeriksas.obat'])
            ->where('id_pasien', $pasienId)
            ->findOrFail($id);
            
        if (!$riwayat->periksa) {
            return redirect()->route('pasien.riwayat_pendaftaran.index')->with('error', 'Pemeriksaan belum selesai.');
        }
            
        return view('pasien.riwayat_pendaftaran.show', compact('riwayat'));
    }
}
