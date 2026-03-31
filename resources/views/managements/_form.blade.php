@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="md:col-span-2">
        <x-forms.label value="Nama Lengkap" required="true" />
        <x-forms.input type="text" name="nama" value="{{ old('nama', $management->nama ?? '') }}" required />
        @error('nama')
            <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Jabatan" required="true" />
        <x-forms.dropdown name="jabatan" required>
            <option value="">-- Pilih Jabatan --</option>
            @foreach (['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Pengawas', 'Anggota'] as $jbt)
                <option value="{{ $jbt }}"
                    {{ old('jabatan', $management->jabatan ?? '') == $jbt ? 'selected' : '' }}>
                    {{ $jbt }}
                </option>
            @endforeach
        </x-forms.dropdown>
        @error('jabatan')
            <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Nomor HP" required="true" />
        <x-forms.input type="number" name="no_hp" value="{{ old('no_hp', $management->no_hp ?? '') }}"
            placeholder="Contoh: 08123456789" required />
        @error('no_hp')
            <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Mulai Menjabat (Tahun)" required="true" />
        <x-forms.input type="number" name="periode_mulai"
            value="{{ old('periode_mulai', $management->periode_mulai ?? date('Y')) }}" placeholder="Contoh: 2024"
            required />
        @error('periode_mulai')
            <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Selesai Menjabat (Tahun)" required="true" />
        <x-forms.input type="number" name="periode_selesai"
            value="{{ old('periode_selesai', $management->periode_selesai ?? date('Y') + 5) }}"
            placeholder="Contoh: 2029" required />
        @error('periode_selesai')
            <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
    </div>

    <div class="md:col-span-2 flex items-center gap-2 mt-2">
        <input type="checkbox" name="is_active" value="1" id="is_active"
            class="rounded border-gray-300 text-pink-600 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50 h-5 w-5 cursor-pointer"
            {{ old('is_active', $management->is_active ?? true) ? 'checked' : '' }}>
        <label for="is_active" class="text-sm text-gray-700 font-bold cursor-pointer select-none">Status Masih Aktif
            Menjabat</label>
    </div>

    <div class="md:col-span-2">
        <x-forms.label value="Foto Profil" />
        <x-forms.upload-file name="foto" accept="image/*" />

        @if (isset($management) && $management->foto)
            <div class="mt-3">
                <p class="text-sm text-gray-500 mb-1 font-semibold">Foto Saat Ini:</p>
                <img src="{{ asset($management->foto) }}" alt="Foto Pengurus"
                    class="h-24 w-24 rounded-lg object-cover border-2 border-pink-200 shadow-sm">
            </div>
        @endif
        <p class="text-xs text-gray-400 mt-1">*Opsional. Max 2MB (JPG/PNG/WEBP). Kosongkan jika tidak ingin mengubah
            foto.</p>
        @error('foto')
            <span class="text-red-500 text-xs">{{ $message }}</span>
        @enderror
    </div>

</div>
