@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div class="md:col-span-2">
        <x-forms.label value="Pilih Pinjaman (Anggota)" required="true" />
        <x-forms.dropdown name="pinjaman_id" required>
            <option value="">-- Pilih Data Pinjaman --</option>
            @foreach ($pinjamans as $pinjam)
                <option value="{{ $pinjam->id }}"
                    {{ old('pinjaman_id', $angsuran->pinjaman_id ?? '') == $pinjam->id ? 'selected' : '' }}>
                    {{ $pinjam->member->nomor_anggota }} - {{ $pinjam->member->nama_lengkap }} (Sisa Tenor:
                    {{ $pinjam->lama_angsuran }} Bln)
                </option>
            @endforeach
        </x-forms.dropdown>
    </div>

    <div>
        <x-forms.label value="Angsuran Ke (Bulan)" required="true" />
        <x-forms.input type="number" name="angsuran_ke" value="{{ old('angsuran_ke', $angsuran->angsuran_ke ?? '') }}"
            min="1" required />
    </div>

    <div>
        <x-forms.label value="Tanggal Pembayaran" required="true" />
        <x-forms.input type="date" name="tanggal_bayar"
            value="{{ old('tanggal_bayar', isset($angsuran) ? $angsuran->tanggal_bayar : date('Y-m-d')) }}" required />
    </div>

    <div>
        <x-forms.label value="Jumlah Bayar (Rp)" required="true" />
        <x-forms.currency name="jumlah_bayar"
            value="{{ old('jumlah_bayar', isset($angsuran) ? round($angsuran->jumlah_bayar) : '') }}" required />
    </div>

    <div>
        <x-forms.label value="Bukti Pembayaran (Struk/Transfer)" />
        <x-forms.upload-file name="bukti_bayar" accept="image/*" />

        @if (isset($angsuran) && $angsuran->bukti_bayar)
            <div class="mt-2">
                <p class="text-sm text-gray-500 mb-1">Bukti saat ini:</p>
                <img src="{{ asset($angsuran->bukti_bayar) }}" alt="Bukti Bayar"
                    class="h-20 rounded-md border border-gray-300">
            </div>
        @endif
        <p class="text-xs text-gray-400 mt-1">*Kosongkan jika tidak ada/tidak diubah. Max 2MB.</p>
    </div>

</div>
