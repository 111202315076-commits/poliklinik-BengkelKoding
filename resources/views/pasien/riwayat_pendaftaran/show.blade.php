<x-layouts.app title="Detail Pemeriksaan">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('pasien.riwayat_pendaftaran.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-slate-200 text-slate-400 hover:text-indigo-600 shadow-sm transition-all">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h2 class="text-2xl font-bold text-slate-800">Detail Pemeriksaan</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                <h3 class="font-bold text-slate-800 mb-4 border-b pb-4 flex items-center gap-2">
                    <i class="fas fa-user-circle text-indigo-500"></i> Informasi Pendaftaran
                </h3>
                <div class="space-y-4">
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Poli</p>
                        <p class="text-sm font-bold text-slate-700">{{ $riwayat->jadwalPeriksa->dokter->poli->nama_poli }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Dokter</p>
                        <p class="text-sm font-bold text-slate-700">{{ $riwayat->jadwalPeriksa->dokter->nama }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Nomor Antrian</p>
                        <p class="text-sm font-bold text-slate-700">{{ $riwayat->no_antrian }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">Keluhan</p>
                        <p class="text-sm text-slate-600 italic">"{{ $riwayat->keluhan }}"</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm">
                <div class="flex items-center justify-between mb-8 pb-4 border-b">
                    <h3 class="text-xl font-bold text-slate-800">Hasil Pemeriksaan</h3>
                    <span class="text-sm font-medium text-slate-400">
                        {{ \Carbon\Carbon::parse($riwayat->periksa->tgl_periksa)->translatedFormat('d F Y H:i') }}
                    </span>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Catatan Dokter</label>
                        <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 text-slate-600 leading-relaxed italic">
                            "{{ $riwayat->periksa->catatan }}"
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-4">Resep Obat</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($riwayat->periksa->detailPeriksas as $detail)
                            <div class="flex items-center justify-between p-4 bg-indigo-50/30 rounded-2xl border border-indigo-100">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center text-indigo-500 border border-indigo-100 shadow-sm">
                                        <i class="fas fa-pills text-[10px]"></i>
                                    </div>
                                    <span class="text-sm font-bold text-slate-700">{{ $detail->obat->nama_obat }}</span>
                                </div>
                                <span class="text-xs font-bold text-indigo-600">Rp {{ number_format($detail->obat->harga_obat, 0, ',', '.') }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-6 mt-6 border-t border-slate-50 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Biaya</p>
                            <p class="text-2xl font-black text-indigo-900">Rp {{ number_format($riwayat->periksa->biaya_periksa, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status Pembayaran</p>
                            @if($riwayat->periksa->status_bayar == 'lunas')
                                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-bold bg-green-100 text-green-600 uppercase">
                                    LUNAS
                                </span>
                            @elseif($riwayat->periksa->status_bayar == 'menunggu_verifikasi')
                                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-bold bg-amber-100 text-amber-600 uppercase">
                                    MENUNGGU VERIFIKASI
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-xs font-bold bg-red-100 text-red-600 uppercase">
                                    BELUM BAYAR
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
