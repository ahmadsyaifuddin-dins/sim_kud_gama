<div x-data="{ reportType: 'pengurus' }" class="mb-8">
    <h3 class="mb-4 text-xl font-bold text-slate-800 border-b-2 border-slate-300 pb-2">
        <i class="fa-solid fa-gears text-slate-600 mr-2"></i> D. Kelompok Sistem & Manajemen
    </h3>

    <div class="p-6 bg-white rounded-xl shadow-sm border-t-4 border-slate-500">
        <form action="{{ route('reports.export') }}" method="GET" target="_blank">

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block mb-2 text-sm font-bold text-slate-700">Pilih Jenis Laporan:</label>
                    <select name="report_type" x-model="reportType" required
                        class="block w-full text-sm border-slate-300 rounded-lg shadow-sm focus:border-slate-500 focus:ring focus:ring-slate-200">
                        <option value="pengurus">14. Daftar Susunan Pengurus KUD</option>
                        <option value="pengguna">15. Data Hak Akses Pengguna (Sistem)</option>
                    </select>
                </div>

                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200 flex items-center">
                    <p class="text-sm text-slate-500 italic" x-show="reportType === 'pengurus'">
                        Laporan ini mencetak daftar anggota manajemen operasional koperasi yang berstatus Aktif.
                    </p>
                    <p class="text-sm text-slate-500 italic" x-show="reportType === 'pengguna'">
                        Laporan ini mencetak data riwayat akun admin dan pimpinan pada Sistem Informasi.
                    </p>
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
