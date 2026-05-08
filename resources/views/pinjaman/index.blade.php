<x-app-layout>
    <x-slot name="header">
        Data Pengajuan Pinjaman
    </x-slot>

    <x-alerts.success />

    <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-pink-600">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-lg font-semibold text-gray-700">Daftar Pinjaman Anggota</h4>
            <a href="{{ route('pinjaman.create') }}"
                class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 transition flex items-center gap-2">
                <!-- Menggunakan Font Awesome sesuai request -->
                <i class="fa-solid fa-plus text-sm"></i>
                Tambah Pengajuan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="p-3 font-semibold text-gray-700">No</th>
                        <th class="p-3 font-semibold text-gray-700">Anggota</th>
                        <th class="p-3 font-semibold text-gray-700">Tanggal</th>
                        <th class="p-3 font-semibold text-gray-700 text-right">Jumlah (Rp)</th>
                        <th class="p-3 font-semibold text-gray-700 text-center">Tenor</th>
                        <th class="p-3 font-semibold text-gray-700 text-center">Status</th>
                        <th class="p-3 font-semibold text-gray-700 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pinjamans as $index => $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                            <td class="p-3">{{ $index + 1 }}</td>
                            <td class="p-3">
                                <div class="font-semibold text-gray-800">{{ $item->member->nama_lengkap }}</div>
                                <div class="text-sm text-gray-500">{{ $item->member->nomor_anggota }}</div>
                            </td>
                            <td class="p-3">
                                {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d M Y') }}
                            </td>
                            <td class="p-3 text-right font-medium text-gray-700">
                                {{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}
                            </td>
                            <td class="p-3 text-center">{{ $item->lama_angsuran }} Bln</td>
                            <td class="p-3 text-center">
                                @if ($item->status == 'menunggu')
                                    <span
                                        class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs font-semibold rounded-full">Menunggu</span>
                                @elseif($item->status == 'disetujui')
                                    <span
                                        class="px-2 py-1 bg-blue-100 text-blue-800 text-xs font-semibold rounded-full">Disetujui</span>
                                @elseif($item->status == 'ditolak')
                                    <span
                                        class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">Ditolak</span>
                                @else
                                    <span
                                        class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">Lunas</span>
                                @endif
                            </td>

                            <!-- Kolom Aksi -->
                            <td class="p-3 text-center space-x-3">
                                <!-- Tombol Edit (Selalu Muncul) -->
                                <a href="{{ route('pinjaman.edit', $item->id) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium text-sm" title="Edit Data">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <!-- Tombol Aksi Cepat WA (Hanya muncul jika status 'menunggu') -->
                                @if ($item->status == 'menunggu')
                                    <!-- Tombol Setujui -->
                                    <form action="{{ route('pinjaman.update-status', $item->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Setujui pinjaman ini dan kirim notifikasi WhatsApp ke anggota?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="disetujui">
                                        <button type="submit"
                                            class="text-green-600 hover:text-green-800 font-medium text-sm"
                                            title="Setujui & Kirim WA">
                                            <i class="fa-solid fa-check-circle"></i>
                                        </button>
                                    </form>

                                    <!-- Tombol Tolak -->
                                    <form action="{{ route('pinjaman.update-status', $item->id) }}" method="POST"
                                        class="inline-block"
                                        onsubmit="return confirm('Tolak pinjaman ini dan kirim notifikasi WhatsApp ke anggota?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="ditolak">
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 font-medium text-sm"
                                            title="Tolak & Kirim WA">
                                            <i class="fa-solid fa-times-circle"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-6 text-center text-gray-500">Belum ada data pengajuan pinjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
