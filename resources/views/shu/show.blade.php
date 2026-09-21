<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-file-invoice text-pink-600"></i>
            {{ __('Rincian Pembagian SHU') }}
        </div>
    </x-slot>

    <x-alerts.success />
    <x-alerts.error />

    <div class="grid gap-6 lg:grid-cols-4 mb-6">

        <div
            class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 transition-all overflow-hidden">
            <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Total SHU Dibagikan</p>
            <h4 class="text-2xl font-black text-gray-800">Rp {{ number_format($distribution->total_shu, 0, ',', '.') }}</h4>
            <p class="text-[10px] text-gray-400 font-semibold mt-1">{{ $distribution->label }}</p>
        </div>

        <div class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Jasa Usaha / Modal</p>
            <h4 class="text-2xl font-black text-emerald-600">Rp {{ number_format($distribution->total_jasa_modal, 0, ',', '.') }}</h4>
            <p class="text-[10px] text-gray-400 font-semibold mt-1">{{ rtrim(rtrim(number_format($distribution->jasa_modal_persen, 1, ',', '.'), '0'), ',') }}% dari total SHU</p>
        </div>

        <div class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Jasa Transaksi</p>
            <h4 class="text-2xl font-black text-blue-600">Rp {{ number_format($distribution->total_jasa_transaksi, 0, ',', '.') }}</h4>
            <p class="text-[10px] text-gray-400 font-semibold mt-1">{{ rtrim(rtrim(number_format($distribution->jasa_transaksi_persen, 1, ',', '.'), '0'), ',') }}% dari total SHU</p>
        </div>

        <div class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Cadangan</p>
            <h4 class="text-2xl font-black text-amber-600">Rp {{ number_format($distribution->total_cadangan, 0, ',', '.') }}</h4>
            <p class="text-[10px] text-gray-400 font-semibold mt-1">{{ rtrim(rtrim(number_format($distribution->cadangan_persen, 1, ',', '.'), '0'), ',') }}% untuk cadangan koperasi</p>
        </div>

    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between gap-4">
            <h3 class="text-base font-extrabold text-gray-700 flex items-center gap-2">
                <i class="fa-solid fa-users text-pink-500"></i> Rincian per Anggota
                <span
                    class="px-2 py-0.5 bg-pink-100 text-pink-700 text-xs font-bold rounded-full">{{ $distribution->total_member }} anggota</span>
            </h3>
            <a href="{{ route('shu.pdf', $distribution->id) }}" target="_blank"
                class="inline-flex items-center px-4 py-2 bg-emerald-600 text-white text-xs font-semibold rounded-md hover:bg-emerald-700 transition shadow-sm">
                <i class="fa-solid fa-file-pdf mr-2"></i> Cetak PDF
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200 text-xs uppercase tracking-wider text-gray-600">
                        <th class="p-4 font-bold w-12 text-center">No</th>
                        <th class="p-4 font-bold">Anggota</th>
                        <th class="p-4 font-bold text-right">Simpanan (Modal)</th>
                        <th class="p-4 font-bold text-right">Jasa Modal</th>
                        <th class="p-4 font-bold text-right">Transaksi</th>
                        <th class="p-4 font-bold text-right">Jasa Transaksi</th>
                        <th class="p-4 font-bold text-right">Total SHU</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($distribution->memberDistributions as $index => $row)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="p-4 text-center text-gray-500">{{ $index + 1 }}</td>
                            <td class="p-4">
                                <div class="font-bold text-gray-800">{{ $row->member->nama_lengkap }}</div>
                                <div class="text-xs text-gray-500">{{ $row->member->nomor_anggota }}</div>
                            </td>
                            <td class="p-4 text-right text-gray-700">{{ number_format($row->saldo_simpanan, 0, ',', '.') }}</td>
                            <td class="p-4 text-right font-semibold text-emerald-700">{{ number_format($row->jasa_modal, 0, ',', '.') }}</td>
                            <td class="p-4 text-right text-gray-700">{{ number_format($row->total_transaksi, 0, ',', '.') }}</td>
                            <td class="p-4 text-right font-semibold text-blue-700">{{ number_format($row->jasa_transaksi, 0, ',', '.') }}</td>
                            <td class="p-4 text-right font-black text-gray-800">{{ number_format($row->total_shu, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-8 text-center text-gray-500">Tidak ada data anggota.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>