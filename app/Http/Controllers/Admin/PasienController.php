<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Exports\PasienExport;
use Maatwebsite\Excel\Facades\Excel;

class PasienController extends Controller
{
    public function export()
    {
        return Excel::download(new PasienExport, 'data_pasien.xlsx');
    }

    public function index()
    {
        $pasiens = User::where('role', 'pasien')->get();
        return view('admin.pasien.index', compact('pasiens'));
    }

    public function create()
    {
        return view('admin.pasien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'alamat'   => 'required|string',
            'no_ktp'   => 'required|string|max:16|unique:users,no_ktp',
            'no_hp'    => 'required|string|max:15',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'name'     => $request->name,
            'alamat'   => $request->alamat,
            'no_ktp'   => $request->no_ktp,
            'no_hp'    => $request->no_hp,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'pasien',
        ]);

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data Pasien berhasil ditambahkan');
    }

    public function edit($id)
    {
        $pasien = User::where('role', 'pasien')->findOrFail($id);
        return view('admin.pasien.edit', compact('pasien'));
    }

    public function update(Request $request, $id)
    {
        $pasien = User::where('role', 'pasien')->findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'alamat'   => 'required|string',
            'no_ktp'   => 'required|string|max:16|unique:users,no_ktp,' . $pasien->id,
            'no_hp'    => 'required|string|max:15',
            'email'    => 'required|email|unique:users,email,' . $pasien->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $data = [
            'name'   => $request->name,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp'  => $request->no_hp,
            'email'  => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pasien->update($data);

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data Pasien berhasil diupdate');
    }

    public function destroy($id)
    {
        $pasien = User::where('role', 'pasien')->findOrFail($id);
        $pasien->delete();

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data Pasien berhasil dihapus');
    }
}
