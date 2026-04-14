<x-layouts.app title="Proses Periksa Pasien">
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        /* Custom UI agar menyatu dengan tema modern Anda */
        .ts-control { 
            border: 1px solid #e2e8f0 !important; 
            border-radius: 0.75rem !important; 
            padding: 0.75rem !important; 
            background-color: #f8fafc !important;
            box-shadow: none !important;
        }
        .ts-wrapper.multi .ts-control > div {
            background-color: #4f46e5 !important;
            color: white !important;
            border-radius: 0.5rem !important;
            padding: 2px 10px !important;
            margin: 2px !important;
        }
        .ts-dropdown { border-radius: 0.75rem !important; margin-top: 5px !important; box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1) !important; }
        .ts-dropdown .active { background-color: #f1f5f9 !important; color: #1e293b !important; }
    </style>

    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('dokter.periksa_pasien.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 shadow-sm transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Pemeriksaan Pasien</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-4 border-b pb-4 flex items-center gap-2">
                    <i class="fas fa-user-circle text-indigo-500"></i> Informasi Pasien
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Nama Pasien</p>
                        <p class="text-sm font-bold text-slate-700">{{ $pendaftaran->pasien->nama }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Keluhan</p>
                        <p class="text-sm text-slate-600 bg-slate-50 p-3 rounded-lg mt-1 italic leading-relaxed">
                            "{{ $pendaftaran->keluhan }}"
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                <form action="{{ route('dokter.periksa_pasien.update', $pendaftaran->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Tanggal Periksa</label>
                            <input type="datetime-local" name="tgl_periksa" value="{{ now()->format('Y-m-d\TH:i') }}" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Catatan / Diagnosa</label>
                            <textarea name="catatan" rows="4" required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none transition-all" placeholder="Tuliskan hasil diagnosa medis..."></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Obat</label>
                            <select name="obat[]" id="obat" multiple placeholder="Ketik nama obat..." class="w-full px-4 py-3">
                                @foreach($data_obat as $obat)
                                    <option value="{{ $obat->id }}" {{ $obat->stok <= 0 ? 'disabled' : '' }}>
                                        {{ $obat->nama_obat }} - Rp {{ number_format($obat->harga_obat, 0, ',', '.') }} 
                                        (Stok: {{ $obat->stok }}) 
                                        @if($obat->stok <= 0) [HABIS] @elseif($obat->stok <= 5) [MENIPIS] @endif
                                    </option>
                                @endforeach
                            </select>
                            
                            <p class="mt-2 text-[10px] text-indigo-500 font-bold italic">*Pilih satu atau lebih obat. Gunakan fitur cari untuk mempercepat.</p>
                            
                            @if(session('error'))
                                <p class="mt-2 text-xs text-red-500 font-bold italic">{{ session('error') }}</p>
                            @endif
                        </div>

                        <div class="pt-4 border-t border-slate-50 flex gap-3">
                            <button type="submit" class="flex-1 bg-indigo-900 text-white py-4 rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-800 transition-all">
                                Simpan Hasil Pemeriksaan
                            </button>
                            <a href="{{ route('dokter.periksa_pasien.index') }}" class="px-8 py-4 text-slate-500 font-bold hover:bg-slate-50 rounded-2xl transition-all">
                                Batal
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/tom-select.complete.min.js"></script>
    <script>
        // Inisialisasi TomSelect setelah semua elemen siap
        document.addEventListener("DOMContentLoaded", function() {
            var settings = {
                plugins: ['remove_button'],
                maxItems: 15,
                persist: false,
                create: false,
                allowEmptyOption: true,
                onItemAdd: function() {
                    this.setTextboxValue('');
                    this.refreshOptions();
                }
            };
            new TomSelect("#obat", settings);
        });
    </script>
</x-layouts.app>