@php
    $glossaryTitle = $glossaryTitle ?? 'Kamus Istilah: Jangan Sampai Bingung';
    $glossarySubtitle = $glossarySubtitle ?? 'Pengertian singkat istilah-istilah pada Kebijakan Pinjaman & Pembagian SHU';
@endphp

<section aria-label="Glosarium" class="mt-8">
    <div class="flex items-center gap-3 mb-4">
        <div
            class="w-10 h-10 flex items-center justify-center rounded-xl bg-gradient-to-br from-sky-400 to-blue-600 text-white shadow-lg shadow-sky-200">
            <i class="fa-solid fa-book-open text-lg"></i>
        </div>
        <div>
            <h3 class="text-lg font-extrabold text-gray-700">{{ $glossaryTitle }}</h3>
            <p class="text-xs text-gray-500 font-semibold">{{ $glossarySubtitle }}</p>
        </div>
    </div>

    {{-- Rangkuman cepat (pills) --}}
    <div class="flex flex-wrap gap-2 mb-4">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-violet-100 text-violet-700 text-xs font-bold">
            <i class="fa-solid fa-scale-balanced"></i> SHU = keuntungan dibagi ke anggota
        </span>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
            <i class="fa-solid fa-ruler-combined"></i> Plafond = batas pinjaman
        </span>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-pink-100 text-pink-700 text-xs font-bold">
            <i class="fa-solid fa-percent"></i> Bunga = "harga" pinjaman per bulan
        </span>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">
            <i class="fa-solid fa-clock"></i> Denda = sanksi bayar telat
        </span>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100">

        {{-- ===== SHU ===== --}}
        <div class="bg-transparent" x-data="{ open: false }">
            <button type="button" @click="open = !open"
                class="w-full flex items-center gap-4 p-5 text-left hover:bg-gray-50/70 transition group">
                <div
                    class="w-11 h-11 flex-shrink-0 flex items-center justify-center rounded-xl bg-gradient-to-br from-violet-400 to-purple-600 text-white shadow-md shadow-purple-200">
                    <i class="fa-solid fa-scale-balanced text-xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-extrabold text-gray-800 group-hover:text-violet-700 transition">SHU (Sisa Hasil Usaha)</p>
                    <p class="text-xs text-gray-500 mt-0.5">Keuntungan bersih KUD satu tahun buku yang dibagikan kembali ke anggota</p>
                </div>
                <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-300 shrink-0"
                    :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open">
                <div class="px-6 pb-6 pl-20">
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">
                        SHU adalah <strong>laba bersih koperasi</strong> yang diperoleh selama satu tahun buku.
                        Berbeda dengan perusahaan biasa, keuntungan ini <strong>dikembalikan ke anggota</strong>
                        karena anggota adalah sekaligus pemilik koperasi. Di aplikasi ini, SHU dibagi otomatis menjadi 3 bagian:
                    </p>
                    <div class="grid gap-3 md:grid-cols-3">
                        <div class="rounded-xl border border-violet-100 bg-violet-50/60 p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fa-solid fa-piggy-bank text-violet-600"></i>
                                <p class="text-sm font-extrabold text-violet-800">Jasa Usaha / Modal</p>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed">Bagian SHU yang dihitung dari <strong>saldo simpanan</strong>. Makin besar simpanan Pokok + Wajib, makin besar bagiannya.</p>
                        </div>
                        <div class="rounded-xl border border-emerald-100 bg-emerald-50/60 p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fa-solid fa-handshake text-emerald-600"></i>
                                <p class="text-sm font-extrabold text-emerald-800">Jasa Transaksi / Pinjaman</p>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed">Bagian SHU dari <strong>keaktifan transaksi</strong> anggota (bayar angsuran + setor simpanan) selama periode tersebut.</p>
                        </div>
                        <div class="rounded-xl border border-amber-100 bg-amber-50/60 p-4">
                            <div class="flex items-center gap-2 mb-2">
                                <i class="fa-solid fa-vault text-amber-600"></i>
                                <p class="text-sm font-extrabold text-amber-800">Cadangan Koperasi</p>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed">Bagian yang <strong>disimpan KUD</strong> sebagai modal usaha tahun berikutnya — tidak dibagikan ke anggota.</p>
                        </div>
                    </div>
                    <p class="mt-4 text-xs text-gray-500 italic flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-sky-500"></i>
                        Ketiga persentase ini wajib berjumlah tepat <strong>100%</strong>, diatur di halaman ini.
                    </p>
                </div>
            </div>
        </div>

        {{-- ===== PLAFOND ===== --}}
        <div class="bg-transparent" x-data="{ open: false }">
            <button type="button" @click="open = !open"
                class="w-full flex items-center gap-4 p-5 text-left hover:bg-gray-50/70 transition group">
                <div
                    class="w-11 h-11 flex-shrink-0 flex items-center justify-center rounded-xl bg-gradient-to-br from-emerald-400 to-teal-600 text-white shadow-md shadow-emerald-200">
                    <i class="fa-solid fa-ruler-combined text-xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-extrabold text-gray-800 group-hover:text-emerald-700 transition">Plafond Pinjaman</p>
                    <p class="text-xs text-gray-500 mt-0.5">Batas maksimal pinjaman yang boleh diterima seorang anggota</p>
                </div>
                <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-300 shrink-0"
                    :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open">
                <div class="px-6 pb-6 pl-20">
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">
                        Plafond menentukan <strong>seberapa besar pinjaman maksimal</strong> yang boleh diajukan anggota,
                        agar modal KUD tetap sehat dan pembagiannya adil. Plafond dihitung dari <strong>dua jalur</strong>,
                        lalu dipakai yang <strong>paling besar</strong>:
                    </p>
                    <div class="space-y-3">
                        <div class="rounded-xl border border-emerald-100 bg-emerald-50/60 p-4">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fa-solid fa-tree text-emerald-600"></i>
                                <p class="text-sm font-extrabold text-emerald-800">Dari Lahan Sawit</p>
                            </div>
                            <p class="text-xs text-gray-600">Luas lahan (hektar) × <strong>Plafond per Hektar</strong>.
                                Contoh: lahan 2 Ha × Rp 10.000.000 = Rp 20.000.000.</p>
                        </div>
                        <div class="rounded-xl border border-sky-100 bg-sky-50/60 p-4">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fa-solid fa-piggy-bank text-sky-600"></i>
                                <p class="text-sm font-extrabold text-sky-800">Dari Simpanan</p>
                            </div>
                            <p class="text-xs text-gray-600">Saldo Simpanan Pokok + Wajib × <strong>Pengali Saldo</strong>.
                                Contoh: saldo Rp 1.500.000 × 10 = Rp 15.000.000.</p>
                        </div>
                    </div>
                    <p class="mt-3 text-xs text-gray-500 italic flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-emerald-500"></i>
                        Dari dua contoh di atas, plafond anggota = <strong>Rp 20.000.000</strong> (nilai terbesar).
                        Ajuan melebihi plafond otomatis ditolak sistem.
                    </p>
                </div>
            </div>
        </div>

        {{-- ===== BUNGA DEFAULT ===== --}}
        <div class="bg-transparent" x-data="{ open: false }">
            <button type="button" @click="open = !open"
                class="w-full flex items-center gap-4 p-5 text-left hover:bg-gray-50/70 transition group">
                <div
                    class="w-11 h-11 flex-shrink-0 flex items-center justify-center rounded-xl bg-gradient-to-br from-pink-400 to-rose-600 text-white shadow-md shadow-pink-200">
                    <i class="fa-solid fa-percent text-xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-extrabold text-gray-800 group-hover:text-rose-700 transition">Bunga Default (Jasa Pinjaman)</p>
                    <p class="text-xs text-gray-500 mt-0.5">"Harga" pinjaman yang dihitung per bulan dari pokok pinjaman</p>
                </div>
                <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-300 shrink-0"
                    :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open">
                <div class="px-6 pb-6 pl-20">
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">
                        Bunga adalah <strong>imbalan jasa</strong> yang dibayar anggota atas pinjaman, dihitung dari
                        persentase tertentu per bulan. Katakanlah <strong>"default"</strong> berarti nilai yang
                        <strong>otomatis terisi</strong> pada form pinjaman baru meski admin tidak mengubahnya.
                        Ada dua skema yang didukung:
                    </p>
                    <div class="grid gap-3 md:grid-cols-2">
                        <div class="rounded-xl border border-pink-100 bg-pink-50/60 p-4">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fa-solid fa-equals text-pink-600"></i>
                                <p class="text-sm font-extrabold text-pink-800">Flat / Tetap</p>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed">Bunga dihitung dari <strong>pokok awal</strong> selama tenor.
                                Cicilan tiap bulan <strong>sama rata</strong> sampai lunas — mudah dipahami anggota.</p>
                        </div>
                        <div class="rounded-xl border border-indigo-100 bg-indigo-50/60 p-4">
                            <div class="flex items-center gap-2 mb-1">
                                <i class="fa-solid fa-chart-line text-indigo-600"></i>
                                <p class="text-sm font-extrabold text-indigo-800">Menurun (Anuitas)</p>
                            </div>
                            <p class="text-xs text-gray-600 leading-relaxed">Bunga dihitung dari <strong>sisa pokok</strong>.
                                Cicilan tetap tiap bulan, tapi porsi pokok makin besar dan bunga makin kecil.</p>
                        </div>
                    </div>
                    <p class="mt-3 text-xs text-gray-500 italic flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-pink-500"></i>
                        Untuk tenor panjang, skema <strong>Menurun</strong> menghasilkan total bunga yang lebih kecil.
                    </p>
                </div>
            </div>
        </div>

        {{-- ===== DENDA KETERLAMBATAN ===== --}}
        <div class="bg-transparent" x-data="{ open: false }">
            <button type="button" @click="open = !open"
                class="w-full flex items-center gap-4 p-5 text-left hover:bg-gray-50/70 transition group">
                <div
                    class="w-11 h-11 flex-shrink-0 flex items-center justify-center rounded-xl bg-gradient-to-br from-amber-400 to-orange-600 text-white shadow-md shadow-amber-200">
                    <i class="fa-solid fa-clock text-xl"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-extrabold text-gray-800 group-hover:text-orange-700 transition">Denda Keterlambatan</p>
                    <p class="text-xs text-gray-500 mt-0.5">Sanksi otomatis bila angsuran dibayar melewati tanggal jatuh tempo</p>
                </div>
                <i class="fa-solid fa-chevron-down text-gray-400 transition-transform duration-300 shrink-0"
                    :class="open ? 'rotate-180' : ''"></i>
            </button>
            <div x-show="open">
                <div class="px-6 pb-6 pl-20">
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">
                        Denda dibuat agar anggota <strong>disiplin membayar tepat waktu</strong>. Sistem menghitungnya
                        <strong>otomatis</strong> saat angsuran disimpan:
                    </p>
                    <div class="rounded-xl border border-amber-100 bg-amber-50/70 p-4 mb-3">
                        <p class="text-sm font-extrabold text-amber-800 mb-1"><i class="fa-solid fa-calculator mr-1"></i> Rumus Denda</p>
                        <p class="text-sm text-gray-700 font-semibold">
                            jumlah hari telat × Tarif Denda per Hari
                        </p>
                        <p class="text-xs text-gray-500 mt-1">Contoh: telat 5 hari × Rp 5.000 = <strong>Rp 25.000</strong> ditambahkan ke angsuran.</p>
                    </div>
                    <p class="text-xs text-gray-500 italic flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i>
                        Dibayar <strong>sebelum atau tepat</strong> di tanggal jatuh tempo maka denda = <strong>Rp 0</strong>.
                    </p>
                </div>
            </div>
        </div>

    </div>
</section>