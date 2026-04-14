<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    public function index()
    {
        $pasienId = Auth::id();
        
        // Ambil pendaftaran yang sudah diperiksa tapi belum lunas
        $tagihans = DaftarPoli::with(['jadwalPeriksa.dokter.poli', 'periksa'])
            ->where('id_pasien', $pasienId)
            ->where('status_periksa', '1')
            ->whereHas('periksa', function($q) {
                $q->where('status_bayar', '!=', 'lunas');
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('pasien.pembayaran.index', compact('tagihans'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $periksa = Periksa::findOrFail($id);
        
        if ($request->hasFile('bukti_bayar')) {
            // Delete old file if exists
            if ($periksa->bukti_bayar) {
                Storage::disk('public')->delete($periksa->bukti_bayar);
            }
            
            $file = $request->file('bukti_bayar');
            $path = $file->store('bukti_bayar', 'public');
            
            $periksa->update([
                'bukti_bayar' => $path,
                'status_bayar' => 'menunggu_verifikasi'
            ]);
            
            return redirect()->route('pasien.pembayaran.index')->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi admin.');
        }
        
        return back()->with('error', 'Gagal mengupload bukti pembayaran.');
    }
}
