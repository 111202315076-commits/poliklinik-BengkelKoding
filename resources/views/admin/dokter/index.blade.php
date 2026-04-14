<x-layouts.app title="Data Dokter">

{{-- ================= HEADER ================= --}}
<div class="flex items-center justify-between mb-6">
    <h2 class="text-2xl font-bold text-slate-800">
        Data Dokter
    </h2>

    <div class="flex gap-2">
        <a href="{{ route('admin.dokter.export') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5
                   bg-green-600 hover:bg-green-700
                   text-white rounded-xl text-sm font-semibold transition">
            <i class="fas fa-file-excel text-sm"></i>
            Export Excel
        </a>

        <a href="{{ route('admin.dokter.create') }}"
            class="inline-flex items-center gap-2 px-5 py-2.5
                   bg-[#2d4499] hover:bg-[#1e2d6b]
                   text-white rounded-xl text-sm font-semibold transition">
            <i class="fas fa-plus text-sm"></i>
            Tambah Dokter
        </a>
    </div>
</div>

{{-- ================= ALERT ================= --}}
@if(session('success'))
    <div class="alert alert-success mb-4 rounded-xl shadow-sm">
        <i class="fas fa-circle-check"></i>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-error mb-4 rounded-xl shadow-sm">
        <i class="fas fa-circle-xmark"></i>
        <span>{{ session('error') }}</span>
    </div>
@endif

{{-- ================= TABLE CARD ================= --}}
<div class="card bg-base-100 shadow-md rounded-2xl border">
    <div class="card-body p-0">

        <div class="overflow-x-auto">
            <table class="table w-full table-zebra">

                {{-- TABLE HEAD --}}
                <thead class="bg-slate-100 text-slate-600 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Nama Dokter</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">No. KTP</th>
                        <th class="px-6 py-4">No. HP</th>
                        <th class="px-6 py-4">Alamat</th>
                        <th class="px-6 py-4">Poli</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                {{-- TABLE BODY --}}
                <tbody class="text-sm text-slate-700">

                    @forelse($dokters as $dokter)
                        <tr class="hover:bg-slate-50 transition">

                            <td class="px-6 py-4 font-semibold text-slate-800">
                                {{ $dokter->name }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $dokter->email }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $dokter->no_ktp ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $dokter->no_hp ?? '-' }}
                            </td>

                            <td class="px-6 py-4">
                                {{ $dokter->alamat ?? '-' }}
                            </td>

                            {{-- POLI AUTO COLOR --}}
                            <td class="px-6 py-4 text-center">
                               @php
                                    $colors = [
                                        'bg-blue-100 text-blue-700',
                                        'bg-green-100 text-green-700',
                                        'bg-yellow-100 text-yellow-700',
                                        'bg-red-100 text-red-700',
                                        'bg-purple-100 text-purple-700',
                                        'bg-pink-100 text-pink-700',
                                        'bg-indigo-100 text-indigo-700',
                                        'bg-teal-100 text-teal-700',
                                        'bg-orange-100 text-orange-700',
                                        'bg-cyan-100 text-cyan-700',
                                    ];

                                    $warna = 'bg-gray-100 text-gray-700';

                                    if ($dokter->poli) {
                                        $hash = abs(crc32($dokter->poli->nama_poli));
                                        $index = $hash % count($colors);
                                        $warna = $colors[$index];
                                    }

                                @endphp


                                <span class="inline-block text-center px-3 py-1 rounded-full text-xs font-semibold {{ $warna }}">
                                    {{ $dokter->poli->nama_poli ?? 'Belum Dipilih' }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">

                                    {{-- EDIT --}}
                                    <a href="{{ route('admin.dokter.edit', $dokter->id) }}"
                                        class="btn btn-sm bg-amber-500 hover:bg-amber-600
                                               text-white border-none rounded-lg px-4">
                                        <i class="fas fa-pen-to-square"></i>
                                        Edit
                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('admin.dokter.destroy', $dokter->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus dokter ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="btn btn-sm bg-red-500 hover:bg-red-600
                                                   text-white border-none rounded-lg px-4">
                                            <i class="fas fa-trash"></i>
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-16 text-slate-400">
                                <i class="fas fa-inbox text-3xl mb-3 block"></i>
                                Belum ada data dokter
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>
</div>

</x-layouts.app>
