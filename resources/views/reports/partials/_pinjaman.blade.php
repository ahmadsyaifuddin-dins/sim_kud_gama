<div x-data="{
    reportType: 'pinjaman_rekap',
    periode: 'semua'
}" class="mb-8">

    <h3 class="mb-4 text-xl font-bold text-slate-800 border-b-2 border-slate-300 pb-2">
        <i class="fa-solid fa-hand-holding-dollar text-indigo-600 mr-2"></i> C. Kelompok Pinjaman & Kredit
    </h3>

    <div class="p-6 bg-white rounded-xl shadow-sm border-t-4 border-indigo-500">
        <form action="{{ route('reports.export') }}" method="GET" target="_blank">

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-sm font-bold text-slate-700">Pilih Jenis Laporan:</label>
                    <select name="report_type" x-model="reportType" required
                        class="block w-full text-sm border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                        <option value="pinjaman_rekap">9. Laporan Rekapitulasi Pengajuan</option>
                        <option value="pinjaman_tunggakan">10. Laporan Pinjaman Berjalan (Tunggakan)</option>
                        <option value="kolektibilitas">11. Laporan Kolektibilitas & Sisa Hutang</option>
                        <option value="angsuran_masuk">12. Laporan Angsuran Masuk</option>
                        <option value="realisasi_pencairan">13. Laporan Realisasi Pencairan Dana</option>
                    </select>

                    <p class="mt-2 text-xs text-slate-500" x-show="reportType === 'pinjaman_rekap'">
                        *Menampilkan history pengajuan kredit beserta status persetujuannya.
                    </p>
                    <p class="mt-2 text-xs text-slate-500" x-show="reportType === 'pinjaman_tunggakan'">
                        *Menampilkan daftar pinjaman yang sudah disetujui dan berada dalam masa angsuran.
                    </p>
                    <p class="mt-2 text-xs text-slate-500" x-show="reportType === 'kolektibilitas'">
                        *Menampilkan status kelancaran bayar, total terbayar, dan sisa hutang per peminjam.
                    </p>
                    <p class="mt-2 text-xs text-slate-500" x-show="reportType === 'angsuran_masuk'">
                        *Menampilkan bukti dan rekapitulasi uang masuk dari cicilan anggota.
                    </p>
                    <p class="mt-2 text-xs text-slate-500" x-show="reportType === 'realisasi_pencairan'">
                        *Menampilkan histori uang keluar dari kas KUD untuk pinjaman yang berhasil dicairkan.
                    </p>
                </div>

                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                    <h4 class="mb-3 text-sm font-bold text-slate-700 border-b pb-1">Filter Data</h4>

                    <div x-show="reportType === 'pinjaman_rekap'" class="mb-3">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Status Pengajuan</label>
                        <select name="status_pinjaman" class="block w-full text-sm border-slate-300 rounded-lg">
                            <option value="semua">-- Semua Status --</option>
                            <option value="menunggu">Menunggu</option>
                            <option value="disetujui">Disetujui</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>

                    <div x-show="reportType === 'pinjaman_rekap' || reportType === 'angsuran_masuk' || reportType === 'realisasi_pencairan'">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Periode Transaksi</label>
                        <select x-model="periode" name="filter_periode" class="block w-full text-sm border-slate-300 rounded-lg mb-2">
                            <option value="semua">Cetak Semua Waktu</option>
                            <option value="custom">Pilih Rentang Tanggal</option>
                        </select>

                        <div x-show="periode === 'custom'" class="grid grid-cols-2 gap-2 mt-2">
                            <div>
                                <label class="text-[10px] text-slate-500">Dari</label>
                                <input type="date" name="start_date"
                                    class="block w-full text-xs border-slate-300 rounded-lg"
                                    :required="periode === 'custom'"
                                    :disabled="periode !== 'custom'">
                            </div>
                            <div>
                                <label class="text-[10px] text-slate-500">Sampai</label>
                                <input type="date" name="end_date"
                                    class="block w-full text-xs border-slate-300 rounded-lg"
                                    :required="periode === 'custom'"
                                    :disabled="periode !== 'custom'">
                            </div>
                        </div>
                    </div>

                    <div x-show="reportType === 'pinjaman_tunggakan' || reportType === 'kolektibilitas'"
                        class="text-sm text-slate-500 italic py-2">
                        Laporan ini bersifat akumulatif data berjalan. Tidak memerlukan filter tanggal.
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end gap-3 border-t pt-4">
                <button type="submit" name="action" value="pdf"
                    class="flex items-center gap-2 px-6 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition shadow-md">
                    <i class="fa-solid fa-print"></i> Cetak PDF
                </button>
            </div>
        </form>
    </div>
</div>