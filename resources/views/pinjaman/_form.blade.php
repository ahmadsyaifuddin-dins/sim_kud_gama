<div class="bg-blue-50 border-l-4 border-blue-500 text-blue-800 p-4 mb-6 rounded shadow-sm" role="alert">
    <div class="flex">
        <div class="py-1">
            <svg class="w-6 h-6 text-blue-500 mr-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <div>
            <p class="font-bold">Sumber Modal Penyaluran Pinjaman KUD Gajah Mada</p>
            <p class="text-sm leading-relaxed mt-1">Dana pinjaman ini bersumber dari modal sendiri koperasi (simpanan
                pokok, wajib, sukarela, serta dana cadangan/SHU ditahan) dan modal kemitraan pihak ketiga (perkebunan
                kelapa sawit, sektor pertambangan, serta fasilitas likuiditas lembaga keuangan), berlandaskan Pasal 41
                UU No. 25 Tahun 1992. Pengembalian angsuran anggota menjadi dana bergulir untuk membiayai pinjaman
                berikutnya.</p>
        </div>
    </div>
</div>

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
