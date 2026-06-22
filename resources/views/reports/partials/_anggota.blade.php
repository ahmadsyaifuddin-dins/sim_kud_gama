<div>
    <h3 class="mb-4 text-xl font-bold text-slate-800 border-b-2 border-slate-300 pb-2">
        <i class="fa-solid fa-users text-purple-600 mr-2"></i> A. Kelompok Data Anggota & Administrasi
    </h3>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3 items-stretch">
        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-purple-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <h4 class="text-lg font-bold text-slate-700">1. Data Anggota Terpadu</h4>
            </div>
            <p class="text-xs text-slate-500 mb-4 flex-grow">Rekapitulasi dinamis berdasarkan wilayah dan periode daftar.
            </p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="anggota_terpadu">
                <select name="dusun"
                    class="block w-full mb-2 text-sm border-slate-300 rounded-lg shadow-sm focus:border-purple-500 focus:ring focus:ring-purple-200">
                    <option value="semua">-- Semua Wilayah (Dusun) --</option>
                    @foreach ($dusunList as $dusun)
                        <option value="{{ $dusun }}">{{ $dusun }}</option>
                    @endforeach
                </select>
                <div class="grid grid-cols-2 gap-2 mb-1">
                    <input type="date" name="start_date" class="block w-full text-xs border-slate-300 rounded-lg"
                        title="Dari Tanggal">
                    <input type="date" name="end_date" class="block w-full text-xs border-slate-300 rounded-lg"
                        title="Sampai Tanggal">
                </div>
                <p class="text-[10px] text-red-500 italic mb-3">*Kosongkan tanggal untuk mengunduh seluruh data.</p>
                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </button>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-blue-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <h4 class="text-lg font-bold text-slate-700">2. Demografi & Potensi</h4>
            </div>
            <p class="text-xs text-slate-500 mb-4 flex-grow">Laporan usia, pekerjaan, dan akumulasi luasan lahan
                pertanian anggota KUD.</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="demografi">
                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </button>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-teal-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <h4 class="text-lg font-bold text-slate-700">3. Administrasi KTA</h4>
            </div>
            <p class="text-xs text-slate-500 mb-4 flex-grow">Monitoring status keanggotaan dan progres pencetakan Kartu
                Tanda Anggota.</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="kta">
                <select name="status"
                    class="block w-full mb-2 text-sm border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                    <option value="semua">-- Semua Status --</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Pasif</option>
                    <option value="stopped">Keluar</option>
                </select>
                <select name="status_cetak"
                    class="block w-full mb-3 text-sm border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                    <option value="semua">-- Semua Status Cetak --</option>
                    <option value="belum">Belum Dicetak</option>
                    <option value="sudah">Sudah Dicetak</option>
                </select>
                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </button>
            </form>
        </div>
    </div>
</div>
