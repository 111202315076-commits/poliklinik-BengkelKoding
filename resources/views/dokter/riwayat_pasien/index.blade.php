<x-layouts.app title="Riwayat Pasien">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Riwayat Pemeriksaan Pasien</h2>
            <p class="text-slate-400 text-sm">Daftar seluruh pasien yang telah Anda periksa.</p>
        </div>

        <a href="{{ route('dokter.riwayat_pasien.export') }}" class="bg-green-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-green-100 hover:bg-green-700 transition-all flex items-center gap-2">
            <i class="fas fa-file-excel"></i>
            Export Excel
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50">
                    <tr class="text-slate-400 text-[11px] uppercase tracking-widest border-b border-slate-100">
                        <th class="px-6 py-4 font-bold text-center w-16">No</th>
                        <th class="px-6 py-4 font-bold">Tanggal Periksa</th>
                        <th class="px-6 py-4 font-bold">Nama Pasien</th>
                        <th class="px-6 py-4 font-bold">Diagnosa / Catatan</th>
                        <th class="px-6 py-4 font-bold">Obat</th>
                        <th class="px-6 py-4 font-bold text-right">Total Biaya</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($riwayat as $index => $item)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-5 text-sm text-center text-slate-400 font-medium">
                            {{ $index + 1 }}
                        </td>
                        <td class="px-6 py-5">
                            <span class="text-xs font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-lg">
                                {{ \Carbon\Carbon::parse($item->tgl_periksa)->format('d M Y, H:i') }}
                            </span>
                        </td>
                        <td class="px-6 py-5 font-bold text-slate-700">
                            {{ $item->daftarPoli->pasien->nama }}
                        </td>
                        <td class="px-6 py-5 text-sm text-slate-600 max-w-xs">
                            {{ $item->catatan ?? '-' }}
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-wrap gap-1">
                                @foreach($item->detailPeriksas as $detail)
                                    <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md border border-slate-200">
                                        {{ $detail->obat->nama_obat }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        <td class="px-6 py-5 text-right font-black text-slate-800">
                            Rp {{ number_format($item->biaya_periksa, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-notes-medical text-4xl text-slate-200 mb-3"></i>
                                <p class="text-slate-400 italic text-sm">Belum ada riwayat pemeriksaan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>