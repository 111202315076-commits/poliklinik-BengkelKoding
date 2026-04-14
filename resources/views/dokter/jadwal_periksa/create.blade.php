<x-layouts.app title="Tambah Jadwal Praktik">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('dokter.jadwal_periksa.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 shadow-sm transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Tambah Jadwal Periksa</h2>
    </div>

    <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm max-w-2xl">
        <form action="{{ route('dokter.jadwal_periksa.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Hari</label>
                    <select name="hari" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        <option value="" hidden>-- Pilih Hari Praktik --</option>
                        <option value="Senin">Senin</option>
                        <option value="Selasa">Selasa</option>
                        <option value="Rabu">Rabu</option>
                        <option value="Kamis">Kamis</option>
                        <option value="Jumat">Jumat</option>
                        <option value="Sabtu">Sabtu</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Jam Mulai</label>
                        <input type="time" name="jam_mulai" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Jam Selesai</label>
                        <input type="time" name="jam_selesai" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full bg-indigo-900 text-white py-4 rounded-2xl font-bold hover:bg-indigo-800 shadow-lg shadow-indigo-200 transition-all">
                        Simpan Jadwal Praktik
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-layouts.app>