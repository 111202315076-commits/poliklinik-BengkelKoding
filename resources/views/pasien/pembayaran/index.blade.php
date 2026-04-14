<x-layouts.app title="Pembayaran">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Menu Pembayaran</h2>
            <p class="text-slate-500 text-sm">Lihat tagihan dan upload bukti pembayaran Anda.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3">
        <i class="fas fa-check-circle text-xl"></i>
        <span class="font-bold text-sm">{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($tagihans as $tagihan)
        <div class="bg-white rounded-[32px] border border-slate-100 shadow-sm overflow-hidden flex flex-col group hover:shadow-xl hover:shadow-indigo-900/5 transition-all duration-300">
            <div class="p-8 flex-1">
                <div class="flex items-center justify-between mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600 group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-file-invoice-dollar text-xl"></i>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-slate-300">#{{ str_pad($tagihan->id, 4, '0', STR_PAD_LEFT) }}</span>
                </div>

                <div class="mb-6">
                    <h3 class="font-black text-slate-800 text-lg leading-tight mb-1">{{ $tagihan->jadwalPeriksa->dokter->poli->nama_poli }}</h3>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest">{{ $tagihan->jadwalPeriksa->dokter->nama }}</p>
                </div>

                <div class="space-y-3 mb-8">
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-xs font-bold text-slate-400">TANGGAL PERIKSA</span>
                        <span class="text-xs font-bold text-slate-700 uppercase">{{ \Carbon\Carbon::parse($tagihan->periksa->tgl_periksa)->translatedFormat('d F Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-b border-slate-50">
                        <span class="text-xs font-bold text-slate-400">TOTAL TAGIHAN</span>
                        <span class="text-lg font-black text-indigo-900 uppercase">Rp {{ number_format($tagihan->periksa->biaya_periksa, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2">
                        <span class="text-xs font-bold text-slate-400 uppercase">Status</span>
                        @if($tagihan->periksa->status_bayar == 'menunggu_verifikasi')
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[10px] font-black bg-amber-100 text-amber-600 uppercase">
                                MENUNGGU VERIFIKASI
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[10px] font-black bg-red-100 text-red-600 uppercase">
                                BELUM BAYAR
                            </span>
                        @endif
                    </div>
                </div>

                @if($tagihan->periksa->status_bayar == 'belum_bayar')
                <form action="{{ route('pasien.pembayaran.upload', $tagihan->periksa->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        <div class="relative">
                            <input type="file" name="bukti_bayar" id="bukti_{{ $tagihan->id }}" class="hidden" onchange="document.getElementById('file_label_{{ $tagihan->id }}').innerHTML = this.files[0].name" required>
                            <label for="bukti_{{ $tagihan->id }}" id="file_label_{{ $tagihan->id }}" class="w-full flex items-center justify-center gap-3 px-4 py-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl text-slate-400 text-xs font-bold cursor-pointer hover:bg-slate-100 hover:border-indigo-300 transition-all">
                                <i class="fas fa-cloud-arrow-up text-lg"></i>
                                PILIH BUKTI BAYAR
                            </label>
                        </div>
                        <button type="submit" class="w-full bg-indigo-900 text-white py-4 rounded-2xl font-bold text-xs shadow-lg shadow-indigo-100 hover:bg-indigo-800 transition-all">
                            UPLOAD & KONFIRMASI
                        </button>
                    </div>
                </form>
                @elseif($tagihan->periksa->status_bayar == 'menunggu_verifikasi')
                <div class="text-center p-4 bg-slate-50 rounded-2xl border border-slate-100 italic text-xs text-slate-400 font-medium">
                    "Bukti pembayaran Anda sedang diverifikasi oleh admin. Harap tunggu sebentar."
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full flex flex-col items-center justify-center py-20 text-slate-300">
            <div class="w-24 h-24 rounded-full bg-slate-50 flex items-center justify-center mb-6 border border-slate-100">
                <i class="fas fa-wallet text-4xl opacity-20"></i>
            </div>
            <p class="text-sm font-bold uppercase tracking-widest">Tidak ada tagihan aktif</p>
            <p class="text-xs font-medium mt-1">Tagihan Anda akan muncul di sini setelah diperiksa dokter.</p>
        </div>
        @endforelse
    </div>
</x-layouts.app>
