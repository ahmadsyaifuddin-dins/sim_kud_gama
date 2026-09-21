<x-app-layout>
    <x-slot name="header">
        Data Pengajuan Pinjaman
    </x-slot>

    <x-alerts.success />

    <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-pink-600">
        <div class="flex justify-between items-center mb-4">
            <h4 class="text-lg font-semibold text-gray-700">Daftar Pinjaman Anggota</h4>
            <div class="flex gap-2">
                <form action="{{ route('pinjaman.remind-all') }}" method="POST"
                    class="confirm-action" data-swal-title="Cek & Tagih Massal?"
                    data-swal-text="Sistem akan memeriksa semua pinjaman dan mengirim WA ke anggota yang jatuh temponya besok atau yang terlambat."
                    data-swal-icon="question" data-swal-confirm="Ya, Cek & Tagih!" data-swal-color="#2563eb">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition flex items-center gap-2">
                        <i class="fa-solid fa-bullhorn text-sm"></i>
                        Cek & Tagih Massal
                    </button>
                </form>

                <a href="{{ route('pinjaman.create') }}"
                    class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 transition flex items-center gap-2">
                    <i class="fa-solid fa-plus text-sm"></i>
                    Tambah Pengajuan
                </a>
            </div>
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
                        <th class="p-3 font-semibold text-gray-700 text-center">Bunga</th>
                        <th class="p-3 font-semibold text-gray-700 text-right">Angsuran/Bln</th>
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
                                @if ($item->jenis_bunga)
                                    <span
                                        class="px-2 py-1 bg-purple-100 text-purple-800 text-xs font-semibold rounded-full">{{ $item->jenis_bunga === 'flat' ? 'Flat' : 'Menurun' }}
                                        • {{ rtrim(rtrim(number_format($item->persentase_bunga, 2, '.', ''), '0'), '.') }}%</span>
                                @else
                                    <span class="text-gray-400 text-xs">-</span>
                                @endif
                            </td>
                            <td class="p-3 text-right font-medium text-gray-700">
                                @if ($item->jenis_bunga)
                                    {{ number_format(\App\Services\LoanCalculator::angsuranPerBulan($item), 0, ',', '.') }}
                                @else
                                    <span class="text-gray-400">{{ number_format($item->jumlah_pinjaman / $item->lama_angsuran, 0, ',', '.') }}</span>
                                @endif
                            </td>
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
                                <a href="{{ route('pinjaman.edit', $item->id) }}"
                                    class="text-blue-600 hover:text-blue-800 font-medium text-sm" title="Edit Data">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                @php
                                    $showReminder = false;
                                    if ($item->status == 'disetujui' && $item->tanggal_pencairan) {
                                        $tglPencairan = \Carbon\Carbon::parse($item->tanggal_pencairan);
                                        $hariIni = \Carbon\Carbon::now();

                                        // Hitung tanggal jatuh tempo di bulan ini (harinya disamakan dengan hari pencairan)
                                        $jatuhTempoBulanIni = \Carbon\Carbon::createFromDate(
                                            $hariIni->year,
                                            $hariIni->month,
                                            $tglPencairan->day,
                                        );

                                        // Hitung selisih hari. Positif = belum lewat (H-x), Negatif = sudah lewat/menunggak
                                        $selisihHari = $hariIni->diffInDays($jatuhTempoBulanIni, false);

                                        // Tampilkan tombol lonceng jika sudah masuk rentang H-3 sampai H+3 (telat 3 hari)
                                        if ($selisihHari >= -3 && $selisihHari <= 3) {
                                            $showReminder = true;
                                        }
                                    }
                                @endphp

                                @if ($showReminder)
                                    <form action="{{ route('pinjaman.remind', $item->id) }}" method="POST"
                                        class="inline-block confirm-action"
                                        data-swal-title="Kirim Pengingat Tagihan?"
                                        data-swal-text="Kirim pengingat tagihan ke WhatsApp {{ $item->member->nama_lengkap }} sekarang?"
                                        data-swal-icon="info" data-swal-confirm="Ya, Kirim!" data-swal-color="#f97316">
                                        @csrf
                                        <button type="submit"
                                            class="text-orange-500 hover:text-orange-700 font-medium text-sm ml-2 relative group"
                                            title="Jatuh tempo sudah dekat! Kirim pengingat (Manual)">
                                            <i class="fa-solid fa-bell"></i>
                                            <span
                                                class="absolute -top-1 -right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                                        </button>
                                    </form>
                                @endif

                                @if ($item->status == 'menunggu')
                                    <form action="{{ route('pinjaman.update-status', $item->id) }}" method="POST"
                                        class="inline-block confirm-action"
                                        data-swal-title="Setujui Pinjaman?"
                                        data-swal-text="Setujui pinjaman {{ $item->member->nama_lengkap }} dan kirim notifikasi WhatsApp?"
                                        data-swal-icon="question" data-swal-confirm="Ya, Setujui!" data-swal-color="#16a34a">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="disetujui">
                                        <button type="submit"
                                            class="text-green-600 hover:text-green-800 font-medium text-sm ml-2"
                                            title="Setujui & Kirim WA">
                                            <i class="fa-solid fa-check-circle"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('pinjaman.update-status', $item->id) }}" method="POST"
                                        class="inline-block confirm-action"
                                        data-swal-title="Tolak Pinjaman?"
                                        data-swal-text="Tolak pinjaman {{ $item->member->nama_lengkap }} dan kirim notifikasi WhatsApp?"
                                        data-swal-icon="warning" data-swal-confirm="Ya, Tolak!" data-swal-color="#dc2626">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="ditolak">
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 font-medium text-sm ml-2"
                                            title="Tolak & Kirim WA">
                                            <i class="fa-solid fa-times-circle"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="p-6 text-center text-gray-500">Belum ada data pengajuan pinjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
