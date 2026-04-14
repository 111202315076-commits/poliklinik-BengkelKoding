<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
// Import Model agar tidak merah lagi
use App\Models\DaftarPoli;
use App\Models\Periksa;
use App\Models\Obat;
use App\Models\DetailPeriksa;
use App\Exports\RiwayatPasienExport;
use Maatwebsite\Excel\Facades\Excel;

class RiwayatPasienController extends Controller
{
    public function export()
    {
        return Excel::download(new RiwayatPasienExport, 'riwayat_pasien.xlsx');
    }

    public function index()
    {
        // Menampilkan riwayat pasien khusus untuk dokter yang sedang login
        $riwayat = Periksa::with(['daftarPoli.pasien', 'detailPeriksas.obat'])
            ->whereHas('daftarPoli.jadwalPeriksa', function($query) {
                $query->where('id_dokter', Auth::user()->id);
            })
            ->latest()
            ->get();

        return view('dokter.riwayat_pasien.index', compact('riwayat'));
    }

    public function create($id_pendaftaran)
    {
        $pendaftaran = DaftarPoli::with('pasien')->findOrFail($id_pendaftaran);
        $data_obat = Obat::all();
        return view('dokter.riwayat_pasien.create', compact('pendaftaran', 'data_obat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_daftar_poli' => 'required',
            'tgl_periksa' => 'required',
            'catatan' => 'required',
            'obat' => 'required|array'
        ]);

        DB::transaction(function () use ($request) {
            // Get selected drugs
            $obats = Obat::whereIn('id', $request->obat)->get();
            
            // Check stock for each drug
            foreach ($obats as $obat) {
                if ($obat->stok <= 0) {
                    throw new \Exception("Stok obat {$obat->nama_obat} habis!");
                }
            }

            // Hitung biaya periksa (Jasa 150rb + Harga Obat)
            $total_harga_obat = $obats->sum('harga_obat');
            $biaya_periksa = 150000 + $total_harga_obat;

            // Simpan ke tabel periksa
            $periksa = Periksa::create([
                'id_daftar_poli' => $request->id_daftar_poli,
                'tgl_periksa' => $request->tgl_periksa,
                'catatan' => $request->catatan,
                'biaya_periksa' => $biaya_periksa,
                'status_bayar' => 'belum_bayar'
            ]);

            // Simpan ke detail_periksa dan kurangi stok
            foreach ($request->obat as $id_obat) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $id_obat
                ]);
                
                // Kurangi stok
                $obat = Obat::find($id_obat);
                $obat->decrement('stok');
            }

            // Update status di daftar_poli
            $pendaftaran = DaftarPoli::findOrFail($request->id_daftar_poli);
            $pendaftaran->update(['status_periksa' => '1']);

            // Dispatch event for real-time update
            $antrianSekarang = DaftarPoli::where('id_jadwal', $pendaftaran->id_jadwal)
                ->where('status_periksa', '1')
                ->max('no_antrian') ?? 0;
            
            event(new \App\Events\AntrianUpdated($pendaftaran->id_jadwal, $antrianSekarang));
        });

        return redirect()->route('dokter.riwayat_pasien.index')->with('success', 'Data pemeriksaan berhasil disimpan!');
    }

    public function edit($id)
    {
        $periksa = Periksa::with(['daftarPoli.pasien', 'detailPeriksas'])->findOrFail($id);
        $data_obat = Obat::all();
        return view('dokter.riwayat_pasien.edit', compact('periksa', 'data_obat'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tgl_periksa' => 'required',
            'catatan' => 'required',
            'obat' => 'required|array'
        ]);

        DB::transaction(function () use ($request, $id) {
            $periksa = Periksa::findOrFail($id);

            // Hitung ulang biaya
            $total_harga_obat = Obat::whereIn('id', $request->obat)->sum('harga_obat');
            $biaya_periksa = 150000 + $total_harga_obat;

            // Update tabel periksa
            $periksa->update([
                'tgl_periksa' => $request->tgl_periksa,
                'catatan' => $request->catatan,
                'biaya_periksa' => $biaya_periksa
            ]);

            // Update obat (Hapus yang lama, simpan yang baru)
            DetailPeriksa::where('id_periksa', $id)->delete();
            foreach ($request->obat as $id_obat) {
                DetailPeriksa::create([
                    'id_periksa' => $periksa->id,
                    'id_obat' => $id_obat
                ]);
            }
        });

        return redirect()->route('dokter.riwayat_pasien.index')->with('success', 'Riwayat berhasil diperbarui!');
    }
}