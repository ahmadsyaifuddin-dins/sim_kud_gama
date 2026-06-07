<x-app-layout>
    <x-slot name="header">
        {{ __('Data Pembayaran Angsuran') }}
    </x-slot>

    <x-alerts.success />

    <div class="bg-white rounded-lg shadow-md border-t-4 border-pink-600 overflow-hidden">

        <div class="flex flex-col md:flex-row justify-between items-center p-6 border-b border-slate-100 bg-white gap-4">
            <h4 class="text-lg font-bold text-slate-800">
                <i class="fa-solid fa-list-check text-pink-500 mr-2"></i> Riwayat Angsuran Anggota
            </h4>
            <a href="{{ route('angsuran.create') }}"
                class="inline-flex items-center px-4 py-2 bg-pink-600 text-white text-sm font-semibold rounded-md hover:bg-pink-700 focus:ring-4 focus:ring-pink-300 transition shadow-sm">
                <i class="fa-solid fa-plus mr-2"></i> Input Angsuran
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200 text-slate-600 text-xs uppercase tracking-wider">
                        <th class="p-4 font-bold w-12 text-center">No</th>
                        <th class="p-4 font-bold">Anggota (Pinjaman)</th>
                        <th class="p-4 font-bold text-center">Angsuran Ke</th>
                        <th class="p-4 font-bold">Tanggal Bayar</th>
                        <th class="p-4 font-bold text-right">Jumlah (Rp)</th>
                        <th class="p-4 font-bold text-center">Bukti</th>
                        <th class="p-4 font-bold text-center w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($angsurans as $index => $item)
                        <tr class="border-b border-slate-100 hover:bg-slate-50 transition duration-150">
                            <td class="p-4 text-center text-slate-500 font-medium">{{ $index + 1 }}</td>
                            <td class="p-4">
                                <div class="font-bold text-slate-800">{{ $item->pinjaman->member->nama_lengkap }}</div>
                                <div class="text-xs text-slate-500 mt-0.5">
                                    <i class="fa-solid fa-hashtag text-slate-400 mr-1"></i>ID Pinjam:
                                    {{ $item->pinjaman_id }}
                                </div>
                            </td>
                            <td class="p-4 text-center">
                                <span
                                    class="inline-flex items-center justify-center px-2.5 py-1 text-xs font-bold bg-pink-100 text-pink-700 rounded-full">
                                    Bulan {{ $item->angsuran_ke }}
                                </span>
                            </td>
                            <td class="p-4 text-slate-700 font-medium">
                                <i class="fa-regular fa-calendar-days text-slate-400 mr-1"></i>
                                {{ \Carbon\Carbon::parse($item->tanggal_bayar)->translatedFormat('d M Y') }}
                            </td>
                            <td class="p-4 text-right font-bold text-slate-800">
                                {{ number_format($item->jumlah_bayar, 0, ',', '.') }}
                            </td>
                            <td class="p-4 text-center">
                                @if ($item->bukti_bayar)
                                    <a href="{{ asset($item->bukti_bayar) }}" target="_blank"
                                        class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 rounded-md hover:bg-blue-100 transition"
                                        title="Lihat Bukti Transfer">
                                        <i class="fa-solid fa-image mr-1.5"></i> Lihat
                                    </a>
                                @else
                                    <span
                                        class="inline-flex items-center justify-center px-3 py-1.5 text-xs font-medium text-slate-500 bg-slate-100 rounded-md">
                                        <i class="fa-solid fa-minus"></i>
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('angsuran.edit', $item->id) }}"
                                        class="w-8 h-8 flex items-center justify-center text-blue-600 bg-blue-50 rounded-md hover:bg-blue-600 hover:text-white transition shadow-sm"
                                        title="Edit Data">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('angsuran.destroy', $item->id) }}" method="POST"
                                        class="inline-block confirm-action" data-swal-title="Hapus Data Angsuran?"
                                        data-swal-text="Yakin ingin menghapus angsuran ke-{{ $item->angsuran_ke }} dari {{ $item->pinjaman->member->nama_lengkap }}?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-8 h-8 flex items-center justify-center text-red-600 bg-red-50 rounded-md hover:bg-red-600 hover:text-white transition shadow-sm"
                                            title="Hapus Data">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-400">
                                    <i class="fa-solid fa-folder-open text-5xl mb-3 text-slate-300"></i>
                                    <p class="text-slate-500 font-medium">Belum ada data pembayaran angsuran.</p>
                                    <p class="text-sm mt-1">Silakan klik "Input Angsuran" untuk menambahkan data baru.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
