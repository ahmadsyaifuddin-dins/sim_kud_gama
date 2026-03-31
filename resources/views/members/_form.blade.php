<div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">

    {{-- Alert Error Box --}}
    @if ($errors->any())
        <div class="sm:col-span-2 p-4 mb-2 text-sm text-red-700 bg-red-100 rounded-lg border border-red-200"
            role="alert">
            <p class="font-bold mb-1"><i class="fa-solid fa-triangle-exclamation mr-1"></i> Terjadi kesalahan input:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Status Keanggotaan (Hanya muncul saat Edit) --}}
    @if (isset($member) && $member->exists)
        <div class="sm:col-span-2 bg-yellow-50 p-5 rounded-lg border border-yellow-200 shadow-sm">
            <label class="block text-sm font-bold text-gray-800 mb-2">Status Keanggotaan</label>
            <select name="status"
                class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 font-bold
                {{ $member->status == 'active' ? 'text-green-700 bg-green-50' : ($member->status == 'stopped' ? 'text-red-700 bg-red-50' : 'text-gray-700') }}">
                <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>AKTIF -
                    Anggota Resmi</option>
                <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>PASIF /
                    NON-AKTIF (Cuti sementara)</option>
                <option value="stopped" {{ old('status', $member->status) == 'stopped' ? 'selected' : '' }}>BERHENTI /
                    KELUAR (Mengundurkan diri/Meninggal)</option>
                <option value="pending" {{ old('status', $member->status) == 'pending' ? 'selected' : '' }}>PENDING
                    (Menunggu Verifikasi)</option>
            </select>
            <p class="text-xs text-gray-500 mt-2">
                *Ubah status ke <b>"Berhenti"</b> jika anggota resmi mengundurkan diri atau dikeluarkan.
            </p>
        </div>
    @endif

    {{-- Blok Data Pribadi --}}
    <div>
        <x-forms.label value="Nomor Anggota" required="true" />
        <x-forms.input type="text" name="nomor_anggota"
            value="{{ old('nomor_anggota', $member->nomor_anggota ?? '') }}" placeholder="Contoh: KUD-GM-0001"
            required />
    </div>

    <div>
        <x-forms.numeric-input name="nik" label="NIK (Nomor KTP)" mode="nik" required="true"
            placeholder="16 Digit Angka" :value="$member->nik ?? ''" />
    </div>

    <div class="sm:col-span-2">
        <x-forms.label value="Nama Lengkap" required="true" />
        <x-forms.input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $member->nama_lengkap ?? '') }}"
            required />
    </div>

    <div>
        <x-forms.label value="Tempat Lahir" required="true" />
        <x-forms.input type="text" name="tempat_lahir" value="{{ old('tempat_lahir', $member->tempat_lahir ?? '') }}"
            required />
    </div>

    <div>
        <x-forms.label value="Tanggal Lahir" required="true" />
        <x-forms.input type="date" name="tanggal_lahir"
            value="{{ old('tanggal_lahir', isset($member) && $member->tanggal_lahir ? $member->tanggal_lahir->format('Y-m-d') : '') }}"
            required />
    </div>

    <div>
        <x-forms.label value="Jenis Kelamin" required="true" />
        <x-forms.dropdown name="jenis_kelamin" required>
            <option value="L" {{ old('jenis_kelamin', $member->jenis_kelamin ?? '') == 'L' ? 'selected' : '' }}>
                Laki-laki</option>
            <option value="P" {{ old('jenis_kelamin', $member->jenis_kelamin ?? '') == 'P' ? 'selected' : '' }}>
                Perempuan</option>
        </x-forms.dropdown>
    </div>

    <div>
        <x-forms.label value="Pekerjaan" />
        <x-forms.input type="text" name="pekerjaan" value="{{ old('pekerjaan', $member->pekerjaan ?? '') }}" />
    </div>

    <div>
        <x-forms.label value="Luasan Lahan Sawit (Hektar)" required="true" />
        <div class="relative mt-1">
            <input type="number" step="0.01" name="luasan_lahan"
                value="{{ old('luasan_lahan', $member->luasan_lahan ?? '') }}"
                class="block w-full text-sm border-gray-300 rounded-md shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200 pr-10"
                placeholder="Contoh: 2.5" required>
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <span class="text-gray-500 sm:text-sm font-bold">Ha</span>
            </div>
        </div>
    </div>

    <div>
        <x-forms.numeric-input name="no_hp" label="No HP / WA" mode="no_hp" required="true"
            placeholder="10-15 Digit Angka" :value="$member->no_hp ?? ''" />
    </div>

    <div class="sm:col-span-2">
        <x-forms.label value="Alamat Lengkap (Jalan/RT/RW)" required="true" />
        <textarea name="alamat_lengkap" rows="3" required
            class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-purple-400 focus:ring focus:ring-purple-200">{{ old('alamat_lengkap', $member->alamat_lengkap ?? '') }}</textarea>
    </div>

    <div>
        <x-forms.label value="Dusun" required="true" />
        <x-forms.input type="text" name="dusun" value="{{ old('dusun', $member->dusun ?? '') }}"
            placeholder="Nama Dusun" required />
    </div>

    <div>
        <x-forms.label value="Desa" required="true" />
        <input type="text" name="desa" value="Telaga Sari" readonly
            class="block w-full mt-1 text-sm bg-gray-100 border-gray-300 rounded-md shadow-sm cursor-not-allowed text-gray-500 font-semibold">
    </div>

    <div>
        <x-forms.label value="Tanggal Bergabung" required="true" />
        <x-forms.input type="date" name="tanggal_bergabung"
            value="{{ old('tanggal_bergabung', isset($member) && $member->tanggal_bergabung ? $member->tanggal_bergabung->format('Y-m-d') : date('Y-m-d')) }}"
            required />
    </div>

    <div>
        <x-forms.label value="Pas Foto (JPG/PNG, Max 2MB)" />
        <x-forms.upload-file name="foto" accept="image/*" />
        @if (isset($member) && $member->foto)
            <div class="mt-2 flex items-center gap-3">
                <img src="{{ asset($member->foto) }}" alt="Foto Lama"
                    class="w-16 h-20 object-cover rounded border border-gray-300 shadow-sm">
                <span class="text-xs text-green-600 font-bold"><i class="fa-solid fa-check-circle"></i> Foto
                    Tersimpan</span>
            </div>
        @endif
    </div>

