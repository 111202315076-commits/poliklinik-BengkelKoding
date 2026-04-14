<x-layouts.app>

    <div class="p-6">

        <!-- HEADER -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-800">
                Selamat Datang, Admin 👋
            </h1>
            <p class="text-gray-500 text-sm">
                Berikut ringkasan data sistem poliklinik.
            </p>
        </div>

        <!-- CARD STATISTIK -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">

            <!-- Poli -->
            <div class="bg-white rounded-xl shadow p-5 border-b-4 border-blue-500">
                <div class="flex justify-between items-center">
                    <div class="text-gray-500 text-sm">Total Poli</div>
                    <a href="{{ route('admin.polis.index') }}" class="text-blue-500 text-sm">Lihat</a>
                </div>
                <div class="text-3xl font-bold mt-2">{{ $totalPoli }}</div>
            </div>

            <!-- Dokter -->
            <div class="bg-white rounded-xl shadow p-5 border-b-4 border-green-500">
                <div class="flex justify-between">
                    <div class="text-gray-500 text-sm">Total Dokter</div>
                    <a href="{{ route('admin.dokter.index') }}" class="text-green-500 text-sm">Lihat</a>
                </div>
                <div class="text-3xl font-bold mt-2">{{ $totalDokter }}</div>
            </div>

            <!-- Pasien -->
            <div class="bg-white rounded-xl shadow p-5 border-b-4 border-yellow-500">
                <div class="flex justify-between">
                    <div class="text-gray-500 text-sm">Total Pasien</div>
                    <a href="{{ route('admin.pasien.index') }}" class="text-yellow-500 text-sm">Lihat</a>
                </div>
                <div class="text-3xl font-bold mt-2">{{ $totalPasien }}</div>
            </div>

            <!-- Obat -->
            <div class="bg-white rounded-xl shadow p-5 border-b-4 border-pink-500">
                <div class="flex justify-between">
                    <div class="text-gray-500 text-sm">Total Obat</div>
                    <a href="{{ route('admin.obat.index') }}" class="text-pink-500 text-sm">Lihat</a>
                </div>
                <div class="text-3xl font-bold mt-2">{{ $totalObat }}</div>
            </div>

        </div>

        <!-- CONTENT -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- TABEL POLI -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow p-6">

                <div class="flex justify-between items-center mb-4">
                    <h2 class="font-semibold text-lg">Daftar Poli</h2>
                    <a href="{{ route('admin.polis.index') }}" class="text-blue-500 text-sm">
                        Lihat Semua →
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-gray-400 border-b text-left">
                                <th class="pb-3">NAMA POLI</th>
                                <th class="pb-3">KETERANGAN</th>
                                <th class="pb-3 text-center">DOKTER</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-700">

                            @forelse ($dataPoli as $poli)
                            <tr class="border-b hover:bg-gray-50 transition">

                                <!-- Nama Poli -->
                                <td class="py-4 font-medium">
                                    {{ $poli->nama_poli }}
                                </td>

                                <!-- Keterangan -->
                                <td class="py-4 pr-6 leading-relaxed max-w-xl">
                                    {{ $poli->keterangan }}
                                </td>

                                <!-- Dokter -->
                                <td class="py-4 text-center">
                                    @forelse ($poli->dokters as $dokter)
                                        <span class="inline-block bg-blue-100 text-blue-600 text-xs px-3 py-1 rounded-full mb-1">
                                            {{ $dokter->name }}
                                        </span>
                                    @empty
                                        <span class="text-gray-400 text-xs">Belum ada dokter</span>
                                    @endforelse
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-6 text-gray-400">
                                    Data poli tidak ditemukan
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

            </div>

            <!-- AKSES CEPAT -->
            <div class="bg-white rounded-xl shadow p-6">

                <h2 class="font-semibold text-lg mb-4">Akses Cepat</h2>

                <div class="space-y-4">

                    <a href="{{ route('admin.polis.create') }}"
                       class="block bg-blue-100 hover:bg-blue-200 transition p-4 rounded-lg">
                        <div class="font-medium text-blue-700">+ Tambah Poli</div>
                        <div class="text-xs text-blue-500">Daftarkan poli baru</div>
                    </a>

                    <a href="{{ route('admin.dokter.create') }}"
                       class="block bg-green-100 hover:bg-green-200 transition p-4 rounded-lg">
                        <div class="font-medium text-green-700">+ Tambah Dokter</div>
                        <div class="text-xs text-green-500">Daftarkan dokter baru</div>
                    </a>

                    <a href="{{ route('admin.pasien.create') }}"
                       class="block bg-yellow-100 hover:bg-yellow-200 transition p-4 rounded-lg">
                        <div class="font-medium text-yellow-700">+ Tambah Pasien</div>
                        <div class="text-xs text-yellow-500">Daftarkan pasien baru</div>
                    </a>

                    <a href="{{ route('admin.obat.create') }}"
                       class="block bg-pink-100 hover:bg-pink-200 transition p-4 rounded-lg">
                        <div class="font-medium text-pink-700">+ Tambah Obat</div>
                        <div class="text-xs text-pink-500">Tambahkan data obat</div>
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-layouts.app>