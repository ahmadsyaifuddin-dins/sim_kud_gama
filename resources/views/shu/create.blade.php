<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-calculator text-pink-600"></i>
            {{ __('Kalkulasi Pembagian SHU') }}
        </div>
    </x-slot>

    <x-alerts.success />
    <x-alerts.error />

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3 bg-gradient-to-r from-violet-50 to-transparent">
            <div
                class="w-11 h-11 flex items-center justify-center rounded-xl bg-gradient-to-br from-violet-400 to-purple-600 text-white shadow-lg shadow-purple-200">
                <i class="fa-solid fa-scale-balanced text-xl"></i>
            </div>
            <div>
                <h3 class="text-lg font-extrabold text-gray-700">Kalkulasi Otomatis Pembagian SHU</h3>
                <p class="text-xs text-gray-500 font-semibold">Jasa Usaha/Modal • Jasa Transaksi/Pinjaman • Cadangan</p>
            </div>
        </div>

        @if (count($availableYears) === 0)
            <div class="p-10 text-center">
                <i class="fa-solid fa-circle-info text-4xl text-gray-300 mb-3"></i>
                <p class="text-gray-500 font-medium">Tidak ada tahun buku yang tersedia untuk dikalkulasi.</p>
                <p class="text-sm text-gray-400 mt-1">Semua tahun yang memiliki transaksi sudah pernah dibuatkan pembagian SHU.</p>
                <a href="{{ route('shu.index') }}" class="inline-block mt-4 px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition text-sm font-semibold">Kembali ke Riwayat</a>
            </div>
        @else
            <form action="{{ route('shu.store') }}" method="POST" class="p-6 space-y-5">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <x-forms.label value="Tahun Buku" required="true" />
                        <x-forms.dropdown name="tahun" required>
                            <option value="" disabled selected>-- Pilih Tahun --</option>
                            @foreach ($availableYears as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach
                        </x-forms.dropdown>
                        @error('tahun')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <div>
                        <x-forms.label value="Total SHU yang Dibagikan (Rp)" required="true" />
                        <x-forms.currency name="total_shu" value="{{ old('total_shu') }}" placeholder="0" required />
                        @error('total_shu')
                            <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="bg-violet-50 border border-violet-200 rounded-lg p-4 text-xs text-violet-800 leading-relaxed">
                    <i class="fa-solid fa-circle-info mr-1"></i>
                    <strong>Kalkulasi otomatis:</strong> Jasa Usaha/Modal dibagi proporsional terhadap akumulasi
                    simpanan anggota (modal), sedangkan Jasa Transaksi dibagi proporsional terhadap keaktifan
                    perputaran transaksi anggota (angsuran terbayar + simpanan disetor) pada periode tersebut.
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <x-forms.label value="Jasa Usaha / Modal (%)" required="true" />
                        <x-forms.input type="number" step="0.01" min="0" max="100" name="jasa_modal_persen"
                            value="{{ old('jasa_modal_persen', $defaults['jasa_modal_persen']) }}" required />
                    </div>
                    <div>
                        <x-forms.label value="Jasa Transaksi / Pinjaman (%)" required="true" />
                        <x-forms.input type="number" step="0.01" min="0" max="100" name="jasa_transaksi_persen"
                            value="{{ old('jasa_transaksi_persen', $defaults['jasa_transaksi_persen']) }}" required />
                    </div>
                    <div>
                        <x-forms.label value="Cadangan Koperasi (%)" required="true" />
                        <x-forms.input type="number" step="0.01" min="0" max="100" name="cadangan_persen"
                            value="{{ old('cadangan_persen', $defaults['cadangan_persen']) }}" required />
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <span class="text-sm font-semibold text-gray-600">Total Alokasi:</span>
                    <span id="shu-sum-badge" class="px-3 py-1 rounded-full text-sm font-bold bg-emerald-100 text-emerald-700">100%</span>
                    <span id="shu-sum-hint" class="text-xs text-gray-500 italic">Harus tepat 100%.</span>
                </div>
                @error('cadangan_persen')
                    <span class="text-xs text-red-600 block">{{ $message }}</span>
                @enderror

                <div>
                    <x-forms.label value="Catatan (Opsional)" />
                    <x-forms.input type="text" name="note" value="{{ old('note') }}" placeholder="Contoh: Putusan RAT, alokasi sesuai pasal..." />
                </div>

                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('shu.index') }}"
                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition font-semibold text-sm">Batal</a>
                    <button type="submit"
                        class="px-5 py-2 bg-violet-600 text-white rounded-md hover:bg-violet-700 transition font-semibold text-sm flex items-center gap-2">
                        <i class="fa-solid fa-calculator"></i> Hitung & Simpan
                    </button>
                </div>
            </form>
        @endif
    </div>

    <script>
        (function() {
            const inputNames = ['jasa_modal_persen', 'jasa_transaksi_persen', 'cadangan_persen'];
            const badge = document.getElementById('shu-sum-badge');
            const hint = document.getElementById('shu-sum-hint');

            function update() {
                let total = 0;
                inputNames.forEach(function(name) {
                    const el = document.querySelector('input[name="' + name + '"]');
                    if (el) total += parseFloat(el.value || 0);
                });
                const ok = Math.abs(total - 100) < 0.01;
                badge.textContent = total.toLocaleString('id-ID') + '%';
                badge.className = 'px-3 py-1 rounded-full text-sm font-bold ' +
                    (ok ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700');
                hint.textContent = ok ? 'Harus tepat 100%.' : 'Kurang/lebih ' + (total - 100).toLocaleString('id-ID') + '%.';
            }

            document.querySelectorAll('input[name^="jasa_"], input[name="cadangan_persen"]').forEach(function(el) {
                el.addEventListener('input', update);
            });
            update();
        })();
    </script>
</x-app-layout>