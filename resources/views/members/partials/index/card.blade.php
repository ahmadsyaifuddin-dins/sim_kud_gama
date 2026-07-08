<div x-show="viewMode === 'card'" x-cloak class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($members as $member)
        <div
            class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow flex flex-col relative">

            <div class="px-5 py-3 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                @if ($member->status == 'pending')
                    <span
                        class="px-2.5 py-1 text-[10px] font-bold text-orange-700 bg-orange-100 rounded-md border border-orange-200 animate-pulse">VERIFIKASI</span>
                @elseif ($member->status == 'active')
                    <span
                        class="px-2.5 py-1 text-[10px] font-bold text-green-700 bg-green-100 rounded-md border border-green-200">AKTIF</span>
                @elseif ($member->status == 'inactive')
                    <span
                        class="px-2.5 py-1 text-[10px] font-bold text-yellow-700 bg-yellow-100 rounded-md border border-yellow-200">PASIF</span>
                @else
                    <span
                        class="px-2.5 py-1 text-[10px] font-bold text-red-700 bg-red-100 rounded-md border border-red-200">BERHENTI</span>
                @endif

                <div class="text-[10px] font-bold">
                    @if ($member->status_cetak)
                        <span class="text-blue-600"><i class="fa-solid fa-print mr-1"></i>Tercetak</span>
                    @else
                        <span class="text-gray-400">Belum Dicetak</span>
                    @endif
                </div>
            </div>

            <div class="p-5 flex gap-4">
                <img class="w-16 h-16 rounded-lg object-cover border border-gray-200 shadow-sm shrink-0"
                    src="{{ $member->foto ? asset($member->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($member->nama_lengkap) . '&background=random' }}"
                    alt="{{ $member->nama_lengkap }}" loading="lazy" />

                <div class="flex-1 min-w-0">
                    <p class="text-[10px] font-bold text-pink-600 mb-0.5 tracking-wider uppercase">
                        <i class="fa-solid fa-hashtag mr-0.5"></i> {{ $member->nomor_anggota ?? 'BELUM ADA NO' }}
                    </p>
                    <h3 class="text-gray-800 font-bold text-base truncate">{{ $member->nama_lengkap }}</h3>
                    <p class="text-xs text-gray-500 mb-2"><i
                            class="fa-solid fa-id-card mr-1 text-gray-400"></i>{{ $member->nik }}</p>

                    <div class="space-y-1">
                        <p class="text-[11px] text-gray-600 flex items-start gap-1.5">
                            <i class="fa-solid fa-location-dot mt-0.5 text-gray-400 w-3"></i>
                            <span class="line-clamp-2 leading-tight">{{ $member->alamat_lengkap }}
                                ({{ $member->dusun }})</span>
                        </p>
                        <p class="text-[11px] text-gray-600 flex items-center gap-1.5">
                            <i class="fa-solid fa-calendar-check text-gray-400 w-3"></i>
                            <span>Gabung:
                                {{ \Carbon\Carbon::parse($member->tanggal_bergabung)->translatedFormat('d M Y') }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <div class="flex-grow"></div>

            <div class="px-5 py-3 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-2">

                <div>
                    @if ($member->status == 'pending')
                        {{-- Form diupdate menggunakan class "confirm-action" dan data-swal attributes --}}
                        <form action="{{ route('members.approve', $member->id) }}" method="POST" class="confirm-action"
                            data-swal-title="Verifikasi Anggota?"
                            data-swal-text="Verifikasi anggota ini? Nomor anggota akan digenerate ulang menjadi KUD-GM-XXX."
                            data-swal-icon="question" data-swal-confirm="Ya, Setujui!" data-swal-color="#2563eb">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="flex items-center px-3 py-1.5 text-[11px] font-bold text-white bg-blue-600 rounded-md hover:bg-blue-700 shadow-sm transition">
                                <i class="fa-solid fa-check mr-1.5"></i> Setujui
                            </button>
                        </form>
                    @else
                        @if ($member->file_bukti_bayar)
                            <span
                                class="flex items-center text-[11px] font-bold text-green-600 bg-green-50 px-2 py-1 rounded-md border border-green-100">
                                <i class="fa-solid fa-check-double mr-1"></i> Lunas
                            </span>
                        @else
                            <span
                                class="flex items-center text-[11px] font-bold text-red-600 bg-red-50 px-2 py-1 rounded-md border border-red-100">
                                <i class="fa-solid fa-xmark mr-1"></i> Blm Bayar
                            </span>
                        @endif
                    @endif
                </div>

                <div class="flex items-center space-x-1.5">
                    @if ($member->file_bukti_bayar)
                        <a href="{{ route('members.print_card', $member->id) }}" target="_blank"
                            class="w-7 h-7 flex items-center justify-center text-white bg-emerald-500 rounded text-xs hover:bg-emerald-600 transition"
                            title="Cetak KTA">
                            <i class="fa-solid fa-id-badge"></i>
                        </a>
                        <a href="{{ route('members.print_receipt', $member->id) }}" target="_blank"
                            class="w-7 h-7 flex items-center justify-center text-white bg-blue-500 rounded text-xs hover:bg-blue-600 transition"
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
                            class="w-7 h-7 flex items-center justify-center text-gray-400 bg-gray-200 rounded cursor-not-allowed shadow-sm transition"
                            title="Belum Bayar (Fitur Cetak Terkunci)">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </button>
                    @endif

                    <a href="{{ route('members.show', $member->id) }}"
                        class="w-7 h-7 flex items-center justify-center text-white bg-indigo-500 rounded text-xs hover:bg-indigo-600 transition"
                        title="Lihat Detail">
                        <i class="fa-solid fa-eye"></i>
                    </a>

                    <a href="{{ route('members.edit', $member->id) }}"
                        class="w-7 h-7 flex items-center justify-center text-white bg-purple-500 rounded text-xs hover:bg-purple-600 transition"
                        title="Edit Data">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>

                    <form action="{{ route('members.destroy', $member->id) }}" method="POST"
                        class="inline-block confirm-action" data-swal-title="Hapus Data Anggota?"
                        data-swal-text="Yakin ingin menghapus data {{ $member->nama_lengkap }} beserta seluruh berkasnya secara permanen?">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-7 h-7 flex items-center justify-center text-white bg-red-500 rounded text-xs hover:bg-red-600 transition"
                            title="Hapus">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div
            class="col-span-full py-12 text-center text-gray-500 bg-gray-50 border border-dashed border-gray-300 rounded-xl">
            <i class="fa-solid fa-users-slash text-4xl text-gray-300 mb-3"></i>
            <p class="text-lg font-bold text-gray-600">Belum ada data anggota.</p>
        </div>
    @endforelse
</div>
