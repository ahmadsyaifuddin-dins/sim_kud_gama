<x-app-layout>
    <x-slot name="header">
        {{ __('Pusat Laporan & Arsip') }}
    </x-slot>

    <div class="mb-6">
        <p class="text-slate-600">Pilih jenis laporan yang ingin Anda unduh. Anda dapat mengekspor data dalam format
            <strong class="text-green-600"><i class="fa-solid fa-file-excel"></i> Excel</strong> atau <strong
                class="text-red-600"><i class="fa-solid fa-file-pdf"></i> PDF</strong>.
        </p>
    </div>

    <div class="grid gap-6 mb-8 md:grid-cols-2 lg:grid-cols-2 items-stretch">

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-purple-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 mr-4 text-purple-600 bg-purple-50 rounded-full">
                    <i class="fa-solid fa-users text-xl"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-700">1. Laporan Seluruh Anggota</h4>
            </div>
            <p class="text-sm text-slate-500 mb-6 flex-grow">
                Unduh rekapitulasi seluruh data anggota KUD Gajah Mada tanpa filter.
            </p>
            <form action="{{ route('reports.export') }}" method="GET" class="flex gap-3 mt-auto">
                <button type="submit" name="action" value="excel"
                    class="w-1/2 flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 transition">
                    <i class="fa-solid fa-file-excel"></i> Excel
                </button>
                <button type="submit" name="action" value="pdf"
                    class="w-1/2 flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 transition">
                    <i class="fa-solid fa-file-pdf"></i> PDF
                </button>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-blue-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 mr-4 text-blue-600 bg-blue-50 rounded-full">
                    <i class="fa-solid fa-map-location-dot text-xl"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-700">2. Laporan Per Wilayah</h4>
            </div>
            <p class="text-sm text-slate-500 mb-4 flex-grow">Filter data berdasarkan lokasi dusun tempat tinggal.</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <select name="dusun"
                    class="block w-full mb-4 text-sm border-slate-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
                    <option value="semua">-- Semua Dusun --</option>
                    @foreach ($dusunList as $dusun)
                        <option value="{{ $dusun }}">{{ $dusun }}</option>
                    @endforeach
                </select>
                <div class="flex gap-3">
                    <button type="submit" name="action" value="excel"
                        class="w-1/2 flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                        <i class="fa-solid fa-file-excel"></i> Excel
                    </button>
                    <button type="submit" name="action" value="pdf"
                        class="w-1/2 flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                        <i class="fa-solid fa-file-pdf"></i> PDF
                    </button>
                </div>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-orange-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 mr-4 text-orange-600 bg-orange-50 rounded-full">
                    <i class="fa-solid fa-calendar-day text-xl"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-700">3. Laporan Per Periode</h4>
            </div>
            <p class="text-sm text-slate-500 mb-4 flex-grow">Filter data anggota berdasarkan tanggal bergabung.</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <div class="grid grid-cols-2 gap-3 mb-1">
                    <div>
                        <label class="text-xs font-bold text-slate-500 mb-1 block">Dari Tanggal</label>
                        <input type="date" name="start_date"
                            class="block w-full text-sm border-slate-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 mb-1 block">Sampai Tanggal</label>
                        <input type="date" name="end_date"
                            class="block w-full text-sm border-slate-300 rounded-lg shadow-sm focus:border-orange-500 focus:ring focus:ring-orange-200">
                    </div>
                </div>
                <p class="text-[10px] text-slate-400 italic mb-3">*Kosongkan tanggal untuk mencetak seluruh data.</p>

                <div class="flex gap-3">
                    <button type="submit" name="action" value="excel"
                        class="w-1/2 flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                        <i class="fa-solid fa-file-excel"></i> Excel
                    </button>
                    <button type="submit" name="action" value="pdf"
                        class="w-1/2 flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                        <i class="fa-solid fa-file-pdf"></i> PDF
                    </button>
                </div>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-teal-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 mr-4 text-teal-600 bg-teal-50 rounded-full">
                    <i class="fa-solid fa-id-card-clip text-xl"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-700">4. Laporan Status Cetak</h4>
            </div>
            <p class="text-sm text-slate-500 mb-4 flex-grow">Monitoring anggota yang kartunya sudah atau belum dicetak.
            </p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <select name="status_cetak"
                    class="block w-full mb-4 text-sm border-slate-300 rounded-lg shadow-sm focus:border-teal-500 focus:ring focus:ring-teal-200">
                    <option value="semua">-- Semua Status --</option>
                    <option value="belum">Belum Dicetak</option>
                    <option value="sudah">Sudah Dicetak</option>
                </select>
                <div class="flex gap-3">
                    <button type="submit" name="action" value="excel"
                        class="w-1/2 flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                        <i class="fa-solid fa-file-excel"></i> Excel
                    </button>
                    <button type="submit" name="action" value="pdf"
                        class="w-1/2 flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                        <i class="fa-solid fa-file-pdf"></i> PDF
                    </button>
                </div>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-yellow-400 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 mr-4 text-yellow-600 bg-yellow-50 rounded-full">
                    <i class="fa-solid fa-file-invoice-dollar text-xl"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-700">5. Laporan Keuangan (Kwitansi)</h4>
            </div>
            <p class="text-sm text-slate-500 mb-4 flex-grow">
                Rekap pembayaran biaya pendaftaran anggota yang berstatus <strong>LUNAS</strong>.
            </p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="finance">
                <div class="grid grid-cols-2 gap-3 mb-1">
                    <div>
                        <label class="text-xs font-bold text-slate-500 mb-1 block">Dari Tanggal Bayar</label>
                        <input type="date" name="start_date"
                            class="block w-full text-sm border-slate-300 rounded-lg shadow-sm focus:border-yellow-400 focus:ring focus:ring-yellow-200">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 mb-1 block">Sampai Tanggal</label>
                        <input type="date" name="end_date"
                            class="block w-full text-sm border-slate-300 rounded-lg shadow-sm focus:border-yellow-400 focus:ring focus:ring-yellow-200">
                    </div>
                </div>
                <p class="text-[10px] text-slate-400 italic mb-3">*Kosongkan tanggal untuk mencetak seluruh data.</p>

                <div class="flex gap-3">
                    <button type="submit" name="action" value="excel"
                        class="w-1/2 flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                        <i class="fa-solid fa-file-excel"></i> Excel
                    </button>
                    <button type="submit" name="action" value="pdf"
                        class="w-1/2 flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                        <i class="fa-solid fa-file-pdf"></i> PDF
                    </button>
                </div>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-pink-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 mr-4 text-pink-600 bg-pink-50 rounded-full">
                    <i class="fa-solid fa-user-check text-xl"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-700">6. Laporan Status Anggota</h4>
            </div>
            <p class="text-sm text-slate-500 mb-4 flex-grow">Filter data anggota berdasarkan status
                (Aktif/Pasif/Berhenti).</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="status">
                <select name="status"
                    class="block w-full mb-4 text-sm border-slate-300 rounded-lg shadow-sm focus:border-pink-500 focus:ring focus:ring-pink-200">
                    <option value="semua">-- Semua Status --</option>
                    <option value="active">Anggota Aktif</option>
                    <option value="inactive">Pasif / Non-Aktif</option>
                    <option value="stopped">Berhenti / Keluar</option>
                    <option value="pending">Pending (Menunggu)</option>
                </select>
                <div class="flex gap-3">
                    <button type="submit" name="action" value="excel"
                        class="w-1/2 flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700 transition">
                        <i class="fa-solid fa-file-excel"></i> Excel
                    </button>
                    <button type="submit" name="action" value="pdf"
                        class="w-1/2 flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                        <i class="fa-solid fa-file-pdf"></i> PDF
                    </button>
                </div>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-indigo-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 mr-4 text-indigo-600 bg-indigo-50 rounded-full">
                    <i class="fa-solid fa-hand-holding-dollar text-xl"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-700">7. Rekap Pengajuan Pinjaman</h4>
            </div>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="pinjaman_rekap">
                <select name="status_pinjaman"
                    class="block w-full mb-3 text-sm border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                    <option value="semua">-- Semua Status Pinjaman --</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                    <option value="lunas">Lunas</option>
                </select>
                <div class="grid grid-cols-2 gap-3 mb-1">
                    <input type="date" name="start_date"
                        class="block w-full text-sm border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                        title="Dari Tanggal">
                    <input type="date" name="end_date"
                        class="block w-full text-sm border-slate-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                        title="Sampai Tanggal">
                </div>
                <p class="text-[10px] text-slate-400 italic mb-3">*Kosongkan tanggal untuk mencetak seluruh data.</p>

                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </button>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-red-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 mr-4 text-red-600 bg-red-50 rounded-full">
                    <i class="fa-solid fa-triangle-exclamation text-xl"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-700">8. Pinjaman Belum Lunas</h4>
            </div>
            <p class="text-sm text-slate-500 mb-4 flex-grow">Daftar anggota yang pinjamannya berstatus "Disetujui"
                namun belum "Lunas" (Tunggakan).</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="pinjaman_tunggakan">
                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </button>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-emerald-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <div
                    class="flex items-center justify-center w-12 h-12 mr-4 text-emerald-600 bg-emerald-50 rounded-full">
                    <i class="fa-solid fa-money-check-dollar text-xl"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-700">9. Laporan Angsuran Masuk</h4>
            </div>
            <p class="text-sm text-slate-500 mb-4 flex-grow">Rekapitulasi pembayaran angsuran berdasarkan rentang
                waktu.</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="angsuran_masuk">
                <div class="grid grid-cols-2 gap-3 mb-1">
                    <div>
                        <label class="text-xs font-bold text-slate-500 mb-1 block">Dari Tgl Bayar</label>
                        <input type="date" name="start_date"
                            class="block w-full text-sm border-slate-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200">
                    </div>
                    <div>
                        <label class="text-xs font-bold text-slate-500 mb-1 block">Sampai Tgl Bayar</label>
                        <input type="date" name="end_date"
                            class="block w-full text-sm border-slate-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring focus:ring-emerald-200">
                    </div>
                </div>
                <p class="text-[10px] text-slate-400 italic mb-3">*Kosongkan tanggal untuk mencetak seluruh data.</p>

                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </button>
            </form>
        </div>

        <div
            class="p-6 bg-white rounded-xl shadow-sm hover:shadow-md transition border-t-4 border-slate-500 flex flex-col h-full">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-12 h-12 mr-4 text-slate-600 bg-slate-50 rounded-full">
                    <i class="fa-solid fa-user-tie text-xl"></i>
                </div>
                <h4 class="text-lg font-bold text-slate-700">10. Data Pengurus KUD</h4>
            </div>
            <p class="text-sm text-slate-500 mb-4 flex-grow">Cetak susunan daftar kepengurusan KUD Gajah Mada.</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="pengurus">
                <button type="submit" name="action" value="pdf"
                    class="w-full flex items-center justify-center gap-2 px-4 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700 transition">
                    <i class="fa-solid fa-file-pdf"></i> Download PDF
                </button>
            </form>
        </div>

    </div>
</x-app-layout>
