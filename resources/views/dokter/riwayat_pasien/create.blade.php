<x-layouts.app title="Tambah Riwayat Pemeriksaan">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('dokter.periksa_pasien.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 shadow-sm transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Periksa Pasien</h2>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
        <form action="{{ route('dokter.riwayat_pasien.store') }}" method="POST">
            @csrf
            <input type="hidden" name="id_daftar_poli" value="{{ $pendaftaran->id }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nama Pasien</label>
                    <input type="text" value="{{ $pendaftaran->pasien->nama }}" disabled class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-500">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Periksa</label>
                    <input type="datetime-local" name="tgl_periksa" value="{{ now()->format('Y-m-d\TH:i') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Catatan / Diagnosa</label>
                <textarea name="catatan" rows="4" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" placeholder="Input hasil diagnosa..."></textarea>
            </div>

            <div class="mb-8">
                <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Obat</label>
                <select name="obat[]" multiple class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">
                    @foreach($data_obat as $obat)
                        <option value="{{ $obat->id }}">{{ $obat->nama_obat }} - Rp {{ number_format($obat->harga_obat, 0, ',', '.') }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="bg-indigo-900 text-white px-8 py-4 rounded-2xl font-bold hover:bg-indigo-800">Simpan Pemeriksaan</button>
            </div>
        </form>
    </div>
</x-layouts.app>