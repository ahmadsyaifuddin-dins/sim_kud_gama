@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <div>
        <x-forms.label value="Anggota Peminjam" required="true" />
        <x-forms.dropdown name="member_id" required>
            <option value="">-- Pilih Anggota --</option>
            @foreach ($members as $member)
                <option value="{{ $member->id }}"
                    {{ old('member_id', $pinjaman->member_id ?? '') == $member->id ? 'selected' : '' }}>
                    {{ $member->nomor_anggota }} - {{ $member->nama_lengkap }}
                </option>
            @endforeach
        </x-forms.dropdown>
    </div>

    <div>
        <x-forms.label value="Tanggal Pengajuan" required="true" />
        <x-forms.input type="date" name="tanggal_pengajuan"
            value="{{ old('tanggal_pengajuan', isset($pinjaman) ? $pinjaman->tanggal_pengajuan : date('Y-m-d')) }}"
            required />
    </div>

    <div>
        <x-forms.label value="Jumlah Pinjaman (Rp)" required="true" />
        <x-forms.currency name="jumlah_pinjaman"
            value="{{ old('jumlah_pinjaman', isset($pinjaman) ? round($pinjaman->jumlah_pinjaman) : '') }}" required />
    </div>

    <div>
        <x-forms.label value="Lama Angsuran (Bulan)" required="true" />
        <x-forms.input type="number" name="lama_angsuran"
            value="{{ old('lama_angsuran', $pinjaman->lama_angsuran ?? '') }}" min="1" required />
    </div>

    <div class="md:col-span-2">
        <x-forms.label value="Keperluan Pinjaman" required="true" />
        <x-forms.textarea name="keperluan" rows="3"
            required>{{ old('keperluan', $pinjaman->keperluan ?? '') }}</x-forms.textarea>
    </div>

    @if (isset($pinjaman))
        <div class="md:col-span-2">
            <x-forms.label value="Status Persetujuan" required="true" />
            <x-forms.dropdown name="status" required>
                <option value="menunggu" {{ old('status', $pinjaman->status) == 'menunggu' ? 'selected' : '' }}>Menunggu
                </option>
                <option value="disetujui" {{ old('status', $pinjaman->status) == 'disetujui' ? 'selected' : '' }}>
                    Disetujui</option>
                <option value="ditolak" {{ old('status', $pinjaman->status) == 'ditolak' ? 'selected' : '' }}>Ditolak
                </option>
                <option value="lunas" {{ old('status', $pinjaman->status) == 'lunas' ? 'selected' : '' }}>Lunas
                </option>
            </x-forms.dropdown>
        </div>
    @endif
</div>
