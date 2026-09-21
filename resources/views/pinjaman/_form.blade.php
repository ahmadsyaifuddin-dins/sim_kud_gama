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

<div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 mb-6">
    <div class="flex items-start gap-3">
        <div
            class="w-9 h-9 flex-shrink-0 flex items-center justify-center rounded-lg bg-emerald-100 text-emerald-600">
            <i class="fa-solid fa-shield-halved"></i>
        </div>
        <div class="flex-1">
            <p class="text-sm font-bold text-emerald-800">Batas Maksimal Plafond Pinjaman</p>
            <p class="text-xs text-emerald-700 leading-relaxed mt-0.5">
                Nominal pinjaman dibatasi berdasarkan nilai terbesar antara
                <strong>luas lahan sawit (Ha × plafond per hektar)</strong> atau
                <strong>akumulasi saldo Simpanan Pokok + Wajib (× pengali)</strong>.
                Pilih anggota di bawah untuk melihat plafondnya.
            </p>
            <div class="mt-2 text-sm" id="plafond-preview">
                <span class="text-emerald-800 font-semibold">Plafond anggota: </span>
                @if (isset($pinjaman) && $pinjaman->member)
                    <span class="font-bold" id="plafond-nominal">
                        Rp {{ number_format($membersPlafond[$pinjaman->member_id]['plafond'] ?? 0, 0, ',', '.') }}
                    </span>
                    <span class="text-xs text-emerald-600 ml-2" id="plafond-detail">
                        (Lahan: {{ number_format($membersPlafond[$pinjaman->member_id]['luasan_lahan'] ?? 0, 2, ',', '.') }}
                        Ha • Simpanan P+W: Rp {{ number_format($membersPlafond[$pinjaman->member_id]['saldo_pokok_wajib'] ?? 0, 0, ',', '.') }})
                    </span>
                @else
                    <span class="font-bold" id="plafond-nominal">-- pilih anggota --</span>
                    <span class="text-xs text-emerald-600 ml-2" id="plafond-detail"></span>
                @endif
            </div>
        </div>
    </div>
</div>

@csrf
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Field Anggota Peminjam -->
    <div>
        <x-forms.label value="Anggota Peminjam" required="true" />
        <!-- Jika mode edit (ada data pinjaman), disable dropdown agar tidak bisa diubah -->
        <x-forms.dropdown name="member_id" required id="member-dropdown" :disabled="isset($pinjaman)">
            <option value="">-- Pilih Anggota --</option>
            @foreach ($members as $member)
                <option value="{{ $member->id }}"
                    data-plafond="{{ $membersPlafond[$member->id]['plafond'] ?? 0 }}"
                    data-saldo="{{ $membersPlafond[$member->id]['saldo_pokok_wajib'] ?? 0 }}"
                    data-lahan="{{ $membersPlafond[$member->id]['luasan_lahan'] ?? 0 }}"
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
            value="{{ old('tanggal_pengajuan', isset($pinjaman) ? ($pinjaman->tanggal_pengajuan?->format('Y-m-d') ?? '') : date('Y-m-d')) }}"
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
            value="{{ old('lama_angsuran', $pinjaman->lama_angsuran ?? '') }}" min="1" max="60" required />
    </div>

    <!-- Field Jenis Perhitungan Bunga -->
    <div class="md:col-span-2">
        <x-forms.label value="Jenis Perhitungan Bunga" required="true" />
        <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
            <label
                class="flex items-start gap-3 border rounded-lg p-4 cursor-pointer transition {{ old('jenis_bunga', $pinjaman->jenis_bunga ?? 'flat') === 'flat' ? 'border-pink-500 bg-pink-50' : 'border-gray-200 hover:border-pink-300' }}">
                <input type="radio" name="jenis_bunga" value="flat"
                    class="text-pink-600 focus:ring-pink-500 h-5 w-5 mt-0.5 cursor-pointer"
                    {{ old('jenis_bunga', $pinjaman->jenis_bunga ?? 'flat') === 'flat' ? 'checked' : '' }} required>
                <div>
                    <p class="text-sm font-bold text-gray-700">Bunga Flat / Tetap</p>
                    <p class="text-xs text-gray-500 leading-relaxed">Pokok & jasa dihitung rata setiap bulan. Cicilan
                        tiap angsuran sama besar selama tenor.</p>
                </div>
            </label>
            <label
                class="flex items-start gap-3 border rounded-lg p-4 cursor-pointer transition {{ old('jenis_bunga', $pinjaman->jenis_bunga ?? '') === 'menurun' ? 'border-pink-500 bg-pink-50' : 'border-gray-200 hover:border-pink-300' }}">
                <input type="radio" name="jenis_bunga" value="menurun"
                    class="text-pink-600 focus:ring-pink-500 h-5 w-5 mt-0.5 cursor-pointer"
                    {{ old('jenis_bunga', $pinjaman->jenis_bunga ?? '') === 'menurun' ? 'checked' : '' }} required>
                <div>
                    <p class="text-sm font-bold text-gray-700">Bunga Menurun (Anuitas)</p>
                    <p class="text-xs text-gray-500 leading-relaxed">Jasa dihitung dari sisa pokok yang belum lunas.
                        Porsi bunga menurun seiring berjalannya angsuran.</p>
                </div>
            </label>
        </div>
    </div>

    <!-- Field Persentase Jasa per Bulan -->
    <div>
        <x-forms.label value="Persentase Jasa per Bulan (%)" required="true" />
        <x-forms.input type="number" step="0.01" min="0" max="12" name="persentase_bunga"
            value="{{ old('persentase_bunga', $pinjaman->persentase_bunga ?? 1.5) }}" required
            placeholder="Contoh: 1.5" />
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dropdown = document.getElementById('member-dropdown');
        if (!dropdown) {
            return;
        }

        const plafondNominal = document.getElementById('plafond-nominal');
        const plafondDetail = document.getElementById('plafond-detail');

        const formatRp = (value) => 'Rp ' + parseInt(value || 0).toLocaleString('id-ID');

        dropdown.addEventListener('change', function() {
            const option = dropdown.options[dropdown.selectedIndex];
            if (!option || !option.value) {
                plafondNominal.textContent = '-- pilih anggota --';
                plafondDetail.textContent = '';
                return;
            }

            const lahan = parseFloat(option.dataset.lahan || 0);
            const saldo = parseInt(option.dataset.saldo || 0);

            plafondNominal.textContent = formatRp(option.dataset.plafond);
            plafondDetail.textContent = '(Lahan: ' + lahan.toLocaleString('id-ID') + ' Ha \u2022 Simpanan P+W: ' +
                formatRp(saldo) + ')';
        });
    });
</script>