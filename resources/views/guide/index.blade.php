<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-compass text-pink-600"></i>
            {{ __('Panduan Uji Coba Fitur Revisi') }}
        </div>
    </x-slot>

    {{-- ====== HERO ====== --}}
    <div
        class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-pink-600 via-pink-700 to-rose-800 p-8 text-white shadow-xl shadow-pink-200/60 mb-8">
        <div class="absolute -top-10 -right-10 w-52 h-52 bg-white/10 rounded-full"></div>
        <div class="absolute -bottom-16 right-24 w-64 h-64 bg-white/5 rounded-full"></div>
        <div class="absolute top-6 right-40 w-20 h-20 bg-pink-400/30 rounded-full"></div>

        <div class="relative">
            <div class="flex flex-wrap items-center gap-3 mb-4">
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 backdrop-blur rounded-full text-xs font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-flag-checkered"></i> 8 Langkah Uji
                </span>
                <span
                    class="inline-flex items-center gap-2 px-3 py-1 bg-white/20 backdrop-blur rounded-full text-xs font-bold">
                    <i class="fa-solid fa-database"></i> Data latihan: 30 anggota • 28 pinjaman
                </span>
            </div>

            <h2 class="text-2xl md:text-3xl font-black leading-snug">
                Mulai dari Mana Menguji Fitur Revisi?
            </h2>
            <p class="mt-3 max-w-2xl text-sm md:text-base text-pink-100 leading-relaxed">
                Jalankan langkah-langkah di bawah ini <strong>secara berurutan</strong>. Setiap langkah punya tujuan
                uji dan hasil yang harus kamu pastikan. Kalau sudah sampai akhir, berarti seluruh fitur revisi
                <strong>Pinjaman, Denda, Tutup Buku, dan SHU</strong> sudah teruji.
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
                <a href="#langkah-1"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-pink-700 rounded-lg font-bold text-sm shadow-lg hover:bg-pink-50 transition">
                    <i class="fa-solid fa-play"></i> Mulai dari Langkah 1
                </a>
                <a href="{{ route('settings.index') }}"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-white/15 backdrop-blur rounded-lg font-bold text-sm hover:bg-white/25 transition">
                    <i class="fa-solid fa-rocket"></i> Langsung ke Fitur Utama
                </a>
            </div>
        </div>
    </div>

    {{-- ====== TIPS PERSIAPAN ====== --}}
    <div class="grid gap-4 md:grid-cols-3 mb-10">
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex gap-4 items-start">
            <div class="w-11 h-11 flex-shrink-0 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div>
                <p class="font-extrabold text-gray-700 text-sm mb-1">Siapkan 1-2 Anggota Uji</p>
                <p class="text-xs text-gray-500 leading-relaxed">Pilih anggota yang punya <strong>luasan lahan</strong> &amp; saldo simpanan agar plafond pinjaman bisa diuji.</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex gap-4 items-start">
            <div class="w-11 h-11 flex-shrink-0 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
            <div>
                <p class="font-extrabold text-gray-700 text-sm mb-1">Gunakan Tanggal Hari Ini</p>
                <p class="text-xs text-gray-500 leading-relaxed">Supaya data uji tidak tertimpa kunci periode. Periode yang ditutup sengaja dibuat khusus untuk uji blokir.</p>
            </div>
        </div>
        <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex gap-4 items-start">
            <div class="w-11 h-11 flex-shrink-0 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg">
                <i class="fa-solid fa-clipboard-check"></i>
            </div>
            <div>
                <p class="font-extrabold text-gray-700 text-sm mb-1">Catat Angka Sebelum &amp; Sesudah</p>
                <p class="text-xs text-gray-500 leading-relaxed">Bandingkan jumlah pinjaman, angsuran, dan saldo agar yakin perhitungan otomatis konsisten.</p>
            </div>
        </div>
    </div>

    @include('partials._glossary_accordion', [
        'glossaryTitle' => 'Pahami Dulu Istilahnya',
        'glossarySubtitle' => 'SHU, Plafond, Bunga & Denda (-) biar tidak bingung sebelum mulai menguji',
    ])

    {{-- ====== TIMELINE LANGKAH ====== --}}
    <div class="relative mt-5">
        <div class="absolute left-[22px] md:left-6 top-2 bottom-2 w-0.5 bg-pink-200"></div>

        @php
            $steps = [
                [
                    'id' => 'langkah-1',
                    'n' => 1,
                    'icon' => 'fa-user-gear',
                    'color' => 'from-emerald-400 to-teal-600',
                    'ring' => 'ring-emerald-100',
                    'badge' => 'Dasar Perhitungan',
                    'title' => 'Lengkapi Data Anggota',
                    'route' => 'members.index',
                    'routeLabel' => 'Data Anggota',
                    'desc' => 'Plafond pinjaman dihitung dari Luasan Lahan Sawit dan Saldo Simpanan Pokok + Wajib. Tanpa data ini, plafond tidak akurat.',
                    'coba' => [
                        'Buka salah satu anggota yang akan dipakai uji coba.',
                        'Pastikan kolom "Luasan Lahan (sawit)" terisi dalam hektar.',
                        'Periksa saldo simpanan Pokok + Wajib anggota tersebut.',
                    ],
                    'hasil' => 'Dashboard & form pinjaman menampilkan "Sumber Modal" dan plafond sesuai data tersebut.',
                ],
                [
                    'id' => 'langkah-2',
                    'n' => 2,
                    'icon' => 'fa-sliders',
                    'color' => 'from-violet-400 to-purple-600',
                    'ring' => 'ring-violet-100',
                    'badge' => 'Konfigurasi',
                    'title' => 'Atur Kebijakan Keuangan',
                    'route' => 'settings.index',
                    'routeLabel' => 'Kebijakan & Pengaturan',
                    'desc' => 'Ini otak dari semua perhitungan otomatis: plafond per hektar, pengali saldo, jenis bunga default, persentase jasa per bulan, tarif denda, dan alokasi persen SHU.',
                    'coba' => [
                        'Set Plafond per Hektar (mis. 10.000.000) & Pengali Saldo (mis. 10x).',
                        'Set Jenis Bunga Default & Persentase Jasa per Bulan (mis. flat 1,5%).',
                        'Set Tarif Denda per Hari (mis. 5.000) dan persen alokasi SHU (35 / 40 / 25).',
                        'Klik Simpan, pastikan muncul notifikasi sukses.',
                    ],
                    'hasil' => 'Nilai tersimpan; semua form otomatis memakai nilai ini di langkah berikutnya.',
                ],
                [
                    'id' => 'langkah-3',
                    'n' => 3,
                    'icon' => 'fa-hand-holding-dollar',
                    'color' => 'from-pink-400 to-rose-600',
                    'ring' => 'ring-pink-100',
                    'badge' => 'Pinjaman',
                    'title' => 'Ajukan Pinjaman Baru (Uji Plafond & Bunga)',
                    'route' => 'pinjaman.create',
                    'routeLabel' => 'Tambah Pinjaman',
                    'desc' => 'Saat memilih anggota, form menampilkan Plafond Maksimum otomatis. Pilih skema bunga lalu preview besar angsuran per bulan.',
                    'coba' => [
                        'Pilih anggota uji, perhatikan "Plafond Maksimum" muncul.',
                        'Coba isi jumlah melebihi plafond untuk cek penolakan.',
                        'Ganti jenis bunga Flat lalu Menurun, bandingkan preview cicilan.',
                        'Simpan pinjaman baru.',
                    ],
                    'hasil' => 'Jumlah melampaui plafond ditolak; cicilan Flat = pokok+bunga dibagi rata, Menurun = cicilan tetap anuitas.',
                ],
                [
                    'id' => 'langkah-4',
                    'n' => 4,
                    'icon' => 'fa-file-invoice-dollar',
                    'color' => 'from-blue-400 to-indigo-600',
                    'ring' => 'ring-blue-100',
                    'badge' => 'Angsuran',
                    'title' => 'Bayar Angsuran (Uji Pokok, Bunga & Denda)',
                    'route' => 'angsuran.create',
                    'routeLabel' => 'Bayar Angsuran',
                    'desc' => 'Form otomatis menghitung pokok, bunga, tanggal jatuh tempo, dan denda bila telat. Cek sampai status pinjaman berubah LUNAS.',
                    'coba' => [
                        'Pilih pinjaman yang sudah disetujui, lihat angka-angka terisi otomatis.',
                        'Uji 1: bayar tepat tanggal jatuh tempo - denda harus 0.',
                        'Uji 2: bayar beberapa hari setelah jatuh tempo - denda muncul otomatis.',
                        'Bayar semua angsuran (ke-1 s/d ke-n) untuk uji status lunas.',
                    ],
                    'hasil' => 'Kolom Jatuh Tempo & Denda terisi di daftar; denda = jumlah hari telat × tarif per hari; status otomatis jadi "Lunas".',
                ],
                [
                    'id' => 'langkah-5',
                    'n' => 5,
                    'icon' => 'fa-rotate',
                    'color' => 'from-cyan-400 to-sky-600',
                    'ring' => 'ring-cyan-100',
                    'badge' => 'Status Otomatis',
                    'title' => 'Uji Lunas / Kembali Disetujui Otomatis',
                    'route' => 'pinjaman.index',
                    'routeLabel' => 'Daftar Pinjaman',
                    'desc' => 'Sistem otomatis menandai LUNAS begitu seluruh angsuran terbayar, dan kembali DISETUJUI jika ada angsuran yang dihapus.',
                    'coba' => [
                        'Buka Daftar Pinjaman, cek status pinjaman yang angsurannya lengkap.',
                        'Hapus salah satu angsuran dari pinjaman tersebut.',
                        'Cek lagi statusnya.',
                    ],
                    'hasil' => 'Lengkap → "Lunas". Setelah 1 angsuran dihapus → kembali "Disetujui". Tidak perlu ubah manual.',
                ],
                [
                    'id' => 'langkah-6',
                    'n' => 6,
                    'icon' => 'fa-calendar-xmark',
                    'color' => 'from-amber-400 to-orange-600',
                    'ring' => 'ring-amber-100',
                    'badge' => 'Tutup Buku',
                    'title' => 'Tutup Buku Bulanan (Uji Kunci Periode)',
                    'route' => 'periods.index',
                    'routeLabel' => 'Tutup Buku & Periode',
                    'desc' => 'Kunci sebuah bulan. Semua transaksi (simpanan, angsuran, pinjaman) di rentang tanggal itu menjadi read-only.',
                    'coba' => [
                        'Tutup bulan yang memiliki transaksi (mis. September).',
                        'Coba tambah / ubah / hapus transaksi bertanggal di bulan tersebut.',
                    ],
                    'hasil' => 'Semua aksi di bulan terkunci DITOLAK dengan pesan "periode sudah ditutup (read-only)". Transaksi bulan lain tetap normal.',
                ],
                [
                    'id' => 'langkah-7',
                    'n' => 7,
                    'icon' => 'fa-unlock',
                    'color' => 'from-lime-400 to-green-600',
                    'ring' => 'ring-lime-100',
                    'badge' => 'Tutup Buku',
                    'title' => 'Buka Kembali Periode',
                    'route' => 'periods.index',
                    'routeLabel' => 'Tutup Buku & Periode',
                    'desc' => 'Jika perlu koreksi, periode terkunci bisa dibuka kembali dari riwayat penutupan.',
                    'coba' => [
                        'Di riwayat "Periode Bulanan Ditutup", klik "Buka Kembali".',
                        'Konfirmasi di popup SweetAlert.',
                        'Coba edit transaksi di bulan tersebut lagi.',
                    ],
                    'hasil' => 'Transaksi di periode itu kembali bisa diproses. Periode hilang dari daftar terkunci.',
                ],
                [
                    'id' => 'langkah-8',
                    'n' => 8,
                    'icon' => 'fa-scale-balanced',
                    'color' => 'from-fuchsia-400 to-purple-700',
                    'ring' => 'ring-fuchsia-100',
                    'badge' => 'SHU',
                    'title' => 'Kalkulasi Pembagian SHU (Uji Otomasi)',
                    'route' => 'shu.create',
                    'routeLabel' => 'Kalkulasi SHU',
                    'desc' => 'Sistem otomatis membagi SHU: Jasa Modal proporsional saldo simpanan, Jasa Transaksi proporsional keaktifan (angsuran + simpanan), sisanya cadangan.',
                    'coba' => [
                        'Pilih tahun, isi Total SHU yang akan dibagikan.',
                        'Yakinkan badge alokasi menunjukkan 100%.',
                        'Simpan, lihat rincian per anggota & jumlah total.',
                        'Cetak PDF dari tombol yang tersedia.',
                    ],
                    'hasil' => 'Total alokasi 100%; rincian proporsional; PDF A4 landscape siap arsip; tahun yang sudah dibagi tidak bisa dihitung 2x.',
                ],
            ];
        @endphp

        @foreach ($steps as $step)
            <div id="{{ $step['id'] }}" class="relative pl-16 md:pl-20 pb-10 scroll-mt-24">
                <div
                    class="absolute left-0 top-0 w-11 h-11 md:w-12 md:h-12 rounded-2xl bg-gradient-to-br {{ $step['color'] }} text-white flex items-center justify-center shadow-lg font-black text-lg ring-8 {{ $step['ring'] }}">
                    {{ $step['n'] }}
                </div>

                <div
                    class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md hover:border-pink-200 transition">
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span
                            class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-md text-[10px] font-black uppercase tracking-wider bg-gradient-to-r {{ $step['color'] }} text-white">
                            <i class="fa-solid {{ $step['icon'] }}"></i>
                            {{ $step['badge'] }}
                        </span>
                        <span class="text-xs font-semibold text-gray-400">Langkah {{ $step['n'] }} dari 8</span>
                    </div>

                    <h3 class="text-lg font-extrabold text-gray-800 mb-2 flex items-center gap-2">
                        {{ $step['title'] }}
                    </h3>
                    <p class="text-sm text-gray-500 leading-relaxed mb-5">{{ $step['desc'] }}</p>

                    <div class="grid gap-4 md:grid-cols-2">
                        <div class="rounded-xl bg-pink-50/70 border border-pink-100 p-4">
                            <p class="flex items-center gap-2 text-xs font-black uppercase tracking-wider text-pink-700 mb-3">
                                <i class="fa-solid fa-magnifying-glass"></i> Langkah Uji Coba
                            </p>
                            <ul class="space-y-2">
                                @foreach ($step['coba'] as $item)
                                    <li class="flex gap-2 text-sm text-gray-600">
                                        <i class="fa-solid fa-square-check text-emerald-500 mt-0.5 flex-shrink-0"></i>
                                        <span>{{ $item }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="rounded-xl bg-emerald-50/70 border border-emerald-100 p-4">
                            <p class="flex items-center gap-2 text-xs font-black uppercase tracking-wider text-emerald-700 mb-3">
                                <i class="fa-solid fa-circle-check"></i> Hasil yang Diharapkan
                            </p>
                            <p class="text-sm text-gray-600 leading-relaxed">
                                <i class="fa-solid fa-arrow-right text-emerald-500 mr-1.5"></i>{{ $step['hasil'] }}
                            </p>
                        </div>
                    </div>

                    <a href="{{ route($step['route']) }}"
                        class="inline-flex items-center gap-2 mt-5 px-4 py-2 bg-gradient-to-r {{ $step['color'] }} text-white rounded-lg text-sm font-bold shadow-sm hover:opacity-90 transition">
                        Buka: {{ $step['routeLabel'] }}
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    {{-- ====== CEPAT YAKEYIN ====== --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mt-4 mb-8">
        <h3 class="font-extrabold text-gray-700 mb-1 flex items-center gap-2">
            <i class="fa-solid fa-bolt text-amber-500"></i> Uji Kilat 5 Menit (Kalau Waktu Singkat)
        </h3>
        <p class="text-xs text-gray-500 mb-4">Rangkaian minimal untuk memastikan semua fitur revisi hidup.</p>
        <div class="grid gap-3 md:grid-cols-5">
            <a href="{{ route('settings.index') }}"
                class="rounded-xl border border-gray-200 p-4 hover:border-pink-300 hover:bg-pink-50/50 transition">
                <p class="font-black text-2xl text-pink-500">1</p>
                <p class="text-xs font-bold text-gray-700 mt-1">Ubah 1 kebijakan lalu simpan</p>
            </a>
            <a href="{{ route('pinjaman.create') }}"
                class="rounded-xl border border-gray-200 p-4 hover:border-pink-300 hover:bg-pink-50/50 transition">
                <p class="font-black text-2xl text-pink-500">2</p>
                <p class="text-xs font-bold text-gray-700 mt-1">Pinjaman baru: cek plafond &amp; cicilan</p>
            </a>
            <a href="{{ route('angsuran.create') }}"
                class="rounded-xl border border-gray-200 p-4 hover:border-pink-300 hover:bg-pink-50/50 transition">
                <p class="font-black text-2xl text-pink-500">3</p>
                <p class="text-xs font-bold text-gray-700 mt-1">Bayar angsuran &amp; bayar yang telat</p>
            </a>
            <a href="{{ route('periods.index') }}"
                class="rounded-xl border border-gray-200 p-4 hover:border-pink-300 hover:bg-pink-50/50 transition">
                <p class="font-black text-2xl text-pink-500">4</p>
                <p class="text-xs font-bold text-gray-700 mt-1">Tutup bulan &amp; coba edit transaksi</p>
            </a>
            <a href="{{ route('shu.create') }}"
                class="rounded-xl border border-gray-200 p-4 hover:border-pink-300 hover:bg-pink-50/50 transition">
                <p class="font-black text-2xl text-pink-500">5</p>
                <p class="text-xs font-bold text-gray-700 mt-1">Kalkulasi SHU &amp; cetak PDF</p>
            </a>
        </div>
    </div>
</x-app-layout>