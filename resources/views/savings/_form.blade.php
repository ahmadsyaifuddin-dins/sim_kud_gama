@csrf
<div class="grid grid-cols-1 gap-6">

    <div>
        <x-forms.label value="Pilih Anggota" required="true" />
        <x-forms.dropdown name="member_id" required>
            <option value="">-- Cari Nama Anggota --</option>
            @foreach ($members as $member)
                <option value="{{ $member->id }}"
                    {{ old('member_id', $saving->member_id ?? '') == $member->id ? 'selected' : '' }}>
                    {{ $member->nomor_anggota }} - {{ $member->nama_lengkap }}
                </option>
            @endforeach
        </x-forms.dropdown>
    </div>

    <div>
        <x-forms.label value="Jenis Simpanan" required="true" />
        <div class="mt-2 flex flex-wrap gap-6">
            <label class="inline-flex items-center cursor-pointer">
                <input type="radio" name="jenis_simpanan" value="pokok"
                    class="text-pink-600 focus:ring-pink-500 h-5 w-5 cursor-pointer"
                    {{ old('jenis_simpanan', $saving->jenis_simpanan ?? '') == 'pokok' ? 'checked' : '' }} required>
                <span class="ml-2 text-sm text-gray-700 font-semibold">Simpanan Pokok</span>
            </label>
            <label class="inline-flex items-center cursor-pointer">
                <input type="radio" name="jenis_simpanan" value="wajib"
                    class="text-pink-600 focus:ring-pink-500 h-5 w-5 cursor-pointer"
                    {{ old('jenis_simpanan', $saving->jenis_simpanan ?? 'wajib') == 'wajib' ? 'checked' : '' }}
                    required>
                <span class="ml-2 text-sm text-gray-700 font-semibold">Simpanan Wajib</span>
            </label>
            <label class="inline-flex items-center cursor-pointer">
                <input type="radio" name="jenis_simpanan" value="sukarela"
                    class="text-pink-600 focus:ring-pink-500 h-5 w-5 cursor-pointer"
                    {{ old('jenis_simpanan', $saving->jenis_simpanan ?? '') == 'sukarela' ? 'checked' : '' }} required>
                <span class="ml-2 text-sm text-gray-700 font-semibold">Simpanan Sukarela</span>
            </label>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <x-forms.label value="Jumlah (Rp)" required="true" />
            <x-forms.currency name="jumlah" value="{{ old('jumlah', isset($saving) ? round($saving->jumlah) : '') }}"
                placeholder="Contoh: 50000" required />
        </div>

        <div>
            <x-forms.label value="Tanggal Bayar" required="true" />
            <x-forms.input type="date" name="tanggal_bayar"
                value="{{ old('tanggal_bayar', isset($saving) ? \Carbon\Carbon::parse($saving->tanggal_bayar)->format('Y-m-d') : date('Y-m-d')) }}"
                required />
        </div>
    </div>

    <div>
        <x-forms.label value="Keterangan (Opsional)" />
        <x-forms.input type="text" name="keterangan" value="{{ old('keterangan', $saving->keterangan ?? '') }}"
            placeholder="Contoh: Iuran Wajib Bulan Januari 2026" />
    </div>

    <div>
        <x-forms.label value="Bukti Transfer (Jika Ada)" />
        <x-forms.upload-file name="bukti_transfer" accept="image/*" />

        @if (isset($saving) && $saving->bukti_transfer)
            <div class="mt-3">
                <p class="text-sm text-gray-500 mb-1 font-semibold">Bukti Saat Ini:</p>
                <a href="{{ asset($saving->bukti_transfer) }}" target="_blank" class="inline-block">
                    <img src="{{ asset($saving->bukti_transfer) }}" alt="Bukti Transfer"
                        class="h-24 w-auto rounded-lg object-cover border-2 border-pink-200 shadow-sm hover:opacity-80 transition">
                </a>
            </div>
        @endif
        <p class="text-xs text-gray-400 mt-1">*Opsional. Max 2MB (JPG/PNG/WEBP). Kosongkan jika tidak ada perubahan.</p>
    </div>

</div>
