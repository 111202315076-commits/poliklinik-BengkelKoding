<x-layouts.app title="Periksa Pasien">
    <h2 class="text-2xl font-bold text-slate-800 mb-6">Daftar Pasien Menunggu</h2>
    
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-400 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4 font-semibold">No Antrian</th>
                    <th class="px-6 py-4 font-semibold">Nama Pasien</th>
                    <th class="px-6 py-4 font-semibold">Keluhan</th>
                    <th class="px-6 py-4 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-slate-600">
                @forelse($daftar_pasien as $pasien)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="bg-slate-100 text-slate-700 px-3 py-1 rounded-full text-sm font-medium">
                                {{ $pasien->no_antrian }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-slate-900">
                            {{ $pasien->pasien->name ?? $pasien->pasien->nama }}
                        </td> 
                        <td class="px-6 py-4 text-sm">
                            {{ $pasien->keluhan }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('dokter.periksa_pasien.edit', $pasien->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Periksa
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-slate-400 italic">
                            <div class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-200 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span>Belum ada pasien yang mendaftar di jadwal Anda.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>