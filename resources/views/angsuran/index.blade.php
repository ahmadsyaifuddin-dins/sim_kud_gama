<x-app-layout>
    <x-slot name="header">
        Data Pembayaran Angsuran
    </x-slot>

    <x-alerts.success />

    <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-pink-600">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-lg font-semibold text-gray-700">Riwayat Angsuran Anggota</h4>
            <a href="{{ route('angsuran.create') }}"
                class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 transition flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Input Angsuran
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="p-3 font-semibold text-gray-700">No</th>
                        <th class="p-3 font-semibold text-gray-700">Anggota (Pinjaman)</th>
                        <th class="p-3 font-semibold text-gray-700 text-center">Angsuran Ke</th>
                        <th class="p-3 font-semibold text-gray-700">Tanggal Bayar</th>
                        <th class="p-3 font-semibold text-gray-700 text-right">Jumlah (Rp)</th>
                        <th class="p-3 font-semibold text-gray-700 text-center">Bukti</th>
                        <th class="p-3 font-semibold text-gray-700 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($angsurans as $index => $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="p-3">{{ $index + 1 }}</td>
                            <td class="p-3">
                                <div class="font-semibold text-gray-800">{{ $item->pinjaman->member->nama_lengkap }}
                                </div>
                                <div class="text-sm text-gray-500">ID Pinjam: #{{ $item->pinjaman_id }}</div>
                            </td>
                            <td class="p-3 text-center font-bold text-pink-600">{{ $item->angsuran_ke }}</td>
                            <td class="p-3">
                                {{ \Carbon\Carbon::parse($item->tanggal_bayar)->translatedFormat('d M Y') }}</td>
                            <td class="p-3 text-right font-medium text-gray-700">
                                {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                            <td class="p-3 text-center">
                                @if ($item->bukti_bayar)
                                    <a href="{{ asset($item->bukti_bayar) }}" target="_blank"
                                        class="text-blue-500 hover:underline text-sm flex items-center justify-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                        Lihat
                                    </a>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="p-3 text-center">
                                <a href="{{ route('angsuran.edit', $item->id) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium text-sm">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-500">Belum ada data pembayaran angsuran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
