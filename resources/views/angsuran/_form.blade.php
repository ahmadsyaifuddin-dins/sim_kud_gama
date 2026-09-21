<div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5 mt-4">

    <div class="md:col-span-2">
        <h3 class="text-lg font-semibold text-slate-700 border-b border-slate-300 pb-2 mb-2">
            <i class="fa-solid fa-file-invoice-dollar text-pink-500 mr-2"></i> Data Pinjaman & Angsuran
        </h3>
    </div>

    <div class="md:col-span-2">
        <x-forms.label value="Pilih Pinjaman (Anggota)" required="true" />
        <x-forms.dropdown name="pinjaman_id" id="angsuran-pinjaman-id" required>
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
        <x-forms.input type="number" name="angsuran_ke" id="angsuran-ke"
            value="{{ old('angsuran_ke', $angsuran->angsuran_ke ?? '') }}" min="1" required placeholder="Contoh: 1" />
        @error('angsuran_ke')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div>
        <x-forms.label value="Tanggal Pembayaran" required="true" />
        <x-forms.input type="date" name="tanggal_bayar" id="angsuran-tanggal-bayar"
            value="{{ old('tanggal_bayar', isset($angsuran) ? ($angsuran->tanggal_bayar?->format('Y-m-d') ?? '') : date('Y-m-d')) }}" required />
        @error('tanggal_bayar')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
    </div>

    <div class="md:col-span-2 mt-4">
        <h3 class="text-lg font-semibold text-slate-700 border-b border-slate-300 pb-2 mb-2">
            <i class="fa-solid fa-money-bill-transfer text-pink-500 mr-2"></i> Detail Pembayaran
        </h3>
    </div>

    <div class="md:col-span-2">
        <div id="angsuran-preview"
            class="bg-slate-50 border border-slate-200 rounded-lg p-4 text-sm grid grid-cols-2 md:grid-cols-3 gap-3">
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase">Jenis Bunga</p>
                <p class="font-bold text-slate-700" id="preview-jenis-bunga">-</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase">Jatuh Tempo</p>
                <p class="font-bold text-slate-700" id="preview-jatuh-tempo">-</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase">Pokok</p>
                <p class="font-bold text-slate-700" id="preview-pokok">-</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase">Bunga / Jasa</p>
                <p class="font-bold text-slate-700" id="preview-bunga">-</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase">Denda</p>
                <p class="font-bold text-emerald-600"
                    id="preview-denda">Rp 0</p>
            </div>
            <div>
                <p class="text-xs text-slate-500 font-semibold uppercase">Total Bayar</p>
                <p class="font-bold text-slate-800" id="preview-total">-</p>
            </div>
            <p class="col-span-full text-xs text-slate-400 italic" id="preview-keterangan"></p>
        </div>
    </div>

    <div>
        <x-forms.label value="Jumlah Bayar (Rp)" required="true" />
        <x-forms.currency name="jumlah_bayar" id="jumlah-bayar-visible"
            value="{{ old('jumlah_bayar', isset($angsuran) ? round($angsuran->jumlah_bayar) : '') }}" required
            placeholder="0" />
        @error('jumlah_bayar')
            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
        @enderror
        <p class="text-xs text-slate-400 mt-1 italic" id="jumlah-bayar-hint">*Untuk pinjaman dengan skema bunga, nominal
            otomatis sesuai pokok + bunga + denda.</p>
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

@php
    $angSchedule = json_encode($loanScheduleMap ?? new \stdClass());
    $angDenda = $dendaPerHari ?? 5000;
@endphp

