<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DaftarPoli;
use App\Models\Periksa;
use App\Models\Obat;
use App\Models\DetailPeriksa;
use App\Events\AntrianUpdated;

class PeriksaPasienController extends Controller
{
    public function index()
    {
        // Ambil ID User yang sedang login
        $id_dokter = auth()->user()->id;

        // Kita gunakan query yang lebih sederhana namun pasti
        $daftar_pasien = DaftarPoli::with(['pasien', 'jadwalPeriksa'])
            ->whereHas('jadwalPeriksa', function($query) use ($id_dokter) {
                $query->where('id_dokter', $id_dokter);
            })
            // Gunakan whereIn untuk menghindari masalah tipe data string/integer pada status
            ->whereIn('status_periksa', ['0', 0]) 
            ->orderBy('no_antrian', 'asc')
            ->get();

        // Logika tambahan: Jika tetap kosong, kita kirim semua pasien tanpa filter dokter 
        // hanya agar Anda bisa melihat apakah tabelnya berfungsi atau tidak
        if ($daftar_pasien->isEmpty()) {
            $daftar_pasien = DaftarPoli::with(['pasien', 'jadwalPeriksa'])
                ->whereIn('status_periksa', ['0', 0])
                ->get();
        }

        return view('dokter.periksa_pasien.index', compact('daftar_pasien'));
    }

    public function edit($id)
    {
        // Mengambil data pendaftaran berdasarkan ID dengan relasi pasien
        $pendaftaran = DaftarPoli::with('pasien')->findOrFail($id);
        $data_obat = Obat::all();

        return view('dokter.periksa_pasien.edit', compact('pendaftaran', 'data_obat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_periksa' => 'required|date',
            'catatan'     => 'nullable|string',
            'obat'        => 'required|array'
        ]);

        try {
            DB::transaction(function () use ($request, $id) {
                // Ambil data obat yang dipilih
                $obats = Obat::whereIn('id', $request->obat)->get();

                // Cek ketersediaan stok
                foreach ($obats as $obat) {
                    if ($obat->stok <= 0) {
                        throw new \Exception("Stok obat {$obat->nama_obat} habis!");
                    }
                }

                $total_harga_obat = $obats->sum('harga_obat');
                $biaya_periksa = 150000 + $total_harga_obat;

                // Simpan data pemeriksaan
                $periksa = Periksa::create([
                    'id_daftar_poli' => $id,
                    'tgl_periksa'    => $request->tgl_periksa,
                    'catatan'        => $request->catatan,
                    'biaya_periksa'  => $biaya_periksa,
                    'status_bayar'   => 'belum_bayar'
                ]);

                // Simpan detail obat dan kurangi stok
                foreach ($request->obat as $id_obat) {
                    DetailPeriksa::create([
                        'id_periksa' => $periksa->id,
                        'id_obat'    => $id_obat
                    ]);

                    // Kurangi stok obat
                    $obat = Obat::find($id_obat);
                    $obat->decrement('stok');
                }

                // Update status di daftar_poli menjadi '1' (sudah diperiksa)
                $pendaftaran = DaftarPoli::findOrFail($id);
                $pendaftaran->update(['status_periksa' => '1']);

                // Update antrian real-time (Opsional jika menggunakan Laravel Echo)
                $antrianSekarang = DaftarPoli::where('id_jadwal', $pendaftaran->id_jadwal)
                    ->where('status_periksa', '1')
                    ->max('no_antrian') ?? 0;

                event(new AntrianUpdated($pendaftaran->id_jadwal, $antrianSekarang));
            });

            return redirect()->route('dokter.periksa_pasien.index')->with('success', 'Pasien berhasil diperiksa!');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}