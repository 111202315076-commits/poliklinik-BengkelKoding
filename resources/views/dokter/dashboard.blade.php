<x-layouts.app title="Dokter Dashboard">
    {{-- Header Section --}}
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-800">Selamat Datang, Dokter 👋</h2>
        <p class="text-slate-400 text-sm mt-1">
            {{ now()->translatedFormat('l, d F Y') }} — Berikut ringkasan aktivitas praktik Anda hari ini.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        {{-- Card Total Jadwal --}}
        <div class="bg-white p-6 rounded-[32px] shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
                <a href="{{ route('dokter.jadwal_periksa.index') }}" class="text-blue-600 text-xs font-bold hover:underline">Lihat</a>
            </div>
            <div class="mt-4">
                <h3 class="text-5xl font-black text-slate-800">{{ $total_jadwal }}</h3>
                <p class="text-slate-400 text-sm font-medium mt-1">Total Jadwal</p>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500"></div>
        </div>

        {{-- Card Pasien Menunggu --}}
        <div class="bg-white p-6 rounded-[32px] shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-amber-50 text-amber-500 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-user-clock text-xl"></i>
                </div>
                <a href="{{ route('dokter.periksa_pasien.index') }}" class="text-amber-600 text-xs font-bold hover:underline">Lihat</a>
            </div>
            <div class="mt-4">
                <h3 class="text-5xl font-black text-slate-800">{{ $pasien_menunggu }}</h3>
                <p class="text-slate-400 text-sm font-medium mt-1">Pasien Menunggu</p>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-amber-500"></div>
        </div>

        {{-- Card Total Riwayat --}}
        <div class="bg-white p-6 rounded-[32px] shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="flex justify-between items-start">
                <div class="w-12 h-12 bg-rose-50 text-rose-500 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-file-medical text-xl"></i>
                </div>
                <a href="{{ route('dokter.riwayat_pasien.index') }}" class="text-rose-600 text-xs font-bold hover:underline">Lihat</a>
            </div>
            <div class="mt-4">
                <h3 class="text-5xl font-black text-slate-800">{{ $total_riwayat }}</h3>
                <p class="text-slate-400 text-sm font-medium mt-1">Total Riwayat</p>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-rose-500"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Tabel Jadwal Periksa --}}
        <div class="lg:col-span-2 bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-6 flex justify-between items-center border-b border-slate-50">
                <h4 class="font-bold text-slate-800">Jadwal Periksa</h4>
                <a href="{{ route('dokter.jadwal_periksa.index') }}" class="text-indigo-600 text-xs font-bold">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50">
                        <tr class="text-slate-400 text-[10px] uppercase tracking-widest border-b border-slate-100">
                            <th class="px-8 py-4 font-bold">Hari</th>
                            <th class="px-8 py-4 font-bold text-center">Jam Mulai</th>
                            <th class="px-8 py-4 font-bold text-center">Jam Selesai</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($jadwal_periksa as $item)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            <td class="px-8 py-5 font-bold text-slate-700">{{ $item->hari }}</td>
                            <td class="px-8 py-5 text-center text-slate-500">{{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }}</td>
                            <td class="px-8 py-5 text-center text-slate-500">{{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-8 py-10 text-center text-slate-400 italic">Data belum tersedia.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Right Column: Akses Cepat --}}
        <div class="space-y-6">
            <h4 class="font-bold text-slate-800 px-2 uppercase text-xs tracking-widest">Akses Cepat</h4>
            
            <div class="space-y-4">
                {{-- Menu Tambah Jadwal --}}
                <a href="{{ route('dokter.jadwal_periksa.create') }}" class="group block p-4 bg-white hover:bg-blue-600 rounded-2xl border border-slate-100 transition-all duration-300 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="bg-blue-50 text-blue-600 p-3 rounded-xl group-hover:bg-blue-500 group-hover:text-white transition-colors shadow-sm">
                            <i class="fas fa-plus text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800 group-hover:text-white transition-colors">Tambah Jadwal</p>
                            <p class="text-[11px] text-slate-400 group-hover:text-blue-100 transition-colors">Atur jam praktik baru</p>
                        </div>
                    </div>
                </a>

                {{-- Menu Periksa Pasien --}}
                <a href="{{ route('dokter.periksa_pasien.index') }}" class="group block p-4 bg-white hover:bg-amber-500 rounded-2xl border border-slate-100 transition-all duration-300 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="bg-amber-50 text-amber-600 p-3 rounded-xl group-hover:bg-amber-400 group-hover:text-white transition-colors shadow-sm">
                            <i class="fas fa-stethoscope text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800 group-hover:text-white transition-colors">Periksa Pasien</p>
                            <p class="text-[11px] text-slate-400 group-hover:text-amber-100 transition-colors">Lihat daftar antrian hari ini</p>
                        </div>
                    </div>
                </a>

                {{-- Menu Riwayat Pasien --}}
                <a href="{{ route('dokter.riwayat_pasien.index') }}" class="group block p-4 bg-white hover:bg-rose-500 rounded-2xl border border-slate-100 transition-all duration-300 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="bg-rose-50 text-rose-500 p-3 rounded-xl group-hover:bg-rose-400 group-hover:text-white transition-colors shadow-sm">
                            <i class="fas fa-history text-sm"></i>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-slate-800 group-hover:text-white transition-colors">Riwayat Pasien</p>
                            <p class="text-[11px] text-slate-400 group-hover:text-rose-100 transition-colors">Cek data pemeriksaan medis</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>