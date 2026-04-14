<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Periksa;
use Illuminate\Http\Request;

class VerifikasiPembayaranController extends Controller
{
    public function index()
    {
        $tagihans = Periksa::with(['daftarPoli.pasien', 'daftarPoli.jadwalPeriksa.dokter.poli'])
            ->where('status_bayar', '!=', 'belum_bayar')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('admin.verifikasi_pembayaran.index', compact('tagihans'));
    }

    public function verifikasi(Request $request, $id)
    {
        $periksa = Periksa::findOrFail($id);
        
        $periksa->update([
            'status_bayar' => 'lunas'
        ]);
        
        return redirect()->route('admin.verifikasi_pembayaran.index')->with('success', 'Pembayaran berhasil dikonfirmasi.');
    }
}
