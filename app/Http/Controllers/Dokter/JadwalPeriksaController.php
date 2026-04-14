<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\JadwalPeriksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\JadwalPeriksaExport;
use Maatwebsite\Excel\Facades\Excel;

class JadwalPeriksaController extends Controller
{
    public function export()
    {
        return Excel::download(new JadwalPeriksaExport, 'jadwal_periksa.xlsx');
    }

    public function index()
    {
        // Mengambil jadwal milik dokter yang sedang login
        $jadwal = JadwalPeriksa::where('id_dokter', Auth::id())->get();
        return view('dokter.jadwal_periksa.index', compact('jadwal'));
    }

    public function create()
    {
        return view('dokter.jadwal_periksa.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        JadwalPeriksa::create([
            'id_dokter' => Auth::id(),
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai, // Sudah menggunakan underscore
        ]);

        return redirect()->route('dokter.jadwal_periksa.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        // Pastikan jadwal yang diedit adalah milik dokter yang login (keamanan tambahan)
        $jadwal = JadwalPeriksa::where('id_dokter', Auth::id())->findOrFail($id);
        return view('dokter.jadwal_periksa.edit', compact('jadwal'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hari' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        $jadwal = JadwalPeriksa::where('id_dokter', Auth::id())->findOrFail($id);
        
        $jadwal->update([
            'hari' => $request->hari,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('dokter.jadwal_periksa.index')->with('success', 'Jadwal berhasil diubah!');
    }

    public function destroy($id)
    {
        $jadwal = JadwalPeriksa::where('id_dokter', Auth::id())->findOrFail($id);
        $jadwal->delete();
        
        return redirect()->route('dokter.jadwal_periksa.index')->with('success', 'Jadwal berhasil dihapus!');
    }
}