<div x-show="viewMode === 'table'" x-cloak
    class="w-full overflow-hidden rounded-xl shadow-xs bg-white border border-gray-200">
    <div class="w-full overflow-x-auto">
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr class="text-xs font-bold tracking-wide text-left text-gray-600 uppercase border-b bg-gray-100">
                    <th class="px-4 py-4 text-center w-12">No</th>
                    <th class="px-4 py-4">Nama / NIK</th>
                    <th class="px-4 py-4">Alamat / Dusun</th>
                    <th class="px-4 py-4 text-center">Status Akun</th>
                    <th class="px-4 py-4 text-center">Pembayaran</th>
                    <th class="px-4 py-4 text-center">Status Cetak</th>
                    <th class="px-4 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y">
                @forelse($members as $index => $member)
                    <tr class="text-gray-700 hover:bg-gray-50 transition duration-150">
                        <td class="px-4 py-3 text-sm text-center">
                            {{ $members->firstItem() + $index }}
                        </td>

                        <td class="px-4 py-3">
                            <div class="flex items-center text-sm min-w-[250px]">
                                <div class="relative hidden w-12 h-12 mr-3 rounded-full md:block shrink-0">
                                    <img class="object-cover w-full h-full rounded-full border-2 border-gray-200 shadow-sm"
                                        src="{{ $member->foto ? asset($member->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($member->nama_lengkap) . '&background=random' }}"
                                        alt="{{ $member->nama_lengkap }}" loading="lazy" />
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold text-gray-800 text-base whitespace-nowrap">
                                        {{ $member->nama_lengkap }}
                                    </p>
                                    <p class="text-xs text-gray-600 font-semibold mb-0.5">
                                        <i class="fa-solid fa-id-card text-purple-400 mr-1"></i>{{ $member->nik }}
                                    </p>
                                    <p class="text-[10px] text-gray-400 whitespace-nowrap">
                                        <i class="fa-regular fa-calendar-check mr-1"></i> Gabung:
                                        {{ \Carbon\Carbon::parse($member->tanggal_bergabung)->translatedFormat('d M Y') }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-3 text-sm">
                            <p class="truncate w-48 font-medium" title="{{ $member->alamat_lengkap }}">
                                {{ Str::limit($member->alamat_lengkap, 30) }}
                            </p>
                            <span
                                class="text-[10px] font-bold text-gray-600 bg-gray-200 inline-block px-2 py-0.5 rounded mt-1 uppercase tracking-wider">
                                {{ $member->dusun }}
                            </span>
                        </td>

                        <td class="px-4 py-3 text-xs text-center">
                            @if ($member->status == 'pending')
                                <div class="flex flex-col items-center gap-2">
                                    <span
                                        class="px-2 py-1 font-bold leading-tight text-orange-700 bg-orange-100 rounded-full animate-pulse border border-orange-200">
                                        VERIFIKASI
                                    </span>

                                    {{-- Form diupdate menggunakan class "confirm-action" dan data-swal attributes --}}
                                    <form action="{{ route('members.approve', $member->id) }}" method="POST"
                                        class="confirm-action" data-swal-title="Verifikasi Anggota?"
                                        data-swal-text="Verifikasi anggota ini? Nomor anggota akan digenerate ulang menjadi KUD-GM-XXX."
                                        data-swal-icon="question" data-swal-confirm="Ya, Setujui!">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit"
                                            class="flex items-center px-3 py-1 text-[10px] font-bold text-white bg-blue-600 rounded hover:bg-blue-700 shadow transition">
                                            <i class="fa-solid fa-check mr-1"></i> SETUJUI
                                        </button>
                                    </form>
                                </div>
                            @elseif ($member->status == 'active')
                                <span
                                    class="px-2 py-1 font-bold leading-tight text-green-700 bg-green-100 rounded-full border border-green-200">AKTIF</span>
                            @elseif ($member->status == 'inactive')
                                <span
                                    class="px-2 py-1 font-bold leading-tight text-yellow-700 bg-yellow-100 rounded-full border border-yellow-200">PASIF</span>
                            @elseif ($member->status == 'stopped')
                                <span
                                    class="px-2 py-1 font-bold leading-tight text-red-700 bg-red-100 rounded-full border border-red-200">BERHENTI</span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-xs text-center">
                            @if ($member->file_bukti_bayar)
                                <span
                                    class="px-2 py-1 font-bold leading-tight text-green-700 bg-green-100 rounded-full">
                                    <i class="fa-solid fa-check-double mr-1"></i> LUNAS
                                </span>
                            @else
                                <span class="px-2 py-1 font-bold leading-tight text-red-700 bg-red-100 rounded-full">
                                    <i class="fa-solid fa-xmark mr-1"></i> BELUM
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-xs text-center">
                            @if ($member->status_cetak)
                                <span
                                    class="inline-block px-2 py-1 font-bold text-blue-700 bg-blue-100 rounded-full whitespace-nowrap">
                                    <i class="fa-solid fa-print mr-1"></i> Sudah Dicetak
                                </span>
                            @else
                                <span
                                    class="inline-block px-2 py-1 font-bold text-gray-600 bg-gray-200 rounded-full whitespace-nowrap">
                                    Belum Dicetak
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3 text-sm text-center">
                            <div class="flex items-center justify-center space-x-2">

                                @if ($member->file_bukti_bayar)
                                    <a href="{{ route('members.print_card', $member->id) }}" target="_blank"
                                        class="w-8 h-8 flex items-center justify-center text-white bg-emerald-500 rounded-lg hover:bg-emerald-600 shadow-sm transition"
                                        title="Cetak Kartu Anggota (KTA)">
                                        <i class="fa-solid fa-id-badge"></i>
                                    </a>
                                    <a href="{{ route('members.print_receipt', $member->id) }}" target="_blank"
                                        class="w-8 h-8 flex items-center justify-center text-white bg-blue-500 rounded-lg hover:bg-blue-600 shadow-sm transition"
                                        title="Cetak Kwitansi">
                                        <i class="fa-solid fa-file-invoice-dollar"></i>
                                    </a>
                                @else
                                    <button type="button"
                                        onclick="Swal.fire({
                                            icon: 'warning',
                                            title: 'Fitur Terkunci!',
                                            text: 'Anggota ini belum melakukan pembayaran administrasi! Silakan upload bukti bayar di menu Edit terlebih dahulu.',
                                            confirmButtonColor: '#3b82f6',
                                            confirmButtonText: 'Tutup'
                                        })"
                                        class="w-8 h-8 flex items-center justify-center text-gray-400 bg-gray-200 rounded-lg cursor-not-allowed shadow-sm transition"
                                        title="Belum Bayar (Fitur Cetak Terkunci)">
                                        <i class="fa-solid fa-lock"></i>
                                    </button>
                                @endif

                                <a href="{{ route('members.show', $member->id) }}"
                                    class="w-8 h-8 flex items-center justify-center text-white bg-indigo-500 rounded-lg hover:bg-indigo-600 shadow-sm transition"
                                    title="Lihat Detail">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <a href="{{ route('members.edit', $member->id) }}"
                                    class="w-8 h-8 flex items-center justify-center text-white bg-purple-500 rounded-lg hover:bg-purple-600 shadow-sm transition"
                                    title="Edit Data">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>

                                <form action="{{ route('members.destroy', $member->id) }}" method="POST"
                                    class="inline-block confirm-action" data-swal-title="Hapus Data Anggota?"
                                    data-swal-text="Yakin ingin menghapus data {{ $member->nama_lengkap }} beserta seluruh berkasnya secara permanen?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="w-8 h-8 flex items-center justify-center text-white bg-red-500 rounded-lg hover:bg-red-600 shadow-sm transition"
                                        title="Hapus Permanen">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-gray-500 bg-gray-50">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fa-solid fa-users-slash text-5xl text-gray-300 mb-3"></i>
                                <span class="text-lg font-bold text-gray-600">Belum ada data anggota.</span>
                                <p class="text-sm mt-1 text-gray-500">Silakan tambah anggota baru secara manual.</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
