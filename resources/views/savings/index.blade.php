<x-app-layout>
    <x-slot name="header">
        {{ __('Data Iuran & Simpanan') }}
    </x-slot>

    <div class="p-6 bg-gray-50 min-h-screen">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-700">Riwayat Transaksi</h2>
                <p class="text-sm text-gray-500">Catatan pembayaran simpanan pokok, wajib, dan sukarela.</p>
            </div>

            <a href="{{ route('savings.create') }}"
                class="flex items-center px-5 py-2.5 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-pink-600 border border-transparent rounded-lg active:bg-pink-600 hover:bg-pink-700 focus:outline-none focus:shadow-outline-pink shadow-md">
                <i class="fa-solid fa-plus mr-2"></i>
                Catat Transaksi Baru
            </a>
        </div>

        <x-alerts.success class="mb-6" />
        <x-alerts.error class="mb-6" />

        <div class="w-full overflow-hidden rounded-xl shadow-xs bg-white border border-gray-200">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-100">
                            <th class="px-4 py-4 text-center w-12">No</th>
                            <th class="px-4 py-4">Tanggal</th>
                            <th class="px-4 py-4">Anggota</th>
                            <th class="px-4 py-4 text-center">Jenis</th>
                            <th class="px-4 py-4 text-right">Jumlah (Rp)</th>
                            <th class="px-4 py-4 text-center">Bukti</th>
                            <th class="px-4 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @forelse($savings as $index => $saving)
                            <tr class="text-gray-700 hover:bg-gray-50 transition duration-150">

                                <td class="px-4 py-3 text-sm text-center">
                                    {{ $savings->firstItem() + $index }}
                                </td>

                                <td class="px-4 py-3 text-sm font-medium">
                                    {{ \Carbon\Carbon::parse($saving->tanggal_bayar)->translatedFormat('d M Y') }}
                                </td>

                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        {{-- Foto Kecil Anggota (Hapus 'storage/' karena pakai Old School) --}}
                                        <div class="relative hidden w-10 h-10 mr-3 rounded-full md:block">
                                            <img class="object-cover w-full h-full rounded-full border border-gray-300"
                                                src="{{ $saving->member->foto ? asset($saving->member->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($saving->member->nama_lengkap) . '&color=ec4899&background=fdf2f8' }}"
                                                alt="Foto {{ $saving->member->nama_lengkap }}" loading="lazy" />
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $saving->member->nama_lengkap }}</p>
                                            <p class="text-xs text-gray-500"><i
                                                    class="fa-solid fa-id-card mr-1 text-pink-400"></i>{{ $saving->member->nomor_anggota }}
                                            </p>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-4 py-3 text-xs text-center">
                                    @php
                                        $colors = [
                                            'pokok' => 'bg-purple-100 text-purple-700 border-purple-200',
                                            'wajib' => 'bg-blue-100 text-blue-700 border-blue-200',
                                            'sukarela' => 'bg-green-100 text-green-700 border-green-200',
                                        ];
                                        $label = ucfirst($saving->jenis_simpanan);
                                    @endphp
                                    <span
                                        class="px-3 py-1 font-bold uppercase tracking-wider text-[10px] leading-tight rounded-full border {{ $colors[$saving->jenis_simpanan] }}">
                                        {{ $label }}
                                    </span>
                                </td>

                                <td class="px-4 py-3 text-sm font-bold text-right text-gray-800">
                                    {{ number_format($saving->jumlah, 0, ',', '.') }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    @if ($saving->bukti_transfer)
                                        {{-- Hapus 'storage/' dari asset --}}
                                        <a href="{{ asset($saving->bukti_transfer) }}" target="_blank"
                                            class="inline-flex items-center justify-center text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 p-2 rounded-full transition"
                                            title="Lihat Bukti">
                                            <i class="fa-solid fa-file-image text-lg"></i>
                                        </a>
                                    @else
                                        <span class="text-gray-400 text-xs italic">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-sm text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('savings.edit', $saving->id) }}"
                                            class="p-2 text-white bg-indigo-500 rounded-lg hover:bg-indigo-600 shadow-sm transition flex items-center justify-center"
                                            title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>

                                        <form action="{{ route('savings.destroy', $saving->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus data transaksi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-white bg-red-500 rounded-lg hover:bg-red-600 shadow-sm transition flex items-center justify-center"
                                                title="Hapus">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500">
                                    <div class="flex flex-col items-center justify-center">
                                        <i class="fa-solid fa-folder-open text-4xl text-gray-300 mb-3"></i>
                                        <p>Belum ada data transaksi.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($savings->hasPages())
                <div class="px-4 py-3 border-t bg-gray-50">
                    {{ $savings->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
