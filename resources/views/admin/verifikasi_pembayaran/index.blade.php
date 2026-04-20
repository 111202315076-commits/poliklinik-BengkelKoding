<x-layouts.app title="Verifikasi Pembayaran">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Verifikasi Pembayaran</h2>
            <p class="text-slate-500 text-sm">Lihat daftar tagihan pasien dan konfirmasi pembayaran.</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 bg-green-100 border border-green-200 text-green-700 px-6 py-4 rounded-2xl flex items-center gap-3">
        <i class="fas fa-check-circle text-xl"></i>
        <span class="font-bold text-sm">{{ session('success') }}</span>
    </div>
    @endif

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">PASIEN</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">POLI / DOKTER</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">TANGGAL & BIAYA</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">BUKTI BAYAR</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-center">STATUS</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-right">AKSI</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($tagihans as $tagihan)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold text-xs">
                                    {{ substr($tagihan->daftarPoli->pasien->nama, 0, 1) }}
                                </div>
                                <div>
                                    <span class="font-bold text-slate-700 block text-sm">{{ $tagihan->daftarPoli->pasien->nama }}</span>
                                    <span class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">RM: {{ $tagihan->daftarPoli->pasien->no_rm }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-700 block text-sm">{{ $tagihan->daftarPoli->jadwalPeriksa->dokter->poli->nama_poli }}</span>
                            <span class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">{{ $tagihan->daftarPoli->jadwalPeriksa->dokter->nama }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold text-slate-500 block uppercase">{{ \Carbon\Carbon::parse($tagihan->tgl_periksa)->translatedFormat('d F Y') }}</span>
                            <span class="text-lg font-black text-indigo-900 uppercase">Rp {{ number_format($tagihan->biaya_periksa, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($tagihan->bukti_bayar)
                                <a href="{{ asset('storage/' . $tagihan->bukti_bayar) }}" target="_blank" class="inline-flex items-center gap-2 p-2 bg-slate-50 border border-slate-200 rounded-xl text-slate-500 hover:text-indigo-600 hover:bg-indigo-50 transition-all">
                                    <img src="{{ asset('storage/app/public/bukti_bayar' . $tagihan->bukti_bayar) }}" class="w-12 h-12 object-cover rounded-lg">
                                    <span class="text-[10px] font-bold uppercase tracking-widest">LIHAT BUKTI</span>
                                </a>
                            @else
                                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-300">TIDAK ADA BUKTI</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($tagihan->status_bayar == 'lunas')
                                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[10px] font-black bg-green-100 text-green-600 uppercase">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> LUNAS
                                </span>
                            @elseif($tagihan->status_bayar == 'menunggu_verifikasi')
                                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[10px] font-black bg-amber-100 text-amber-600 uppercase">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> MENUNGGU VERIFIKASI
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[10px] font-black bg-red-100 text-red-600 uppercase">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> BELUM BAYAR
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            @if($tagihan->status_bayar == 'menunggu_verifikasi')
                                <form action="{{ route('admin.verifikasi_pembayaran.verifikasi', $tagihan->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" onclick="return confirm('Konfirmasi pembayaran ini?')" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-900 text-white rounded-2xl text-[10px] font-black hover:bg-indigo-800 shadow-lg shadow-indigo-100 transition-all uppercase tracking-widest">
                                        KONFIRMASI LUNAS
                                    </button>
                                </form>
                            @else
                                <span class="text-[10px] font-bold uppercase tracking-widest text-slate-300">SELESAI</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <i class="fas fa-file-invoice-dollar text-4xl mb-4 opacity-20"></i>
                                <p class="text-sm font-medium uppercase tracking-widest">Tidak ada tagihan yang menunggu verifikasi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
