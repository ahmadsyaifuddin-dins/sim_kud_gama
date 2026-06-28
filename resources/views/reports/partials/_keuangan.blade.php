<div x-data="{
    reportType: 'pendaftaran',
    periode: 'semua'
}" class="mb-8">

    <h3 class="mb-4 text-xl font-bold text-slate-800 border-b-2 border-slate-300 pb-2">
        <i class="fa-solid fa-vault text-yellow-500 mr-2"></i> B. Kelompok Keuangan & Simpanan
    </h3>

    <div class="p-6 bg-white rounded-xl shadow-sm border-t-4 border-yellow-400">
        <form action="{{ route('reports.export') }}" method="GET" target="_blank">

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-sm font-bold text-slate-700">Pilih Jenis Laporan:</label>
                    <select name="report_type" x-model="reportType" required
                        class="block w-full text-sm border-slate-300 rounded-lg shadow-sm focus:border-yellow-500 focus:ring focus:ring-yellow-200">
                        <option value="pendaftaran">5. Laporan Pemasukan Pendaftaran</option>
                        <option value="rekap_simpanan">6. Laporan Rekapitulasi Simpanan</option>
                        <option value="cashflow">7. Laporan Arus Kas (Cashflow)</option>
                        <option value="simpanan_rinci">8. Laporan Transaksi Simpanan Rinci</option>
                    </select>

                    <p class="mt-2 text-xs text-slate-500" x-show="reportType === 'pendaftaran'">
                        *Menampilkan rekapitulasi pembayaran kewajiban pendaftaran awal anggota baru.
                    </p>
                    <p class="mt-2 text-xs text-slate-500" x-show="reportType === 'rekap_simpanan'">
                        *Menampilkan akumulasi simpanan pokok, wajib, dan sukarela per anggota KUD aktif.
                    </p>
                    <p class="mt-2 text-xs text-slate-500" x-show="reportType === 'cashflow'">
                        *Menampilkan laporan komprehensif pemasukan kas vs pengeluaran pinjaman.
                    </p>
                    <p class="mt-2 text-xs text-slate-500" x-show="reportType === 'simpanan_rinci'">
                        *Menampilkan rincian histori penyetoran simpanan anggota per rentang tanggal.
                    </p>
                </div>

                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                    <h4 class="mb-3 text-sm font-bold text-slate-700 border-b pb-1">Filter Data</h4>

                    <div x-show="reportType === 'pendaftaran' || reportType === 'cashflow' || reportType === 'simpanan_rinci'">
                        <label class="block text-xs font-semibold text-slate-600 mb-1">Periode Transaksi</label>
                        <select x-model="periode" name="filter_periode" class="block w-full text-sm border-slate-300 rounded-lg mb-2">
                            <option value="semua">Cetak Semua Waktu</option>
                            <option value="custom">Pilih Rentang Tanggal</option>
                        </select>

                        <div x-show="periode === 'custom'" class="grid grid-cols-2 gap-2 mt-2">
                            <div>
                                <label class="text-[10px] text-slate-500">Dari Tanggal</label>
                                <input type="date" name="start_date"
                                    class="block w-full text-xs border-slate-300 rounded-lg"
                                    :required="periode === 'custom'"
                                    :disabled="periode !== 'custom'">
                            </div>
                            <div>
                                <label class="text-[10px] text-slate-500">Sampai Tanggal</label>
                                <input type="date" name="end_date"
                                    class="block w-full text-xs border-slate-300 rounded-lg"
                                    :required="periode === 'custom'"
                                    :disabled="periode !== 'custom'">
                            </div>
                        </div>
                    </div>

                    <div x-show="reportType === 'rekap_simpanan'" class="text-sm text-slate-500 italic py-2">
                        Laporan ini bersifat akumulatif sampai saat ini. Tidak memerlukan filter tanggal.
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