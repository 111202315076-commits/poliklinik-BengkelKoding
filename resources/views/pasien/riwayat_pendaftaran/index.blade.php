<x-layouts.app title="Riwayat Pendaftaran">
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-800">Riwayat Pendaftaran</h2>
        <p class="text-slate-500">Lihat histori pendaftaran poli dan hasil pemeriksaan Anda.</p>
    </div>

    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">Poli</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">Dokter</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">Tanggal & Jadwal</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">No. Antrian</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400">Status</th>
                        <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-wider text-slate-400 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($riwayats as $riwayat)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-bold text-slate-700 block">
                                {{ $riwayat->jadwalPeriksa?->dokter?->poli?->nama_poli ?? 'Poli Tidak Ditemukan' }}
                            </span>
                            <span class="text-xs text-slate-400">
                                dr. {{ $riwayat->jadwalPeriksa?->dokter?->name ?? 'Dokter Tidak Ditemukan' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold text-xs">
                                    {{ substr($riwayat->jadwalPeriksa->dokter->nama, 0, 1) }}
                                </div>
                                <span class="text-sm font-medium text-slate-600">{{ $riwayat->jadwalPeriksa->dokter->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold text-slate-500 block uppercase">{{ $riwayat->jadwalPeriksa->hari }}</span>
                            <span class="text-sm text-slate-400">{{ $riwayat->jadwalPeriksa->jam_mulai }} - {{ $riwayat->jadwalPeriksa->jam_selesai }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center font-black text-slate-700">
                                {{ $riwayat->no_antrian }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($riwayat->status_periksa == '1')
                                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[10px] font-bold bg-green-100 text-green-600 uppercase">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> Sudah Diperiksa
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full text-[10px] font-bold bg-amber-100 text-amber-600 uppercase">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Menunggu Antrian
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($riwayat->status_periksa == '1')
                                <a href="{{ route('pasien.riwayat_pendaftaran.show', $riwayat->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-50 text-indigo-600 rounded-xl text-xs font-bold hover:bg-indigo-100 transition-all">
                                    <i class="fas fa-file-medical"></i> Detail
                                </a>
                            @else
                                <span class="text-xs text-slate-300 font-medium italic">Belum ada data</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <i class="fas fa-folder-open text-4xl mb-4 opacity-20"></i>
                                <p class="text-sm font-medium">Belum ada riwayat pendaftaran</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.app>