@if (isset($loanScheduleMap))
    <script>
        (function() {
            const ANG = {!! $angSchedule !!};
            const DENDA_PER_HARI = {{ $angDenda }};

            const pinjamanSelect = document.getElementById('angsuran-pinjaman-id');
            const keInput = document.getElementById('angsuran-ke');
            const tanggalInput = document.getElementById('angsuran-tanggal-bayar');

            const elJenis = document.getElementById('preview-jenis-bunga');
            const elDue = document.getElementById('preview-jatuh-tempo');
            const elPokok = document.getElementById('preview-pokok');
            const elBunga = document.getElementById('preview-bunga');
            const elDenda = document.getElementById('preview-denda');
            const elTotal = document.getElementById('preview-total');
            const elKeterangan = document.getElementById('preview-keterangan');

            const rupiah = (n) => 'Rp ' + (Math.round(n) || 0).toLocaleString('id-ID');
            const indoDate = (s) => {
                if (!s) return '-';
                const d = new Date(s + 'T00:00:00');
                return d.toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                });
            };
            const diffDays = (a, b) => Math.floor((new Date(b + 'T00:00:00') - new Date(a + 'T00:00:00')) / 86400000);

            function updatePreview() {
                const id = pinjamanSelect.value;
                const ke = parseInt(keInput.value || 0, 10);

                if (!id || !ANG[id]) {
                    resetManual('Pilih pinjaman terlebih dahulu.');
                    return;
                }

                const plan = ANG[id];

                if (!plan.dihitung) {
                    resetManual('Pinjaman ini memakai skema lama tanpa perhitungan bunga otomatis. Isi jumlah bayar secara manual.');
                    return;
                }

                if (ke <= 0) {
                    resetManual('Isi "Angsuran Ke (Bulan)" untuk melihat rincian pokok, bunga, jatuh tempo, dan denda.');
                    return;
                }

                if (ke > plan.tenor) {
                    resetManual('Angsuran ke-' + ke + ' melebihi tenor ' + plan.tenor +
                        ' bulan. Maksimal angsuran ke-' + plan.tenor + '.');
                    return;
                }

                const sch = plan.schedule.find((s) => s.ke === ke);
                if (!sch) {
                    resetManual('Nomor angsuran tidak ditemukan dalam skedul pinjaman (tenor ' + plan.tenor + ' bulan).');
                    return;
                }

                let denda = 0;
                if (tanggalInput.value) {
                    const late = diffDays(sch.tanggal_jatuh_tempo, tanggalInput.value);
                    if (late > 0) denda = late * DENDA_PER_HARI;
                }

                const pokok = sch.jumlah_pokok;
                const bunga = sch.jumlah_bunga;
                const total = pokok + bunga + denda;

                elJenis.textContent = (plan.jenis_bunga === 'menurun' ? 'Menurun (Anuitas)' : 'Flat') + ' ' +
                    parseFloat(plan.persentase) + '%/bln';
                elDue.textContent = indoDate(sch.tanggal_jatuh_tempo);
                elPokok.textContent = rupiah(pokok);
                elBunga.textContent = rupiah(bunga);
                elDenda.textContent = rupiah(denda);
                elDenda.className = 'font-bold ' + (denda > 0 ? 'text-red-600' : 'text-emerald-600');
                elTotal.textContent = rupiah(total);
                elKeterangan.textContent = denda > 0 ?
                    'Keterlambatan ' + diffDays(sch.tanggal_jatuh_tempo, tanggalInput.value) +
                    ' hari dari jatuh tempo; denda dihitung otomatis (Rp ' + DENDA_PER_HARI.toLocaleString('id-ID') +
                    '/hari).' : '';

                // Sinkronkan nilai ke komponen currency / hidden input jumlah_bayar
                setAmountFields(total);
            }

            function resetManual(msg) {
                elJenis.textContent = '-';
                elDue.textContent = '-';
                elPokok.textContent = '-';
                elBunga.textContent = '-';
                elDenda.textContent = 'Rp 0';
                elDenda.className = 'font-bold text-emerald-600';
                elTotal.textContent = '-';
                elKeterangan.textContent = msg || '';
            }

            function setAmountFields(total) {
                const hidden = document.querySelector('input[type="hidden"][name="jumlah_bayar"]');
                const visible = document.querySelector('input[name="jumlah_bayar"]:not([type="hidden"])');

                if (hidden) {
                    hidden.value = String(Math.round(total));
                }

                if (visible && typeof visible.getAttribute('x-model') !== 'undefined') {
                    visible.value = String(Math.round(total));
                    visible.dispatchEvent(new Event('input', { bubbles: true }));
                }
            }

            pinjamanSelect.addEventListener('change', function() {
                if (pinjamanSelect.value && (!keInput.value || parseInt(keInput.value, 10) <= 0)) {
                    keInput.value = '1';
                }
                updatePreview();
            });
            keInput.addEventListener('input', updatePreview);
            tanggalInput.addEventListener('change', updatePreview);

            updatePreview();
        })();
    </script>
@endif