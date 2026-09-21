<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-sliders text-pink-600"></i>
            {{ __('Kebijakan Pinjaman & Pembagian SHU') }}
        </div>
    </x-slot>

    <x-alerts.success />
    <x-alerts.error />

    <form action="{{ route('settings.update') }}" method="POST">
        @csrf

        <div class="grid gap-6 lg:grid-cols-2">

            {{-- Kebijakan Pinjaman --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3 bg-gradient-to-r from-pink-50 to-transparent">
                    <div
                        class="w-11 h-11 flex items-center justify-center rounded-xl bg-gradient-to-br from-pink-400 to-rose-600 text-white shadow-lg shadow-pink-200">
                        <i class="fa-solid fa-hand-holding-dollar text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-700">Kebijakan Pinjaman</h3>
                        <p class="text-xs text-gray-500 font-semibold">Plafond, bunga default, dan denda keterlambatan</p>
                    </div>
                </div>

                <div class="p-6 space-y-5">
                    <div>
                        <x-forms.label value="Plafond per Hektar Lahan Sawit (Rp)" />
                        <x-forms.currency name="plafond_per_hektar"
                            value="{{ round($settings['plafond_per_hektar']) }}" placeholder="10000000" required />
                        <p class="text-xs text-gray-500 mt-1">Batas pinjaman dari lahan = luas lahan (Ha) × nilai ini.</p>
                    </div>

                    <div>
                        <x-forms.label value="Pengali Saldo Simpanan Pokok + Wajib" />
                        <x-forms.input type="number" step="0.5" min="1" name="plafond_multiplier_simpanan"
                            value="{{ $settings['plafond_multiplier_simpanan'] }}" required />
                        <p class="text-xs text-gray-500 mt-1">Batas pinjaman dari simpanan = saldo (P+W) × nilai ini.</p>
                    </div>

                    <div>
                        <x-forms.label value="Jenis Bunga Default" />
                        <div class="mt-2 flex gap-6">
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="default_jenis_bunga" value="flat"
                                    class="text-pink-600 focus:ring-pink-500 h-5 w-5 cursor-pointer"
                                    {{ $settings['default_jenis_bunga'] === 'flat' ? 'checked' : '' }} required>
                                <span class="ml-2 text-sm text-gray-700 font-semibold">Bunga Flat / Tetap</span>
                            </label>
                            <label class="inline-flex items-center cursor-pointer">
                                <input type="radio" name="default_jenis_bunga" value="menurun"
                                    class="text-pink-600 focus:ring-pink-500 h-5 w-5 cursor-pointer"
                                    {{ $settings['default_jenis_bunga'] === 'menurun' ? 'checked' : '' }} required>
                                <span class="ml-2 text-sm text-gray-700 font-semibold">Bunga Menurun (Anuitas)</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <x-forms.label value="Persentase Jasa per Bulan Default (%)" />
                        <x-forms.input type="number" step="0.01" min="0" max="12" name="default_persentase_bunga"
                            value="{{ $settings['default_persentase_bunga'] }}" required />
                    </div>

                    <div>
                        <x-forms.label value="Tarif Denda per Hari Keterlambatan (Rp)" />
                        <x-forms.currency name="denda_per_hari" value="{{ round($settings['denda_per_hari']) }}"
                            placeholder="5000" required />
                        <p class="text-xs text-gray-500 mt-1">Denda otomatis = jumlah hari telat × tarif ini.</p>
                    </div>
                </div>
            </div>

            {{-- Pembagian SHU --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3 bg-gradient-to-r from-violet-50 to-transparent">
                    <div
                        class="w-11 h-11 flex items-center justify-center rounded-xl bg-gradient-to-br from-violet-400 to-purple-600 text-white shadow-lg shadow-purple-200">
                        <i class="fa-solid fa-scale-balanced text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-700">Pembagian SHU</h3>
                        <p class="text-xs text-gray-500 font-semibold">Persentase alokasi harus total 100%</p>
                    </div>
                </div>

                <div class="p-6 space-y-5">
                    <div>
                        <x-forms.label value="Jasa Usaha / Modal (%)" />
                        <x-forms.input type="number" step="0.01" min="0" max="100" name="shu_jasa_modal_persen"
                            value="{{ $settings['shu_jasa_modal_persen'] }}" required />
                        <p class="text-xs text-gray-500 mt-1">Proporsional terhadap simpanan (modal) anggota.</p>
                    </div>

                    <div>
                        <x-forms.label value="Jasa Transaksi / Pinjaman (%)" />
                        <x-forms.input type="number" step="0.01" min="0" max="100" name="shu_jasa_transaksi_persen"
                            value="{{ $settings['shu_jasa_transaksi_persen'] }}" required />
                        <p class="text-xs text-gray-500 mt-1">Proporsional terhadap keaktifan transaksi anggota.</p>
                    </div>

                    <div>
                        <x-forms.label value="Cadangan Koperasi (%)" />
                        <x-forms.input type="number" step="0.01" min="0" max="100" name="shu_cadangan_persen"
                            value="{{ $settings['shu_cadangan_persen'] }}" required />
                    </div>

                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-600">Total Alokasi</span>
                            <span id="shu-total-badge"
                                class="px-3 py-1 rounded-full text-sm font-bold bg-emerald-100 text-emerald-700">100%</span>
                        </div>
                        <p id="shu-total-hint" class="text-xs text-gray-500 mt-1 italic">Total persentase harus tepat 100%.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button type="submit"
                class="px-6 py-2.5 bg-pink-600 text-white rounded-md hover:bg-pink-700 transition font-semibold text-sm flex items-center gap-2">
                <i class="fa-solid fa-save"></i> Simpan Pengaturan
            </button>
        </div>
    </form>

    @include('partials._glossary_accordion', [
        'glossaryTitle' => 'Kamus Istilah Kebijakan',
        'glossarySubtitle' => 'SHU, Plafond, Bunga Default & Denda — klik masing-masing untuk penjelasan',
    ])

    <script>
        (function() {
            const inputs = document.querySelectorAll('input[name^="shu_"]');
            const badge = document.getElementById('shu-total-badge');
            const hint = document.getElementById('shu-total-hint');

            function update() {
                let total = 0;
                inputs.forEach(function(el) {
                    total += parseFloat(el.value || 0);
                });
                const ok = Math.abs(total - 100) < 0.01;
                badge.textContent = total.toLocaleString('id-ID') + '%';
                badge.className = 'px-3 py-1 rounded-full text-sm font-bold ' +
                    (ok ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700');
                hint.textContent = ok ?
                    'Total persentase tepat 100%.' :
                    'Total persentase belum 100% (kurang/lebih ' + (total - 100).toLocaleString('id-ID') + '%).';
            }

            inputs.forEach(function(el) {
                el.addEventListener('input', update);
            });
            update();
        })();
    </script>
</x-app-layout>