</div>

{{-- SECTION: BERKAS PERSYARATAN --}}
<hr class="my-8 border-gray-300 border-dashed">
<div class="flex items-center gap-2 mb-4">
    <i class="fa-solid fa-folder-open text-purple-600 text-xl"></i>
    <h3 class="text-lg font-bold text-gray-800">Berkas Persyaratan (Lampiran)</h3>
</div>

<div class="grid grid-cols-1 gap-6 sm:grid-cols-3 bg-gray-50 p-5 rounded-xl border border-gray-200">
    <div>
        <label class="block text-sm font-bold text-gray-700 mb-1">Scan Sertifikat Tanah (Wajib)</label>
        <x-forms.upload-file name="file_sertifikat_tanah" accept=".pdf,image/*" />
        <p class="text-[10px] text-gray-500 mt-1 mb-2">PDF/JPG (Max 2MB)</p>
        @if (isset($member) && $member->file_sertifikat_tanah)
            <a href="{{ asset($member->file_sertifikat_tanah) }}" target="_blank"
                class="inline-flex items-center gap-1 text-xs text-blue-600 font-semibold bg-blue-50 px-2 py-1 rounded hover:bg-blue-100 transition">
                <i class="fa-solid fa-eye"></i> Lihat File
            </a>
        @endif
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-1">Scan KTP</label>
        <x-forms.upload-file name="file_ktp" accept=".pdf,image/*" />
        <p class="text-[10px] text-gray-500 mt-1 mb-2">PDF/JPG (Max 2MB)</p>
        @if (isset($member) && $member->file_ktp)
            <a href="{{ asset($member->file_ktp) }}" target="_blank"
                class="inline-flex items-center gap-1 text-xs text-blue-600 font-semibold bg-blue-50 px-2 py-1 rounded hover:bg-blue-100 transition">
                <i class="fa-solid fa-eye"></i> Lihat File
            </a>
        @endif
    </div>

    <div>
        <label class="block text-sm font-bold text-gray-700 mb-1">Scan KK</label>
        <x-forms.upload-file name="file_kk" accept=".pdf,image/*" />
        <p class="text-[10px] text-gray-500 mt-1 mb-2">PDF/JPG (Max 2MB)</p>
        @if (isset($member) && $member->file_kk)
            <a href="{{ asset($member->file_kk) }}" target="_blank"
                class="inline-flex items-center gap-1 text-xs text-blue-600 font-semibold bg-blue-50 px-2 py-1 rounded hover:bg-blue-100 transition">
                <i class="fa-solid fa-eye"></i> Lihat File
            </a>
        @endif
    </div>
</div>

{{-- SECTION: PEMBAYARAN --}}
<hr class="my-8 border-gray-300 border-dashed">
<div class="flex items-center gap-2 mb-4">
    <i class="fa-solid fa-money-bill-wave text-green-600 text-xl"></i>
    <h3 class="text-lg font-bold text-gray-800">Pembayaran Administrasi (Rp 150.000)</h3>
</div>

<div class="grid grid-cols-1 gap-6 sm:grid-cols-2 bg-green-50 p-5 rounded-xl border border-green-200">
    <div>
        <label class="block text-sm font-bold text-gray-700 mb-1">Bukti Transfer / Kwitansi Manual</label>
        <x-forms.upload-file name="file_bukti_bayar" accept="image/*" />
        <p class="text-[10px] text-gray-500 mt-1 mb-2">Foto Struk / Screenshot Transfer</p>

        @if (isset($member) && $member->file_bukti_bayar)
            <div class="mt-2 flex items-center gap-3 bg-white p-2 rounded border border-green-200 w-max">
                <a href="{{ asset($member->file_bukti_bayar) }}" target="_blank">
                    <img src="{{ asset($member->file_bukti_bayar) }}"
                        class="h-16 w-auto rounded border border-gray-200 hover:opacity-80 transition">
                </a>
                <span class="text-xs text-green-700 font-black tracking-wider"><i
                        class="fa-solid fa-check-double"></i> LUNAS</span>
            </div>
        @endif
    </div>

    <div>
        <x-forms.label value="Tanggal Bayar" class="font-bold" />
        <x-forms.input type="date" name="tanggal_bayar"
            value="{{ old('tanggal_bayar', isset($member) && $member->tanggal_bayar ? $member->tanggal_bayar->format('Y-m-d') : '') }}" />
    </div>
</div>
