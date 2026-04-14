<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;
use App\Exports\ObatExport;
use Maatwebsite\Excel\Facades\Excel;

class ObatController extends Controller
{
    public function export()
    {
        return Excel::download(new ObatExport, 'data_obat.xlsx');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obats = Obat::latest()->get();
        return view('admin.obat.index', compact('obats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.obat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan'   => 'required|string|max:255',
            'harga_obat' => 'required|integer|min:0',
            'stok'       => 'required|integer|min:0',
        ]);

        Obat::create($validated);

        return redirect()
            ->route('admin.obat.index')
            ->with('message', 'Data Obat berhasil ditambahkan')
            ->with('type', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $obat = Obat::findOrFail($id);
        return view('admin.obat.show', compact('obat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $obat = Obat::findOrFail($id);
        return view('admin.obat.edit', compact('obat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan'   => 'required|string|max:255',
            'harga_obat' => 'required|integer|min:0',
            'stok'       => 'required|integer|min:0',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update($validated);

        return redirect()
            ->route('admin.obat.index')
            ->with('message', 'Data Obat berhasil diupdate')
            ->with('type', 'success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()
            ->route('admin.obat.index')
            ->with('message', 'Data Obat berhasil dihapus')
            ->with('type', 'success');
    }
}