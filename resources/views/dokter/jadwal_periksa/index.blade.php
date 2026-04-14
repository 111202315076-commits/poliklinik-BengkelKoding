<x-layouts.app title="Jadwal Periksa">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Jadwal Periksa</h2>
            <p class="text-slate-400 text-sm mt-1">Kelola waktu praktik Anda di sini.</p>
        </div>
        
        <div class="flex gap-2">
            <a href="{{ route('dokter.jadwal_periksa.export') }}" class="bg-green-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-green-100 hover:bg-green-700 transition-all flex items-center gap-2">
                <i class="fas fa-file-excel"></i>
                Export Excel
            </a>

            <a href="{{ route('dokter.jadwal_periksa.create') }}" class="bg-indigo-900 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-100 hover:bg-indigo-800 transition-all flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Tambah Jadwal
            </a>
        </div>
    </div>

    <div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100 text-slate-400 text-[11px] uppercase tracking-widest">
                    <th class="px-8 py-5 font-bold">No</th>
                    <th class="px-8 py-5 font-bold">Hari</th>
                    <th class="px-8 py-5 font-bold">Jam Mulai</th>
                    <th class="px-8 py-5 font-bold">Jam Selesai</th>
                    <th class="px-8 py-5 font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($jadwal as $index => $item)
                <tr class="hover:bg-slate-50/30 transition-all">
                    <td class="px-8 py-5 text-slate-400 font-medium">{{ $index + 1 }}</td>
                    <td class="px-8 py-5 font-bold text-slate-700">{{ $item->hari }}</td>
                    <td class="px-8 py-5 text-slate-600 font-medium">
                        {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }}
                    </td>
                    <td class="px-8 py-5 text-slate-600 font-medium">
                        {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}
                    </td>
                    
                    <td class="px-8 py-5">
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('dokter.jadwal_periksa.edit', $item->id) }}" class="bg-amber-100 text-amber-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-amber-200 transition-all">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('dokter.jadwal_periksa.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="bg-red-100 text-red-600 px-4 py-2 rounded-xl text-xs font-bold hover:bg-red-200 transition-all">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-8 py-10 text-center text-slate-400 italic">Data belum tersedia.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layouts.app>