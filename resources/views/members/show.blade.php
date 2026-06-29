<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-bold text-gray-700">
                {{ __('Detail Anggota') }}
            </h2>
            <a href="{{ route('members.index') }}" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition text-sm font-bold shadow-sm">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </x-slot>

    <div class="p-6 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto">
            
            <x-alerts.success class="mb-6" />
            <x-alerts.error class="mb-6" />

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- KOLOM KIRI: Profil & Aksi -->
                <div class="md:col-span-1 space-y-6">
                    <!-- Card Profil -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="bg-pink-600 h-24"></div>
                        <div class="px-6 pb-6 relative text-center">
                            <img class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-md mx-auto -mt-12 mb-4 bg-white"
                                src="{{ $member->foto ? asset($member->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($member->nama_lengkap) . '&background=random' }}"
                                alt="{{ $member->nama_lengkap }}" />
                            
                            <h3 class="text-xl font-bold text-gray-800">{{ $member->nama_lengkap }}</h3>
                            <p class="text-sm text-gray-500 mb-4"><i class="fa-solid fa-id-card mr-1"></i> {{ $member->nik }}</p>
                            
                            <!-- Status Badges -->
                            <div class="flex flex-wrap justify-center gap-2 mb-4">
                                @if ($member->status == 'pending')
                                    <span class="px-3 py-1 text-xs font-bold text-orange-700 bg-orange-100 rounded-full border border-orange-200 animate-pulse">VERIFIKASI</span>
                                @elseif ($member->status == 'active')
                                    <span class="px-3 py-1 text-xs font-bold text-green-700 bg-green-100 rounded-full border border-green-200">AKTIF</span>
                                @elseif ($member->status == 'inactive')
                                    <span class="px-3 py-1 text-xs font-bold text-yellow-700 bg-yellow-100 rounded-full border border-yellow-200">PASIF</span>
                                @else
                                    <span class="px-3 py-1 text-xs font-bold text-red-700 bg-red-100 rounded-full border border-red-200">BERHENTI</span>
                                @endif

                                @if ($member->file_bukti_bayar)
                                    <span class="px-3 py-1 text-xs font-bold text-emerald-700 bg-emerald-100 rounded-full border border-emerald-200"><i class="fa-solid fa-check-double mr-1"></i> LUNAS</span>
                                @else
                                    <span class="px-3 py-1 text-xs font-bold text-rose-700 bg-rose-100 rounded-full border border-rose-200"><i class="fa-solid fa-xmark mr-1"></i> BLM BAYAR</span>
                                @endif
                            </div>
                            
                            <div class="inline-block bg-pink-50 border border-pink-100 rounded-lg px-4 py-2 w-full">
                                <p class="text-xs text-pink-600 font-semibold uppercase tracking-wider mb-0.5">Nomor Anggota</p>
                                <p class="text-lg font-bold text-pink-700">{{ $member->nomor_anggota ?? 'Belum Digenerate' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Quick Actions -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 space-y-3">
                        <h4 class="text-sm font-bold text-gray-800 border-b pb-2 mb-3"><i class="fa-solid fa-bolt text-yellow-500 mr-2"></i>Aksi Cepat</h4>
                        
                        @if ($member->status == 'pending')
                            <form action="{{ route('members.approve', $member->id) }}" method="POST" onsubmit="return confirm('Verifikasi anggota ini?');">
                                @csrf @method('PUT')
                                <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-bold text-white bg-blue-600 rounded-lg hover:bg-blue-700 transition">
                                    <i class="fa-solid fa-check-circle mr-2"></i> Verifikasi Pendaftaran
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('members.edit', $member->id) }}" class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-bold text-white bg-purple-500 rounded-lg hover:bg-purple-600 transition">
                            <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Data
                        </a>

                        @if ($member->file_bukti_bayar)
                            <a href="{{ route('members.print_card', $member->id) }}" target="_blank" class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-bold text-white bg-emerald-500 rounded-lg hover:bg-emerald-600 transition">
                                <i class="fa-solid fa-id-badge mr-2"></i> Cetak Kartu (KTA)
                            </a>
                            <a href="{{ route('members.print_receipt', $member->id) }}" target="_blank" class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-bold text-white bg-cyan-600 rounded-lg hover:bg-cyan-700 transition">
                                <i class="fa-solid fa-file-invoice-dollar mr-2"></i> Cetak Kwitansi
                            </a>
                        @endif

                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="confirm-action" data-swal-title="Hapus Data Anggota?" data-swal-text="Yakin ingin menghapus data {{ $member->nama_lengkap }} secara permanen?">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 text-sm font-bold text-red-600 bg-red-50 border border-red-200 rounded-lg hover:bg-red-100 transition mt-4">
                                <i class="fa-solid fa-trash-can mr-2"></i> Hapus Anggota
                            </button>
                        </form>
                    </div>
                </div>

                <!-- KOLOM KANAN: Detail Info & Dokumen -->
                <div class="md:col-span-2 space-y-6">
                    
                    <!-- Card Informasi Pribadi -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h4 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4"><i class="fa-solid fa-file-lines text-pink-500 mr-2"></i> Informasi Detail</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-6">
                            <!-- Baris 1 -->
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Nama Lengkap</p>
                                <p class="text-sm font-medium text-gray-900"><i class="fa-solid fa-user text-gray-400 mr-1.5 w-4"></i> {{ $member->nama_lengkap }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Nomor Induk Kependudukan (NIK)</p>
                                <p class="text-sm font-medium text-gray-900"><i class="fa-solid fa-id-card text-gray-400 mr-1.5 w-4"></i> {{ $member->nik }}</p>
                            </div>

                            <!-- Baris 2 -->
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Tempat, Tanggal Lahir</p>
                                <p class="text-sm font-medium text-gray-900">
                                    <i class="fa-solid fa-cake-candles text-gray-400 mr-1.5 w-4"></i> 
                                    {{ $member->tempat_lahir }}, {{ \Carbon\Carbon::parse($member->tanggal_lahir)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Jenis Kelamin</p>
                                <p class="text-sm font-medium text-gray-900">
                                    @if($member->jenis_kelamin == 'L')
                                        <i class="fa-solid fa-mars text-blue-500 mr-1.5 w-4"></i> Laki-laki
                                    @elseif($member->jenis_kelamin == 'P')
                                        <i class="fa-solid fa-venus text-pink-500 mr-1.5 w-4"></i> Perempuan
                                    @else
                                        -
                                    @endif
                                </p>
                            </div>

                            <!-- Baris 3 -->
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Pekerjaan</p>
                                <p class="text-sm font-medium text-gray-900"><i class="fa-solid fa-briefcase text-gray-400 mr-1.5 w-4"></i> {{ $member->pekerjaan ?: '-' }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">No. Handphone (WA)</p>
                                <p class="text-sm font-medium text-gray-900">
                                    <i class="fa-brands fa-whatsapp text-emerald-500 mr-1.5 w-4"></i> {{ $member->no_hp ?: '-' }}
                                </p>
                            </div>

                            <!-- Baris 4 (Full Width) -->
                            <div class="md:col-span-2">
                                <p class="text-xs text-gray-500 font-semibold mb-1">Alamat Lengkap</p>
                                <p class="text-sm font-medium text-gray-900"><i class="fa-solid fa-map-location-dot text-gray-400 mr-1.5 w-4"></i> {{ $member->alamat_lengkap }}</p>
                            </div>

                            <!-- Baris 5 -->
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Dusun</p>
                                <p class="text-sm font-medium text-gray-900">
                                    <span class="bg-gray-100 px-2.5 py-1 rounded border border-gray-200 text-xs font-bold uppercase">
                                        <i class="fa-solid fa-location-dot text-gray-400 mr-1"></i> {{ $member->dusun }}
                                    </span>
                                </p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Luas Lahan Lapor</p>
                                <p class="text-sm font-medium text-gray-900">
                                    <span class="inline-flex items-center bg-green-50 text-green-700 px-2.5 py-1 rounded border border-green-200 font-bold text-xs">
                                        <i class="fa-solid fa-seedling mr-1.5"></i> {{ number_format($member->luasan_lahan, 2, ',', '.') }} Hektar (Ha)
                                    </span>
                                </p>
                            </div>

                            <!-- Baris 6: Menghitung Lama Bergabung menggunakan PHP Native & Carbon -->
                            @php
                                $joinDate = \Carbon\Carbon::parse($member->tanggal_bergabung);
                                $now = now();
                                $diff = $joinDate->diff($now);
                                
                                $lamaBergabung = [];
                                if ($diff->y > 0) $lamaBergabung[] = $diff->y . ' Tahun';
                                if ($diff->m > 0) $lamaBergabung[] = $diff->m . ' Bulan';
                                if ($diff->d > 0) $lamaBergabung[] = $diff->d . ' Hari';
                                
                                // Jika umurnya kurang dari 1 hari, tampilkan jam/menit
                                if (empty($lamaBergabung)) {
                                    if ($diff->h > 0) $lamaBergabung[] = $diff->h . ' Jam';
                                    if ($diff->i > 0) $lamaBergabung[] = $diff->i . ' Menit';
                                    if (empty($lamaBergabung)) $lamaBergabung[] = 'Baru saja didaftarkan';
                                }
                                
                                $lamaStr = implode(', ', $lamaBergabung);
                            @endphp

                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Tanggal Bergabung</p>
                                <p class="text-sm font-medium text-gray-900"><i class="fa-regular fa-calendar-check text-gray-400 mr-1.5 w-4"></i> {{ $joinDate->translatedFormat('d F Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-semibold mb-1">Lama Bergabung</p>
                                <p class="text-sm font-medium text-gray-900">
                                    <span class="inline-flex items-center bg-blue-50 text-blue-700 px-2.5 py-1 rounded border border-blue-200 font-bold text-xs">
                                        <i class="fa-solid fa-clock-rotate-left mr-1.5"></i> {{ $lamaStr }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Dokumen Persyaratan -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h4 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4"><i class="fa-solid fa-folder-open text-blue-500 mr-2"></i> Dokumen & Berkas</h4>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- KTP -->
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded bg-blue-100 text-blue-600 flex items-center justify-center text-lg shrink-0">
                                        <i class="fa-solid fa-address-card"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">Scan KTP</p>
                                        <p class="text-[10px] text-gray-500">Persyaratan Wajib</p>
                                    </div>
                                </div>
                                @if($member->file_ktp)
                                    <a href="{{ asset($member->file_ktp) }}" target="_blank" class="px-3 py-1.5 text-xs font-bold text-white bg-gray-800 rounded hover:bg-gray-700 transition shadow-sm">
                                        <i class="fa-solid fa-eye mr-1"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-xs font-bold text-red-500 bg-red-50 border border-red-100 px-2 py-1 rounded">Kosong</span>
                                @endif
                            </div>

                            <!-- Kartu Keluarga -->
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded bg-indigo-100 text-indigo-600 flex items-center justify-center text-lg shrink-0">
                                        <i class="fa-solid fa-users-rectangle"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">Kartu Keluarga</p>
                                        <p class="text-[10px] text-gray-500">Persyaratan Wajib</p>
                                    </div>
                                </div>
                                @if($member->file_kk)
                                    <a href="{{ asset($member->file_kk) }}" target="_blank" class="px-3 py-1.5 text-xs font-bold text-white bg-gray-800 rounded hover:bg-gray-700 transition shadow-sm">
                                        <i class="fa-solid fa-eye mr-1"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-xs font-bold text-red-500 bg-red-50 border border-red-100 px-2 py-1 rounded">Kosong</span>
                                @endif
                            </div>

                            <!-- Sertifikat Tanah -->
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded bg-amber-100 text-amber-600 flex items-center justify-center text-lg shrink-0">
                                        <i class="fa-solid fa-map"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">Sertifikat Tanah</p>
                                        <p class="text-[10px] text-gray-500">Bukti Kepemilikan Lahan</p>
                                    </div>
                                </div>
                                @if($member->file_sertifikat_tanah)
                                    <a href="{{ asset($member->file_sertifikat_tanah) }}" target="_blank" class="px-3 py-1.5 text-xs font-bold text-white bg-gray-800 rounded hover:bg-gray-700 transition shadow-sm">
                                        <i class="fa-solid fa-eye mr-1"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-xs font-bold text-red-500 bg-red-50 border border-red-100 px-2 py-1 rounded">Kosong</span>
                                @endif
                            </div>

                            <!-- Bukti Bayar -->
                            <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg shrink-0">
                                        <i class="fa-solid fa-money-bill-transfer"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-gray-800">Bukti Bayar</p>
                                        <p class="text-[10px] text-gray-500">
                                            @if($member->tanggal_bayar)
                                                {{ \Carbon\Carbon::parse($member->tanggal_bayar)->format('d/m/Y') }}
                                            @else
                                                Administrasi
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if($member->file_bukti_bayar)
                                    <a href="{{ asset($member->file_bukti_bayar) }}" target="_blank" class="px-3 py-1.5 text-xs font-bold text-white bg-gray-800 rounded hover:bg-gray-700 transition shadow-sm">
                                        <i class="fa-solid fa-eye mr-1"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-xs font-bold text-red-500 bg-red-50 border border-red-100 px-2 py-1 rounded">Kosong</span>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>