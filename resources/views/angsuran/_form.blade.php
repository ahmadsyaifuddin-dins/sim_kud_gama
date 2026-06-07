<div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mt-4">

    <div class="md:col-span-2">
        <h3 class="text-lg font-semibold text-slate-700 border-b border-slate-300 pb-2 mb-2">
            <i class="fa-solid fa-file-invoice-dollar text-pink-500 mr-2"></i> Data Pinjaman & Angsuran
        </h3>
    </div>

    <div class="md:col-span-2">
        <x-forms.label value="Pilih Pinjaman (Anggota)" required="true" />
        <x-forms.dropdown name="pinjaman_id" required>
            <option value="" disabled
                {{ old('pinjaman_id', $angsuran->pinjaman_id ?? '') == '' ? 'selected' : '' }}>-- Pilih Data Pinjaman --
            </option>
            @foreach ($pinjamans as $pinjam)
                <option value="{{ $pinjam->id }}"
                    {{ old('pinjaman_id', $angsuran->pinjaman_id ?? '') == $pinjam->id ? 'selected' : '' }}>
                    {{ $pinjam->member->nomor_anggota }} - {{ $pinjam->member->nama_lengkap }} (Sisa Tenor:
                    {{ $pinjam->lama_angsuran }} Bln)
                </option>
            @endforeach
        </x-forms.dropdown>
        @error('pinjaman_id')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Angsuran Ke (Bulan)" required="true" />
        <x-forms.input type="number" name="angsuran_ke" value="{{ old('angsuran_ke', $angsuran->angsuran_ke ?? '') }}"
            min="1" required placeholder="Contoh: 1" />
        @error('angsuran_ke')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Tanggal Pembayaran" required="true" />
        <x-forms.input type="date" name="tanggal_bayar"
            value="{{ old('tanggal_bayar', isset($angsuran) ? $angsuran->tanggal_bayar : date('Y-m-d')) }}" required />
        @error('tanggal_bayar')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div class="md:col-span-2 mt-4">
        <h3 class="text-lg font-semibold text-slate-700 border-b border-slate-300 pb-2 mb-2">
            <i class="fa-solid fa-money-bill-transfer text-pink-500 mr-2"></i> Detail Pembayaran
        </h3>
    </div>

    <div>
        <x-forms.label value="Jumlah Bayar (Rp)" required="true" />
        <x-forms.currency name="jumlah_bayar"
            value="{{ old('jumlah_bayar', isset($angsuran) ? round($angsuran->jumlah_bayar) : '') }}" required
            placeholder="0" />
        @error('jumlah_bayar')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Bukti Pembayaran (Struk/Transfer)" />
        <x-forms.upload-file name="bukti_bayar" accept="image/*" />
        <p class="text-xs text-slate-400 mt-1 italic">*Opsional. Max 2MB (JPG/PNG/WEBP). Kosongkan jika tidak
            ada/diubah.</p>
        @error('bukti_bayar')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror

        @if (isset($angsuran) && $angsuran->bukti_bayar)
            <div
                class="mt-3 flex items-center gap-3 p-3 bg-slate-50 border border-slate-200 rounded-lg shadow-sm w-fit">
                <img src="{{ asset($angsuran->bukti_bayar) }}" alt="Bukti Bayar"
                    class="h-14 w-14 rounded-md object-cover border-2 border-white shadow cursor-pointer hover:opacity-80 transition"
                    title="Klik untuk melihat, atau gunakan klik kanan > Buka gambar di tab baru">
                <div class="text-sm">
                    <p class="font-bold text-slate-700">Bukti Saat Ini</p>
                    <p class="text-xs text-slate-500">Tersimpan di sistem</p>
                </div>
            </div>
        @endif
    </div>

</div>
