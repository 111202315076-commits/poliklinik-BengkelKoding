<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use App\Models\JadwalPeriksa;
use App\Models\DaftarPoli;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarPoliController extends Controller
{
    /**
     * Menampilkan halaman form pendaftaran poli
     */
    public function index()
    {
        // Mengambil semua poli untuk dropdown
        $polis = Poli::all();
        return view('pasien.daftar_poli', compact('polis'));
    }

    /**
     * Menyimpan data pendaftaran poli
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_jadwal' => 'required|exists:jadwal_periksa,id',
            'keluhan' => 'required|string|max:255',
        ]);

        $pasienId = Auth::id();

        // 1. CEK KETENTUAN: Pasien tidak dapat mendaftar jika masih ada antrian aktif (belum diperiksa)
        $cekAntrian = DaftarPoli::where('id_pasien', $pasienId)
            ->where('status_periksa', '0')
            ->exists();

        if ($cekAntrian) {
            return redirect()->back()->with('error', 'Anda masih memiliki antrian aktif. Selesaikan pemeriksaan sebelumnya terlebih dahulu.');
        }

        // 2. GENERATE NOMOR ANTRIAN: Ambil antrian terakhir pada jadwal tersebut
        $antrianTerakhir = DaftarPoli::where('id_jadwal', $request->id_jadwal)->max('no_antrian');
        $noAntrianBaru = ($antrianTerakhir ?? 0) + 1;

        // 3. SIMPAN DATA
        try {
            DaftarPoli::create([
                'id_pasien' => $pasienId,
                'id_jadwal' => $request->id_jadwal,
                'keluhan' => $request->keluhan,
                'no_antrian' => $noAntrianBaru,
'status_periksa' => '0' // Default belum diperiksa (ENUM requires string)
            ]);

            return redirect()->route('pasien.dashboard')->with('success', 'Pendaftaran berhasil! Nomor antrian Anda adalah ' . $noAntrianBaru);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * AJAX: Mendapatkan jadwal berdasarkan Poli yang dipilih
     */
    public function getJadwalByPoli($id_poli)
    {
        $jadwal = JadwalPeriksa::whereHas('dokter', function($q) use ($id_poli) {
            $q->where('id_poli', $id_poli);
        })->with('dokter')->get();

        return response()->json($jadwal);
    }

    /**
     * LIVE UPDATE: Mendapatkan nomor antrian yang sedang dilayani saat ini
     */
    public function getAntrianSekarang()
    {
        // Mengambil nomor antrian tertinggi yang status_periksa-nya sudah '1' (selesai diperiksa)
        $data = JadwalPeriksa::all()->map(function($jadwal) {
            $sekarang = DaftarPoli::where('id_jadwal', $jadwal->id)
                ->where('status_periksa', '1')
                ->max('no_antrian') ?? 0;

            return [
                'id_jadwal' => $jadwal->id,
                'no_antrian_sekarang' => $sekarang
            ];
        });

        return response()->json($data);
    }
}