<div x-data="{
    reportType: 'anggota_terpadu',
    periode: 'semua'
}" class="mb-8">

    <h3 class="mb-4 text-xl font-bold text-slate-800 border-b-2 border-slate-300 pb-2">
        <i class="fa-solid fa-users text-purple-600 mr-2"></i> A. Kelompok Data Anggota & Administrasi
    </h3>

    <div class="p-6 bg-white rounded-xl shadow-sm border-t-4 border-purple-500">
        <form action="{{ route('reports.export') }}" method="GET" target="_blank">

            <div class="grid md:grid-cols-2 gap-6">
                <!-- KIRI: PILIHAN REPORT -->
                <div>
                    <label class="block mb-2 text-sm font-bold text-slate-700">Pilih Jenis Laporan:</label>
                    <select name="report_type" x-model="reportType" required
                        class="block w-full text-sm border-slate-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                        <option value="anggota_terpadu">1. Laporan Data Anggota Terpadu</option>
                        <option value="demografi">2. Laporan Demografi & Potensi Lahan</option>
                        <option value="kta">3. Laporan Administrasi & Status KTA</option>
                        <option value="distribusi_lahan">4. Laporan Total Luas Lahan Pertanian</option>
                    </select>

                    <p class="mt-2 text-xs text-slate-500" x-show="reportType === 'anggota_terpadu'">
                        *Menampilkan rekapitulasi data anggota beserta detail lahan.
                    </p>
                    <p class="mt-2 text-xs text-slate-500" x-show="reportType === 'demografi'">
                        *Menampilkan data usia, pekerjaan, dan akumulasi total luasan lahan pertanian.
                    </p>
                    <p class="mt-2 text-xs text-slate-500" x-show="reportType === 'kta'">
                        *Menampilkan status keaktifan anggota dan progres pencetakan Kartu Tanda Anggota.
                    </p>
                    <p class="mt-2 text-xs text-slate-500" x-show="reportType === 'distribusi_lahan'">
                        *Menampilkan rekapitulasi total luasan lahan pertanian per wilayah/dusun.
                    </p>
                </div>

                <!-- KANAN: FILTER DINAMIS -->
                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                    <h4 class="mb-3 text-sm font-bold text-slate-700 border-b pb-1">Filter Data</h4>

                    <div x-show="reportType === 'anggota_terpadu'" class="mb-3">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Wilayah / Dusun</label>
                        <select name="dusun" class="block w-full text-sm border-slate-300 rounded-lg">
                            <option value="semua">-- Semua Wilayah (Dusun) --</option>
                            @foreach ($dusunList as $dusun)
                                <option value="{{ $dusun }}">{{ $dusun }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div x-show="reportType === 'kta'" class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Status Keanggotaan</label>
                            <select name="status" class="block w-full text-sm border-slate-300 rounded-lg">
                                <option value="semua">-- Semua Status --</option>
                                <option value="active">Aktif</option>
                                <option value="inactive">Pasif</option>
                                <option value="stopped">Keluar / Berhenti</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1">Status Cetak KTA</label>
                            <select name="status_cetak" class="block w-full text-sm border-slate-300 rounded-lg">
                                <option value="semua">-- Semua Status Cetak --</option>
                                <option value="belum">Belum Dicetak</option>
                                <option value="sudah">Sudah Dicetak</option>
                            </select>
                        </div>
                    </div>

                    <div x-show="reportType === 'anggota_terpadu'" class="mt-3">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Periode Pendaftaran</label>
                        <select x-model="periode" class="block w-full text-sm border-slate-300 rounded-lg mb-2">
                            <option value="semua">Cetak Semua Waktu</option>
                            <option value="custom">Pilih Rentang Tanggal</option>
                        </select>

                        <div x-show="periode === 'custom'" class="grid grid-cols-2 gap-2 mt-2">
                            <div>
                                <label class="text-[10px] text-slate-500">Dari Tanggal</label>
                                <input type="date" name="start_date"
                                    class="block w-full text-xs border-slate-300 rounded-lg"
                                    :required="periode === 'custom'">
                            </div>
                            <div>
                                <label class="text-[10px] text-slate-500">Sampai Tanggal</label>
                                <input type="date" name="end_date"
                                    class="block w-full text-xs border-slate-300 rounded-lg"
                                    :required="periode === 'custom'">
                            </div>
                        </div>
                    </div>

                    <!-- Perhatikan perubahan di baris ini: Menambahkan kondisi untuk distribusi_lahan -->
                    <div x-show="reportType === 'demografi' || reportType === 'distribusi_lahan'"
                        class="text-sm text-slate-500 italic py-2">
                        Laporan ini bersifat akumulatif analitik. Tidak memerlukan filter tanggal/wilayah.
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3 border-t pt-4">
                <button type="submit" name="action" value="excel"
                    class="flex items-center gap-2 px-5 py-2 text-sm font-semibold text-emerald-700 bg-emerald-100 border border-emerald-300 rounded-lg hover:bg-emerald-200 transition">
                    <i class="fa-solid fa-file-excel"></i> Export Excel
                </button>
                <button type="submit" name="action" value="pdf"
                    class="flex items-center gap-2 px-6 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition shadow-md">
                    <i class="fa-solid fa-print"></i> Cetak PDF
                </button>
            </div>

        </form>
    </div>
</div>
