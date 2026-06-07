<div>
    <h3 class="mb-4 text-xl font-bold text-slate-800 border-b-2 border-slate-300 pb-2">
        <i class="fa-solid fa-gears text-slate-600 mr-2"></i> D. Kelompok Sistem & Manajemen
    </h3>

    <div class="grid gap-6 md:grid-cols-2 items-stretch">
        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-slate-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <h4 class="text-lg font-bold text-slate-700">11. Susunan Pengurus KUD</h4>
            </div>
            <p class="text-sm text-slate-500 mb-4 flex-grow">Daftar anggota manajemen operasional koperasi aktif.</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="pengurus">
                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </button>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-gray-400 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <h4 class="text-lg font-bold text-slate-700">12. Hak Akses Pengguna</h4>
            </div>
            <p class="text-sm text-slate-500 mb-4 flex-grow">Daftar riwayat akun admin dan pimpinan pada Sistem
                Informasi.</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="pengguna">
                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </button>
            </form>
        </div>
    </div>
</div>
