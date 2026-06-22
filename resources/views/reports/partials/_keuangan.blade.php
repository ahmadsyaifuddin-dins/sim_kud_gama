<div>
    <h3 class="mb-4 text-xl font-bold text-slate-800 border-b-2 border-slate-300 pb-2">
        <i class="fa-solid fa-vault text-yellow-500 mr-2"></i> B. Kelompok Keuangan & Simpanan
    </h3>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 items-stretch">
        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-yellow-400 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <h4 class="text-lg font-bold text-slate-700">4. Pemasukan Pendaftaran</h4>
            </div>
            <p class="text-xs text-slate-500 mb-4 flex-grow">Rekapitulasi pembayaran kewajiban pendaftaran awal anggota.
            </p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="pendaftaran">
                <div class="grid grid-cols-2 gap-2 mb-1">
                    <input type="date" name="start_date" class="block w-full text-xs border-slate-300 rounded-lg">
                    <input type="date" name="end_date" class="block w-full text-xs border-slate-300 rounded-lg">
                </div>
                <p class="text-[10px] text-red-500 italic mb-3">*Kosongkan tanggal untuk mengunduh seluruh data.</p>
                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </button>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-cyan-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <h4 class="text-lg font-bold text-slate-700">5. Rekapitulasi Simpanan</h4>
            </div>
            <p class="text-xs text-slate-500 mb-4 flex-grow">Akumulasi simpanan pokok, wajib, dan sukarela per anggota
                KUD.</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="rekap_simpanan">
                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </button>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-blue-800 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <h4 class="text-lg font-bold text-slate-700">6. Arus Kas (Cashflow)</h4>
            </div>
            <p class="text-xs text-slate-500 mb-4 flex-grow">Laporan komprehensif pemasukan kas vs pengeluaran kas
                operasional pinjaman.</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="cashflow">
                <div class="grid grid-cols-2 gap-2 mb-1">
                    <input type="date" name="start_date" class="block w-full text-xs border-slate-300 rounded-lg">
                    <input type="date" name="end_date" class="block w-full text-xs border-slate-300 rounded-lg">
                </div>
                <p class="text-[10px] text-red-500 italic mb-3">*Kosongkan tanggal untuk mengunduh seluruh data.</p>
                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </button>
            </form>
        </div>
    </div>
</div>
