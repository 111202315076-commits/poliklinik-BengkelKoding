<x-layouts.app title="Edit Dokter">

    {{-- HEADER --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.dokter.index') }}"
           class="flex items-center justify-center w-9 h-9 rounded-lg
           bg-slate-100 hover:bg-slate-200 text-slate-600 transition">
            <i class="fas fa-arrow-left text-sm"></i>
        </a>

        <h2 class="text-2xl font-bold text-slate-800">
            Edit Dokter
        </h2>
    </div>

    <div class="bg-white shadow-md rounded-2xl border border-slate-200">
        <div class="p-8">

            <form action="{{ route('admin.dokter.update',$dokter->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                    {{-- Nama --}}
                    <div class="mb-3">
                        <label>Nama Dokter</label>
                        <input type="text"
                            name="name"
                            value="{{ old('name', $dokter->name) }}"
                            class="form-control"
                            required>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="font-semibold text-sm">Email *</label>
                        <input type="email" name="email"
                            value="{{ old('email',$dokter->email) }}"
                            class="w-full mt-1 px-4 py-2 border rounded-lg" required>
                    </div>

                    {{-- KTP --}}
                    <div>
                        <label class="font-semibold text-sm">No KTP *</label>
                        <input type="text" name="no_ktp"
                            value="{{ old('no_ktp',$dokter->no_ktp) }}"
                            class="w-full mt-1 px-4 py-2 border rounded-lg" required>
                    </div>

                    {{-- HP --}}
                    <div>
                        <label class="font-semibold text-sm">No HP *</label>
                        <input type="text" name="no_hp"
                            value="{{ old('no_hp',$dokter->no_hp) }}"
                            class="w-full mt-1 px-4 py-2 border rounded-lg" required>
                    </div>

                </div>

                {{-- Alamat --}}
                <div class="mb-6">
                    <label class="font-semibold text-sm">Alamat *</label>
                    <textarea name="alamat" rows="3"
                        class="w-full mt-1 px-4 py-2 border rounded-lg"
                        required>{{ old('alamat',$dokter->alamat) }}</textarea>
                </div>

                {{-- Poli --}}

                <div class="mb-6">
                    <label class="font-semibold text-sm">Poli *</label>
                    <select name="id_poli"
                            class="w-full mt-1 px-4 py-2 border rounded-lg" required>


                        {{-- Default --}}
                        <option value="">-- Pilih Poli --</option>

                        @foreach($polis as $poli)
                            <option value="{{ $poli->id }}"
                                {{ old('id_poli', $dokter->id_poli) == $poli->id ? 'selected' : '' }}>
                                {{ $poli->nama_poli }}
                            </option>
                        @endforeach

                    </select>

                </div>


                {{-- Password --}}
                <div class="mb-8">
                    <label class="font-semibold text-sm">
                        Password (Kosongkan jika tidak diubah)
                    </label>
                    <input type="password" name="password"
                        class="w-full mt-1 px-4 py-2 border rounded-lg">
                </div>

                {{-- BUTTON --}}
                <div class="flex gap-3">
                    <button type="submit"
                        class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-primary/90">
                        Update
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