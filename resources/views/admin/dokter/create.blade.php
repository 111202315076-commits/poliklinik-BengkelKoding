<x-layouts.app title="Tambah Dokter">

    {{-- HEADER --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.dokter.index') }}"
           class="flex items-center justify-center w-9 h-9 rounded-lg
           bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>

        <h2 class="text-2xl font-bold text-slate-800">
            Tambah Dokter
        </h2>
    </div>

    {{-- CARD --}}
    <div class="bg-white shadow-md rounded-2xl border border-slate-200">
        <div class="p-8">

            <form action="{{ route('admin.dokter.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    {{-- Nama --}}
                    <div>
                        <label class="font-semibold text-sm">Nama Dokter *</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="w-full mt-1 px-4 py-2 border rounded-lg
                               focus:ring focus:ring-primary/30
                               @error('name') border-red-500 @enderror" required>

                        @error('name')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="font-semibold text-sm">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="w-full mt-1 px-4 py-2 border rounded-lg
                               focus:ring focus:ring-primary/30
                               @error('email') border-red-500 @enderror" required>

                        @error('email')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- KTP --}}
                    <div>
                        <label class="font-semibold text-sm">No KTP *</label>
                        <input type="text" name="no_ktp" value="{{ old('no_ktp') }}"
                               class="w-full mt-1 px-4 py-2 border rounded-lg
                               focus:ring focus:ring-primary/30
                               @error('no_ktp') border-red-500 @enderror" required>

                        @error('no_ktp')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- HP --}}
                    <div>
                        <label class="font-semibold text-sm">No HP *</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                               class="w-full mt-1 px-4 py-2 border rounded-lg
                               focus:ring focus:ring-primary/30
                               @error('no_hp') border-red-500 @enderror" required>

                        @error('no_hp')
                            <p class="text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                {{-- Alamat --}}
                <div class="mb-6">
                    <label class="font-semibold text-sm">Alamat *</label>
                    <textarea name="alamat" rows="3"
                        class="w-full mt-1 px-4 py-2 border rounded-lg
                        focus:ring focus:ring-primary/30
                        @error('alamat') border-red-500 @enderror"
                        required>{{ old('alamat') }}</textarea>

                    @error('alamat')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Poli --}}
                <div class="mb-6">
                    <label class="font-semibold text-sm">Poli *</label>
                    <select name="id_poli"
                        class="w-full mt-1 px-4 py-2 border rounded-lg
                        @error('id_poli') border-red-500 @enderror" required>

                        <option value="">Pilih Poli</option>

                        @foreach($polis as $poli)
                            <option value="{{ $poli->id }}"
                                {{ old('id_poli') == $poli->id ? 'selected' : '' }}>
                                {{ $poli->nama_poli }}
                            </option>
                        @endforeach

                    </select>

                    @error('id_poli')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div class="mb-8">
                    <label class="font-semibold text-sm">Password *</label>
                    <input type="password" name="password"
                           class="w-full mt-1 px-4 py-2 border rounded-lg
                           @error('password') border-red-500 @enderror"
                           required>

                    @error('password')
                        <p class="text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- BUTTON --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
                        <i class="fas fa-save mr-1"></i> Simpan
                    </button>

                    <a href="{{ route('admin.dokter.index') }}"
                       class="px-6 py-2 bg-slate-100 rounded-lg hover:bg-slate-200">
                        Batal
                    </a>
                </div>

            </form>

        </div>
    </div>

</x-layouts.app>