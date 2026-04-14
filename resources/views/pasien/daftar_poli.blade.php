<x-layouts.app title="Pendaftaran Poli">
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-[32px] shadow-sm border border-slate-100 overflow-hidden">
            <div class="p-8 border-b border-slate-50 text-center">
                <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-notes-medical text-2xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800">Pendaftaran Poli</h3>
                <p class="text-slate-400 text-sm mt-1">Silakan isi form di bawah untuk mendapatkan nomor antrian.</p>
            </div>

            <form action="{{ route('pasien.daftar_poli.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                {{-- Nomor Rekam Medis --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Nomor Rekam Medis</label>
                    <input type="text" value="{{ auth()->user()->pasien->no_rm ?? 'Belum Ada No. RM' }}" disabled 
                           class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 text-slate-500 font-medium">
                </div>

                {{-- Pilih Poli --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Poli</label>
                    <select name="id_poli" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 outline-none transition-all appearance-none">
                        <option value="">-- Pilih Poli --</option>
                        @foreach($polis as $poli)
                            <option value="{{ $poli->id }}">{{ $poli->nama_poli }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Pilih Jadwal --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Jadwal Periksa</label>
                    <select name="id_jadwal" class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                        <option value="">-- Pilih Jadwal --</option>
                    </select>
                </div>

                {{-- Keluhan --}}
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Keluhan</label>
                    <textarea name="keluhan" rows="4" placeholder="Tulis keluhan Anda..." 
                              class="w-full bg-white border border-slate-200 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-indigo-500 outline-none transition-all"></textarea>
                </div>

                <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all">
                    Daftar Poli Sekarang
                </button>
            </form>
        </div>
    </div>

    {{-- Script AJAX --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('select[name="id_poli"]').on('change', function() {
                var poliId = $(this).val();
                if(poliId) {
                    $.ajax({
                        url: '/pasien/get-jadwal/' + poliId,
                        type: "GET",
                        dataType: "json",
                        success:function(data) {
                            $('select[name="id_jadwal"]').empty();
                            $('select[name="id_jadwal"]').append('<option value="">-- Pilih Jadwal --</option>');
                            $.each(data, function(key, value) {
                                // Menampilkan Hari, Nama Dokter, dan Jam Praktik
                                $('select[name="id_jadwal"]').append('<option value="'+ value.id +'">'+ value.hari + ' - Dokter ' + value.dokter.nama + ' (' + value.jam_mulai + ' - ' + value.jam_selesai + ')</option>');
                            });
                        }
                    });
                } else {
                    $('select[name="id_jadwal"]').empty();
                    $('select[name="id_jadwal"]').append('<option value="">-- Pilih Jadwal --</option>');
                }
            });
        });
    </script>
</x-layouts.app>