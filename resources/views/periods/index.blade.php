<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-lock text-pink-600"></i>
            {{ __('Tutup Buku & Periode') }}
        </div>
    </x-slot>

    <x-alerts.success />
    <x-alerts.error />

    <div class="grid gap-6 lg:grid-cols-2">

        {{-- Form Menutup Periode --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex items-center gap-3 bg-gradient-to-r from-pink-50 to-transparent">
                <div
                    class="w-11 h-11 flex items-center justify-center rounded-xl bg-gradient-to-br from-pink-400 to-rose-600 text-white shadow-lg shadow-pink-200">
                    <i class="fa-solid fa-calendar-xmark text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-extrabold text-gray-700">Tutup Buku Periode</h3>
                    <p class="text-xs text-gray-500 font-semibold">Kunci transaksi agar tidak bisa diubah/dihapus</p>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-800 p-3 rounded text-xs leading-relaxed">
                    <i class="fa-solid fa-circle-info mr-1"></i>
                    Saat sebuah periode ditutup, seluruh transaksi kas (simpanan, angsuran, dan pinjaman) di dalam
                    rentang tanggal tersebut menjadi <strong>read-only</strong> untuk mencegah manipulasi data yang
                    sudah diaudit.
                </div>

                {{-- Tutup Bulanan --}}
                <form action="{{ route('periods.store') }}" method="POST" class="space-y-3">
                    @csrf
                    <input type="hidden" name="type" value="monthly">
                    <x-forms.label value="Tutup Buku Bulanan (Pilih Bulan)" />
                    <select name="period_key" required
                        class="border-gray-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm w-full">
                        <option value="" disabled selected>-- Pilih Bulan yang Belum Ditutup --</option>
                        @foreach ($availableMonthly as $m)
                            <option value="{{ $m['key'] }}">{{ $m['label'] }}</option>
                        @endforeach
                    </select>
                    @if (count($availableMonthly) === 0)
                        <p class="text-xs text-gray-500">Semua bulan yang memiliki transaksi sudah ditutup.</p>
                    @endif
                    <x-forms.input type="text" name="note" placeholder="Catatan (opsional)" />
                    <button type="submit"
                        class="w-full px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 transition font-semibold text-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-lock"></i> Kunci Bulan Terpilih
                    </button>
                </form>

                {{-- Tutup Tahunan --}}
                <form action="{{ route('periods.store') }}" method="POST" class="space-y-3 pt-4 border-t border-gray-100">
                    @csrf
                    <input type="hidden" name="type" value="yearly">
                    <x-forms.label value="Tutup Buku Tahunan (Pilih Tahun)" />
                    <select name="period_key" required
                        class="border-gray-300 focus:border-pink-500 focus:ring-pink-500 rounded-md shadow-sm w-full">
                        <option value="" disabled selected>-- Pilih Tahun yang Belum Ditutup --</option>
                        @foreach ($availableYearly as $y)
                            <option value="{{ $y['key'] }}">{{ $y['label'] }}</option>
                        @endforeach
                    </select>
                    @if (count($availableYearly) === 0)
                        <p class="text-xs text-gray-500">Semua tahun yang memiliki transaksi sudah ditutup.</p>
                    @endif
                    <x-forms.input type="text" name="note" placeholder="Catatan (opsional)" />
                    <button type="submit"
                        class="w-full px-4 py-2 bg-violet-600 text-white rounded-md hover:bg-violet-700 transition font-semibold text-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-lock"></i> Kunci Tahun Terpilih
                    </button>
                </form>
            </div>
        </div>

        {{-- Riwayat Penutupan --}}
        <div class="space-y-6">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-base font-extrabold text-gray-700 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-days text-pink-500"></i> Periode Bulanan Ditutup
                    </h3>
                </div>
                <div class="divide-y divide-gray-100 max-h-72 overflow-y-auto">
                    @forelse ($monthlyClosures as $closure)
                        <div class="px-6 py-3 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 flex-shrink-0 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-700">{{ $closure->label }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $closure->start_date->translatedFormat('d M Y') }} s/d
                                        {{ $closure->end_date->translatedFormat('d M Y') }}
                                        @if ($closure->note)
                                            • {{ $closure->note }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-400">Ditutup oleh
                                    {{ $closure->approver?->name ?? '-' }}</p>
                                <form action="{{ route('periods.destroy', $closure->id) }}" method="POST"
                                    class="inline-block confirm-action"
                                    data-swal-title="Buka Periode {{ $closure->label }}?"
                                    data-swal-text="Periode akan dapat diproses transaksinya kembali.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-xs text-amber-600 hover:text-amber-800 font-semibold mt-1">
                                        <i class="fa-solid fa-unlock mr-1"></i>Buka Kembali
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="px-6 py-6 text-sm text-gray-500 text-center">Belum ada periode bulanan yang ditutup.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="text-base font-extrabold text-gray-700 flex items-center gap-2">
                        <i class="fa-solid fa-calendar-week text-violet-500"></i> Periode Tahunan Ditutup
                    </h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse ($yearlyClosures as $closure)
                        <div class="px-6 py-3 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 flex-shrink-0 flex items-center justify-center rounded-lg bg-violet-100 text-violet-600">
                                    <i class="fa-solid fa-lock text-sm"></i>
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-gray-700">Tahun Buku {{ $closure->label }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $closure->start_date->translatedFormat('d M Y') }} s/d
                                        {{ $closure->end_date->translatedFormat('d M Y') }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-[10px] text-gray-400">Ditutup oleh
                                    {{ $closure->approver?->name ?? '-' }}</p>
                                <form action="{{ route('periods.destroy', $closure->id) }}" method="POST"
                                    class="inline-block confirm-action"
                                    data-swal-title="Buka Tahun Buku {{ $closure->label }}?"
                                    data-swal-text="Periode akan dapat diproses transaksinya kembali.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-xs text-amber-600 hover:text-amber-800 font-semibold mt-1">
                                        <i class="fa-solid fa-unlock mr-1"></i>Buka Kembali
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <p class="px-6 py-6 text-sm text-gray-500 text-center">Belum ada periode tahunan yang ditutup.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>