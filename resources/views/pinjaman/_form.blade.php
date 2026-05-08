@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Field Anggota Peminjam -->
    <div>
        <x-forms.label value="Anggota Peminjam" required="true" />
        <!-- Jika mode edit (ada data pinjaman), disable dropdown agar tidak bisa diubah -->
        <x-forms.dropdown name="member_id" required :disabled="isset($pinjaman)">
            <option value="">-- Pilih Anggota --</option>
            @foreach ($members as $member)
                <option value="{{ $member->id }}"
                    {{ old('member_id', $pinjaman->member_id ?? '') == $member->id ? 'selected' : '' }}>
                    {{ $member->nomor_anggota }} - {{ $member->nama_lengkap }}
                </option>
            @endforeach
        </x-forms.dropdown>

        <!-- Hidden input untuk mempertahankan nilai saat form di-disable -->
        @if (isset($pinjaman))
            <input type="hidden" name="member_id" value="{{ $pinjaman->member_id }}">
        @endif
    </div>

    <!-- Field Tanggal Pengajuan -->
    <div>
        <x-forms.label value="Tanggal Pengajuan" required="true" />
        <x-forms.input type="date" name="tanggal_pengajuan"
            value="{{ old('tanggal_pengajuan', isset($pinjaman) ? $pinjaman->tanggal_pengajuan : date('Y-m-d')) }}"
            required />
    </div>

    <!-- Field Jumlah Pinjaman -->
    <div>
        <x-forms.label value="Jumlah Pinjaman (Rp)" required="true" />
        <x-forms.currency name="jumlah_pinjaman"
            value="{{ old('jumlah_pinjaman', isset($pinjaman) ? round($pinjaman->jumlah_pinjaman) : '') }}" required />
    </div>

    <!-- Field Lama Angsuran -->
    <div>
        <x-forms.label value="Lama Angsuran (Bulan)" required="true" />
        <x-forms.input type="number" name="lama_angsuran"
            value="{{ old('lama_angsuran', $pinjaman->lama_angsuran ?? '') }}" min="1" required />
    </div>

    <!-- Field Keperluan Pinjaman -->
    <div class="md:col-span-2">
        <x-forms.label value="Keperluan Pinjaman" required="true" />
        <x-forms.textarea name="keperluan" rows="3"
            required>{{ old('keperluan', $pinjaman->keperluan ?? '') }}</x-forms.textarea>
    </div>

    <!-- Field Status Persetujuan (Hanya muncul di halaman Edit) -->
    @if (isset($pinjaman))
        <div class="md:col-span-2">
            <x-forms.label value="Status Persetujuan" required="true" />
            <!-- Dropdown sengaja di-disable agar status hanya bisa diubah via tombol aksi di halaman index -->
            <x-forms.dropdown name="status" required disabled class="bg-gray-100 cursor-not-allowed">
                <option value="menunggu" {{ old('status', $pinjaman->status) == 'menunggu' ? 'selected' : '' }}>Menunggu
                </option>
                <option value="disetujui" {{ old('status', $pinjaman->status) == 'disetujui' ? 'selected' : '' }}>
                    Disetujui</option>
                <option value="ditolak" {{ old('status', $pinjaman->status) == 'ditolak' ? 'selected' : '' }}>Ditolak
                </option>
                <option value="lunas" {{ old('status', $pinjaman->status) == 'lunas' ? 'selected' : '' }}>Lunas
                </option>
            </x-forms.dropdown>
            <p class="text-xs text-gray-500 mt-1">*Status persetujuan hanya dapat diubah melalui tombol aksi pada
                halaman Daftar Pinjaman untuk memicu notifikasi WhatsApp.</p>
        </div>
    @endif

</div>
