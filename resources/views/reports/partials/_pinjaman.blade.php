<div>
    <h3 class="mb-4 text-xl font-bold text-slate-800 border-b-2 border-slate-300 pb-2">
        <i class="fa-solid fa-hand-holding-dollar text-indigo-600 mr-2"></i> C. Kelompok Pinjaman & Kredit
    </h3>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4 items-stretch">
        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-indigo-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <h4 class="text-base font-bold text-slate-700">7. Rekap Pengajuan</h4>
            </div>
            <p class="text-[11px] text-slate-500 mb-4 flex-grow">History status pengajuan kredit.</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="pinjaman_rekap">
                <select name="status_pinjaman" class="block w-full mb-2 text-xs border-slate-300 rounded-lg">
                    <option value="semua">-- Semua Status --</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>
                <div class="grid grid-cols-2 gap-2 mb-1">
                    <input type="date" name="start_date" class="block w-full text-xs border-slate-300 rounded-lg"
                        title="Dari Tanggal">
                    <input type="date" name="end_date" class="block w-full text-xs border-slate-300 rounded-lg"
                        title="Sampai Tanggal">
                </div>
                <p class="text-[10px] text-red-500 italic mb-3">*Kosongkan tanggal untuk mengunduh seluruh data.</p>
                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Unduh PDF
                </button>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-red-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <h4 class="text-base font-bold text-slate-700">8. Pinjaman Berjalan</h4>
            </div>
            <p class="text-[11px] text-slate-500 mb-4 flex-grow">Daftar pinjaman yang statusnya disetujui/tunggakan.</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="pinjaman_tunggakan">
                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Unduh PDF
                </button>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-rose-600 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <h4 class="text-base font-bold text-slate-700">9. Kolektibilitas</h4>
            </div>
            <p class="text-[11px] text-slate-500 mb-4 flex-grow">Status kelancaran bayar & sisa hutang.</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="kolektibilitas">
                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Unduh PDF
                </button>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-emerald-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <h4 class="text-base font-bold text-slate-700">10. Angsuran Masuk</h4>
            </div>
            <p class="text-[11px] text-slate-500 mb-2 flex-grow">Bukti uang masuk cicilan.</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="angsuran_masuk">
                <div class="grid grid-cols-2 gap-2 mb-1"> <input type="date" name="start_date"
                        class="block w-full text-xs border-slate-300 rounded-lg">
                    <input type="date" name="end_date" class="block w-full text-xs border-slate-300 rounded-lg">
                </div>
                <p class="text-[10px] text-red-500 italic mb-3">*Kosongkan tanggal untuk mengunduh seluruh data.</p>
                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-3 py-2 text-xs font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Unduh PDF
                </button>
            </form>
        </div>
    </div>
</div>
