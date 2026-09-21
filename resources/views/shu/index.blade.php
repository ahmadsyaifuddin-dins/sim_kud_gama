<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-scale-balanced text-pink-600"></i>
            {{ __('Pembagian SHU (Sisa Hasil Usaha)') }}
        </div>
    </x-slot>

    <x-alerts.success />
    <x-alerts.error />

    <div class="mb-6 flex justify-end">
        <a href="{{ route('shu.create') }}"
            class="inline-flex items-center px-4 py-2 bg-pink-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-pink-700 active:bg-pink-900 focus:outline-none focus:border-pink-900 focus:ring ring-pink-300 disabled:opacity-25 transition ease-in-out duration-150 shadow-sm">
            <i class="fa-solid fa-calculator mr-2"></i> Kalkulasi SHU Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-base font-extrabold text-gray-700 flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-pink-500"></i> Riwayat Kalkulasi SHU
            </h3>
        </div>

        @if ($distributions->isEmpty())
            <p class="px-6 py-12 text-center text-gray-500">
                Belum ada kalkulasi SHU. Klik "Kalkulasi SHU Baru" untuk membagi SHU di akhir periode.
            </p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b border-gray-200">
                            <th class="p-4 font-semibold text-gray-700">Periode</th>
                            <th class="p-4 font-semibold text-gray-700 text-right">Total SHU</th>
                            <th class="p-4 font-semibold text-gray-700 text-center">Alokasi</th>
                            <th class="p-4 font-semibold text-gray-700 text-right">Jasa Modal</th>
                            <th class="p-4 font-semibold text-gray-700 text-right">Jasa Transaksi</th>
                            <th class="p-4 font-semibold text-gray-700 text-right">Cadangan</th>
                            <th class="p-4 font-semibold text-gray-700 text-center">Anggota</th>
                            <th class="p-4 font-semibold text-gray-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($distributions as $dist)
                            <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                                <td class="p-4">
                                    <p class="font-bold text-gray-800">{{ $dist->label }}</p>
                                    <p class="text-xs text-gray-500">
                                        {{ $dist->calculated_at?->translatedFormat('d M Y H:i') }} • oleh
                                        {{ $dist->creator?->name ?? '-' }}
                                    </p>
                                </td>
                                <td class="p-4 text-right font-bold text-gray-800">
                                    {{ number_format($dist->total_shu, 0, ',', '.') }}
                                </td>
                                <td class="p-4 text-center text-xs text-gray-600">
                                    {{ number_format($dist->jasa_modal_persen, 1, ',', '.') }}% +
                                    {{ number_format($dist->jasa_transaksi_persen, 1, ',', '.') }}% +
                                    {{ number_format($dist->cadangan_persen, 1, ',', '.') }}%
                                </td>
                                <td class="p-4 text-right text-gray-700">{{ number_format($dist->total_jasa_modal, 0, ',', '.') }}</td>
                                <td class="p-4 text-right text-gray-700">{{ number_format($dist->total_jasa_transaksi, 0, ',', '.') }}</td>
                                <td class="p-4 text-right text-gray-700">{{ number_format($dist->total_cadangan, 0, ',', '.') }}</td>
                                <td class="p-4 text-center font-semibold text-gray-600">{{ $dist->total_member }} org</td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('shu.show', $dist->id) }}"
                                            class="px-3 py-1.5 text-xs font-semibold text-blue-700 bg-blue-50 rounded-md hover:bg-blue-100 transition"
                                            title="Lihat Rincian">
                                            <i class="fa-solid fa-eye mr-1"></i> Rincian
                                        </a>
                                        <a href="{{ route('shu.pdf', $dist->id) }}" target="_blank"
                                            class="px-3 py-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 rounded-md hover:bg-emerald-100 transition"
                                            title="Cetak PDF">
                                            <i class="fa-solid fa-file-pdf mr-1"></i> PDF
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>