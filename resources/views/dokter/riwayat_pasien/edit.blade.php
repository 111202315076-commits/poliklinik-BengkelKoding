<x-layouts.app title="Edit Riwayat Pemeriksaan">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('dokter.riwayat_pasien.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 shadow-sm transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Edit Data Pemeriksaan</h2>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
        <form action="{{ route('dokter.riwayat_pasien.update', $periksa->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Catatan / Diagnosa</label>
                <textarea name="catatan" rows="4" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">{{ $periksa->catatan }}</textarea>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-700 mb-2">Edit Obat</label>
                <select name="obat[]" multiple class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl outline-none">
                    @foreach($data_obat as $obat)
                        <option value="{{ $obat->id }}" {{ in_array($obat->id, $periksa->detailPeriksas->pluck('id_obat')->toArray()) ? 'selected' : '' }}>
                            {{ $obat->nama_obat }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-amber-500 text-white px-8 py-4 rounded-2xl font-bold hover:bg-amber-600">Update Riwayat</button>
        </form>
    </div>
</x-layouts.app>