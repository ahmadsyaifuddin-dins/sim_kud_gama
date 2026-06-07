<div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mt-4">

    <div class="md:col-span-2">
        <h3 class="text-lg font-semibold text-slate-700 border-b border-slate-300 pb-2 mb-2">
            <i class="fa-solid fa-id-card text-pink-500 mr-2"></i> Data Diri
        </h3>
    </div>

    <div class="md:col-span-2">
        <x-forms.label value="Nama Lengkap" required="true" />
        <x-forms.input type="text" name="nama" value="{{ old('nama', $management->nama ?? '') }}" required
            placeholder="Masukkan nama lengkap pengurus" />
        @error('nama')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Nomor HP" required="true" />
        <x-forms.input type="number" name="no_hp" value="{{ old('no_hp', $management->no_hp ?? '') }}"
            placeholder="Contoh: 08123456789" required />
        @error('no_hp')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Foto Profil" />
        <x-forms.upload-file name="foto" accept="image/*" />
        <p class="text-xs text-slate-400 mt-1 italic">*Opsional. Max 2MB (JPG/PNG/WEBP). Kosongkan jika tidak mengubah.
        </p>
        @error('foto')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror

        @if (isset($management) && $management->foto)
            <div class="mt-3 flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-lg shadow-sm">
                <img src="{{ asset($management->foto) }}" alt="Foto Pengurus"
                    class="h-14 w-14 rounded-full object-cover border-2 border-white shadow">
                <div class="text-sm">
                    <p class="font-bold text-slate-700">Foto Saat Ini</p>
                    <p class="text-xs text-slate-500">Tersimpan di sistem</p>
                </div>
            </div>
        @endif
    </div>

    <div class="md:col-span-2 mt-4">
        <h3 class="text-lg font-semibold text-slate-700 border-b border-slate-300 pb-2 mb-2">
            <i class="fa-solid fa-briefcase text-pink-500 mr-2"></i> Jabatan & Masa Bakti
        </h3>
    </div>

    <div class="md:col-span-2">
        <x-forms.label value="Jabatan" required="true" />
        <x-forms.dropdown name="jabatan" required>
            <option value="" disabled {{ old('jabatan', $management->jabatan ?? '') == '' ? 'selected' : '' }}>--
                Pilih Jabatan --</option>
            @foreach (['Ketua', 'Wakil Ketua', 'Sekretaris', 'Bendahara', 'Pengawas', 'Anggota'] as $jbt)
                <option value="{{ $jbt }}"
                    {{ old('jabatan', $management->jabatan ?? '') == $jbt ? 'selected' : '' }}>
                    {{ $jbt }}
                </option>
            @endforeach
        </x-forms.dropdown>
        @error('jabatan')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Mulai Menjabat (Tahun)" required="true" />
        <x-forms.input type="number" name="periode_mulai"
            value="{{ old('periode_mulai', $management->periode_mulai ?? date('Y')) }}" placeholder="Contoh: 2024"
            required />
        @error('periode_mulai')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Selesai Menjabat (Tahun)" required="true" />
        <x-forms.input type="number" name="periode_selesai"
            value="{{ old('periode_selesai', $management->periode_selesai ?? date('Y') + 5) }}"
            placeholder="Contoh: 2029" required />
        @error('periode_selesai')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div class="md:col-span-2 mt-2">
        <label for="is_active"
            class="flex items-center gap-3 p-3 border border-slate-200 rounded-lg bg-white hover:bg-slate-50 cursor-pointer transition-colors shadow-sm w-fit">
            <input type="checkbox" name="is_active" value="1" id="is_active"
                class="rounded border-slate-300 text-pink-600 shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200 focus:ring-opacity-50 h-5 w-5 cursor-pointer"
                {{ old('is_active', $management->is_active ?? true) ? 'checked' : '' }}>
            <span class="text-sm text-slate-700 font-bold select-none">Status Masih Aktif Menjabat</span>
        </label>
    </div>

</div>
