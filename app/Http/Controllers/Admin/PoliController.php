<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use Illuminate\Http\Request;

class PoliController extends Controller
{
    public function index()
    {
        $polis = Poli::all();
        return view('admin.polis.index', compact('polis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.polis.create'); // ✅ fix folder
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_poli' => 'required',
            'keterangan' => 'nullable|string',
        ]);

        Poli::create($validated);

        return redirect()->route('admin.polis.index')
            ->with('success', 'Poli berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $poli = Poli::findOrFail($id);
        
        return view('admin.polis.edit', compact('poli'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_poli' => 'required',
            'keterangan' => 'nullable',
        ]);

        $poli = Poli::findOrFail($id);
        $poli->update([
            'nama_poli' => $request->nama_poli,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.polis.index')
            ->with('success', 'Poli berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $poli = Poli::findOrFail($id);
        $poli->delete();

        return redirect()->route('admin.polis.index')
            ->with('success', 'Poli berhasil dihapus!');
    }
}