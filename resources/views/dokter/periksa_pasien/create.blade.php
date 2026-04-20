<x-layouts.app title="Proses Periksa Pasien">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('dokter.periksa_pasien.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 shadow-sm transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Pemeriksaan Pasien</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-4 border-b pb-2">Data Pasien</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Nama Pasien</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Keluhan</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                <form action="{{ route('dokter.periksa_pasien.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id_daftar_poli" value="1">
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Periksa</label>
                            <input type="text" value="{{ now()->format('Y-m-d H:i') }}" readonly class="w-full px-4 py-3 bg-slate-100 border border-slate-200 rounded-xl text-slate-500 outline-none">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Catatan / Diagnosa</label>
                            <textarea name="catatan" rows="4" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="Tuliskan hasil diagnosa pasien..."></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Obat</label>
                            <select name="obat[]" multiple class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none">
                                {{-- Looping data obat dari database --}}
                                <option value="1">Paracetamol - Rp 5.000</option>
                                <option value="2">Amoxicillin - Rp 10.000</option>
                            </select>
                            <p class="mt-2 text-[10px] text-slate-400 font-medium">*Tahan Ctrl untuk memilih lebih dari satu obat</p>
                        </div>

                        <button type="submit" class="w-full bg-indigo-900 text-white py-4 rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-800 transition-all">
                            Simpan & Selesai Periksa
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>