<x-layouts.app title="Dashboard Pasien">
    <div class="space-y-8">
        {{-- Banner Antrian Aktif --}}
        @if($antrianAktif)
        <div class="relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700 rounded-[20px] p-8 text-white shadow-xl">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="space-y-4">
                    <h2 class="text-sm font-bold uppercase tracking-widest opacity-80">Antrian Aktif Anda</h2>
                    <div>
                        <p class="text-xs opacity-70">Poliklinik</p>
                        <h3 class="text-2xl font-bold">
                            {{ $antrianAktif?->jadwalPeriksa?->dokter?->poli?->nama_poli ?? 'Poli Tidak Ditemukan' }}
                        </h3>
                    </div>
                <div>
                        <p class="text-xs opacity-70">Dokter</p>
                        <p class="text-xl font-semibold">{{ $antrianAktif->jadwalPeriksa->dokter->nama }}</p>
                    </div>
                    <div>
                        <p class="text-xs opacity-70">Jadwal Periksa</p>
                        <p class="text-lg">{{ $antrianAktif->jadwalPeriksa->hari }} ({{ $antrianAktif->jadwalPeriksa->jam_mulai }} - {{ $antrianAktif->jadwalPeriksa->jam_selesai }})</p>
                    </div>
                </div>

                <div class="flex gap-4">
                    {{-- Nomor Anda --}}
                    <div class="bg-white/20 backdrop-blur-md rounded-2xl p-6 text-center min-w-[140px] border border-white/30">
                        <p class="text-xs font-medium mb-2">Nomor Anda</p>
                        <span class="text-6xl font-black">{{ $antrianAktif->no_antrian }}</span>
                    </div>
                    {{-- Sedang Dilayani (Live Update) --}}
                    <div class="bg-white rounded-2xl p-6 text-center min-w-[140px] text-blue-700 shadow-lg">
                        <p class="text-xs font-bold text-slate-500 mb-2 uppercase">Sedang Dilayani</p>
                        <span id="live-antrian-{{ $antrianAktif->id_jadwal }}" class="text-6xl font-black">
                            {{ $antrianAktif->antrian_sekarang }}
                        </span>
                        <div class="flex items-center justify-center gap-2 mt-2">
                            <span class="relative flex h-2 w-2">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                            </span>
                            <p class="text-[10px] font-bold text-blue-500 uppercase">Live Update</p>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Background Decor --}}
            <div class="absolute top-[-20%] right-[-5%] w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
        </div>
        @endif

        {{-- Tabel Daftar Jadwal --}}
        <div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 border-b border-slate-50 flex justify-between items-center">
                <h3 class="text-xl font-bold text-slate-800">Daftar Jadwal Poliklinik</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50">
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">No</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Poli</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Dokter</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Hari</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase">Jam Periksa</th>
                            <th class="px-6 py-4 text-xs font-bold text-slate-400 uppercase text-center">Sedang Dilayani</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($daftarJadwal as $index => $jadwal)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 text-slate-600 font-medium">{{ $index + 1 }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-full text-xs font-bold">
                                    {{-- Mengambil nama poli melalui relasi dokter --}}
                                    {{ $jadwal->dokter?->poli?->nama_poli ?? 'Poli Belum Diset' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-slate-700 font-semibold">
                                {{-- Menggunakan 'name' sesuai kolom di tabel users Anda --}}
                                {{ $jadwal->dokter?->name ?? 'Dokter Tidak Ditemukan' }}
                            </td>
                            <td class="px-6 py-4 text-slate-600">{{ $jadwal->hari }}</td>
                            <td class="px-6 py-4 text-slate-600 font-mono text-sm">
                                {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span id="table-antrian-{{ $jadwal->id }}" class="text-xl font-bold text-blue-600">
                                    {{ $jadwal->antrian_sekarang ?? '0' }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 italic">
                                Belum ada jadwal dokter yang tersedia saat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>


    </div>

    {{-- Script untuk Live Update Nomor Antrian --}}
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Listen to AntrianUpdated event
            window.Echo.channel('antrian')
                .listen('.AntrianUpdated', (e) => {
                    console.log('Antrian updated:', e);
                    
                    // Update di banner (jika ada)
                    const bannerEl = document.getElementById(`live-antrian-${e.id_jadwal}`);
                    if(bannerEl) {
                        bannerEl.innerText = e.no_antrian_sekarang;
                        // Tambahkan animasi singkat saat berubah
                        bannerEl.classList.add('scale-110', 'text-blue-500');
                        setTimeout(() => bannerEl.classList.remove('scale-110', 'text-blue-500'), 500);
                    }

                    // Update di tabel
                    const tableEl = document.getElementById(`table-antrian-${e.id_jadwal}`);
                    if(tableEl) {
                        tableEl.innerText = e.no_antrian_sekarang;
                        tableEl.classList.add('text-indigo-600', 'font-black');
                        setTimeout(() => tableEl.classList.remove('text-indigo-600', 'font-black'), 1000);
                    }
                });
        });
    </script>
    @endpush
</x-layouts.app>