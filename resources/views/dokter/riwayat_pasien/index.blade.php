<x-layouts.app title="Riwayat Pasien">

    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold text-slate-800">
            Riwayat Pemeriksaan Pasien
        </h2>

        <a href="{{ route('dokter.riwayat_pasien.export') }}"
            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
            Export Excel
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-left">
            <thead class="bg-slate-50 text-slate-400 text-xs uppercase tracking-wider">
                <tr>
                    <th class="px-6 py-4">No</th>
                    <th class="px-6 py-4">Nama Pasien</th>
                    <th class="px-6 py-4">Tanggal Periksa</th>
                    <th class="px-6 py-4">Biaya</th>
                    <th class="px-6 py-4">Catatan</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse($riwayat as $periksa)
                    <tr>
                        <td class="px-6 py-4">
                            {{ $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-medium">
                            {{ $periksa->daftarPoli->pasien->nama ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($periksa->tgl_periksa)->format('d/m/Y H:i') }}
                        </td>

                        <td class="px-6 py-4">
                            Rp {{ number_format($periksa->biaya_periksa, 0, ',', '.') }}
                        </td>

                        <td class="px-6 py-4">
                            {{ Str::limit($periksa->catatan, 50) }}
                        </td>

                        <td class="px-6 py-4 text-center">
                            <a href="{{ route('dokter.riwayat_pasien.edit', $periksa->id) }}"
                                class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-8 text-slate-400">
                            Belum ada data riwayat pemeriksaan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</x-layouts.app>