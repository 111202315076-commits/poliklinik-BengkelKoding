<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Poli;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\DokterExport;
use Maatwebsite\Excel\Facades\Excel;

class DokterController extends Controller
{
    public function export()
    {
        return Excel::download(new DokterExport, 'data_dokter.xlsx');
    }

    public function index()
    {
        $dokters = User::with('poli')
            ->where('role', 'dokter')
            ->latest()
            ->get();

        return view('admin.dokter.index', compact('dokters'));
    }

    public function create()
    {
        $polis = Poli::orderBy('nama_poli')->get();

        return view('admin.dokter.create', compact('polis'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'alamat'   => 'required|string',
            'no_ktp'   => 'required|string|max:16|unique:users,no_ktp',
            'no_hp'    => 'required|string|max:15',
            'id_poli'  => 'required|exists:poli,id',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['role'] = 'dokter';

        User::create($data);

        return redirect()
            ->route('admin.dokter.index')
            ->with('message', 'Data Dokter berhasil ditambahkan')
            ->with('type', 'success');
    }

    public function edit($id)
    {
        $dokter = User::where('role','dokter')->findOrFail($id);
        $polis = Poli::all();

        return view('admin.dokter.edit', compact('dokter','polis'));
    }

    public function update(Request $request, User $dokter)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'alamat'   => 'required|string',
            'no_ktp'   => 'required|string|max:16|unique:users,no_ktp,' . $dokter->id,
            'no_hp'    => 'required|string|max:15',
            'id_poli'  => 'required|exists:poli,id',
            'email'    => 'required|email|unique:users,email,' . $dokter->id,
            'password' => 'nullable|string|min:6',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $dokter->update($data);

        return redirect()
            ->route('admin.dokter.index')
            ->with('message', 'Data Dokter berhasil diubah')
            ->with('type', 'success');
    }

    public function destroy(User $dokter)
    {
        $dokter->delete();

        return redirect()
            ->route('admin.dokter.index')
            ->with('message', 'Data Dokter berhasil dihapus')
            ->with('type', 'success');
    }
}