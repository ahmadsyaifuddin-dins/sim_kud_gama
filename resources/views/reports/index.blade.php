<x-app-layout>
    <x-slot name="header">
        {{ __('Pusat Laporan & Arsip') }}
    </x-slot>

    <div class="grid gap-6 mb-8 md:grid-cols-2">

        <div class="p-6 bg-white rounded-lg shadow-xs border border-purple-200">
            <div class="flex items-center mb-4">
                <div class="p-3 mr-4 text-purple-700 bg-purple-100 rounded-full">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-700">1. Laporan Seluruh Anggota</h4>
            </div>
            <p class="text-sm text-gray-600 mb-4">
                Unduh rekapitulasi seluruh data anggota KUD Gajah Mada tanpa filter.
            </p>
            <form action="{{ route('reports.export') }}" method="GET" class="flex gap-2">
                <button type="submit" name="action" value="excel"
                    class="w-full px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                    Export Excel
                </button>
                <button type="submit" name="action" value="pdf"
                    class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                    Export PDF
                </button>
            </form>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-xs border border-blue-200">
            <div class="flex items-center mb-4">
                <div class="p-3 mr-4 text-blue-700 bg-blue-100 rounded-full">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-700">2. Laporan Per Wilayah</h4>
            </div>
            <p class="text-sm text-gray-600 mb-2">Filter data berdasarkan lokasi dusun tempat tinggal.</p>

            <form action="{{ route('reports.export') }}" method="GET">
                <select name="dusun"
                    class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-purple-400 focus:outline-none mb-4">
                    <option value="semua">-- Semua Dusun --</option>
                    @foreach ($dusunList as $dusun)
                        <option value="{{ $dusun }}">{{ $dusun }}</option>
                    @endforeach
                </select>
                <div class="flex gap-2">
                    <button type="submit" name="action" value="excel"
                        class="w-1/2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">Excel</button>
                    <button type="submit" name="action" value="pdf"
                        class="w-1/2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">PDF</button>
                </div>
            </form>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-xs border border-orange-200">
            <div class="flex items-center mb-4">
                <div class="p-3 mr-4 text-orange-700 bg-orange-100 rounded-full">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-700">3. Laporan Per Periode</h4>
            </div>
            <form action="{{ route('reports.export') }}" method="GET">
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <div>
                        <label class="text-xs text-gray-500">Dari Tanggal</label>
                        <input type="date" name="start_date" class="block w-full text-sm border-gray-300 rounded-md"
                            required>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Sampai Tanggal</label>
                        <input type="date" name="end_date" class="block w-full text-sm border-gray-300 rounded-md"
                            required>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit" name="action" value="excel"
                        class="w-1/2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">Excel</button>
                    <button type="submit" name="action" value="pdf"
                        class="w-1/2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">PDF</button>
                </div>
            </form>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-xs border border-teal-200">
            <div class="flex items-center mb-4">
                <div class="p-3 mr-4 text-teal-700 bg-teal-100 rounded-full">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-700">4. Laporan Status Cetak</h4>
            </div>
            <p class="text-sm text-gray-600 mb-2">Monitoring anggota yang kartunya sudah/belum dicetak.</p>

            <form action="{{ route('reports.export') }}" method="GET">
                <select name="status_cetak"
                    class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-purple-400 focus:outline-none mb-4">
                    <option value="semua">-- Semua Status --</option>
                    <option value="belum">Belum Dicetak</option>
                    <option value="sudah">Sudah Dicetak</option>
                </select>
                <div class="flex gap-2">
                    <button type="submit" name="action" value="excel"
                        class="w-1/2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">Excel</button>
                    <button type="submit" name="action" value="pdf"
                        class="w-1/2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">PDF</button>
                </div>
            </form>
        </div>
        <div class="p-6 bg-white rounded-lg shadow-xs border border-yellow-400 col-span-1 md:col-span-2">
            <div class="flex items-center mb-4">
                <div class="p-3 mr-4 text-yellow-700 bg-yellow-100 rounded-full">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-700">5. Laporan Keuangan (Rekap Kwitansi Masuk)</h4>
            </div>
            <p class="text-sm text-gray-600 mb-4">
                Rekapitulasi pembayaran biaya pendaftaran anggota yang statusnya sudah <strong>LUNAS</strong>.
            </p>

            <form action="{{ route('reports.export') }}" method="GET">
                <input type="hidden" name="report_type" value="finance">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="text-xs text-gray-500 font-bold">Dari Tanggal Bayar</label>
                        <input type="date" name="start_date"
                            class="block w-full text-sm border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 font-bold">Sampai Tanggal Bayar</label>
                        <input type="date" name="end_date" class="block w-full text-sm border-gray-300 rounded-md"
                            required>
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" name="action" value="excel"
                        class="w-1/2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 font-bold">
                        Download Excel
                    </button>
                    <button type="submit" name="action" value="pdf"
                        class="w-1/2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 font-bold">
                        Download PDF
                    </button>
                </div>
            </form>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-xs border border-pink-200">
            <div class="flex items-center mb-4">
                <div class="p-3 mr-4 text-pink-700 bg-pink-100 rounded-full">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-700">6. Laporan Status Keanggotaan</h4>
            </div>
            <p class="text-sm text-gray-600 mb-2">Filter data anggota berdasarkan status (Aktif/Pasif/Berhenti).</p>

            <form action="{{ route('reports.export') }}" method="GET">
                <input type="hidden" name="report_type" value="status">

                <select name="status"
                    class="block w-full mt-1 text-sm border-gray-300 rounded-md shadow-sm focus:border-purple-400 focus:outline-none mb-4">
                    <option value="semua">-- Semua Status --</option>
                    <option value="active">Anggota Aktif</option>
                    <option value="inactive">Pasif / Non-Aktif</option>
                    <option value="stopped">Berhenti / Keluar</option>
                    <option value="pending">Pending (Menunggu)</option>
                </select>

                <div class="flex gap-2">
                    <button type="submit" name="action" value="excel"
                        class="w-1/2 px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700">
                        Excel
                    </button>
                    <button type="submit" name="action" value="pdf"
                        class="w-1/2 px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">
                        PDF
                    </button>
                </div>
            </form>
        </div>


        <div class="p-6 bg-white rounded-lg shadow-xs border border-indigo-200">
            <div class="flex items-center mb-4">
                <div class="p-3 mr-4 text-indigo-700 bg-indigo-100 rounded-full">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-700">7. Rekap Pengajuan Pinjaman</h4>
            </div>
            <form action="{{ route('reports.export') }}" method="GET">
                <input type="hidden" name="report_type" value="pinjaman_rekap">
                <select name="status_pinjaman" class="block w-full mt-1 text-sm border-gray-300 rounded-md mb-2">
                    <option value="semua">-- Semua Status --</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                    <option value="lunas">Lunas</option>
                </select>
                <div class="grid grid-cols-2 gap-2 mb-4">
                    <input type="date" name="start_date" class="block w-full text-sm border-gray-300 rounded-md">
                    <input type="date" name="end_date" class="block w-full text-sm border-gray-300 rounded-md">
                </div>
                <button type="submit" name="action" value="pdf"
                    class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Download
                    PDF</button>
            </form>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-xs border border-red-200">
            <div class="flex items-center mb-4">
                <div class="p-3 mr-4 text-red-700 bg-red-100 rounded-full">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-700">8. Pinjaman Belum Lunas</h4>
            </div>
            <p class="text-sm text-gray-600 mb-4">Daftar anggota yang pinjamannya berstatus "Disetujui" namun belum
                "Lunas".</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="pinjaman_tunggakan">
                <button type="submit" name="action" value="pdf"
                    class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Download
                    PDF</button>
            </form>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-xs border border-emerald-200">
            <div class="flex items-center mb-4">
                <div class="p-3 mr-4 text-emerald-700 bg-emerald-100 rounded-full">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-700">9. Laporan Angsuran Masuk</h4>
            </div>
            <form action="{{ route('reports.export') }}" method="GET">
                <input type="hidden" name="report_type" value="angsuran_masuk">
                <div class="grid grid-cols-2 gap-2 mb-4 mt-2">
                    <div>
                        <label class="text-xs text-gray-500">Dari Tgl Bayar</label>
                        <input type="date" name="start_date"
                            class="block w-full text-sm border-gray-300 rounded-md" required>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500">Sampai Tgl Bayar</label>
                        <input type="date" name="end_date" class="block w-full text-sm border-gray-300 rounded-md"
                            required>
                    </div>
                </div>
                <button type="submit" name="action" value="pdf"
                    class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Download
                    PDF</button>
            </form>
        </div>

        <div class="p-6 bg-white rounded-lg shadow-xs border border-gray-300">
            <div class="flex items-center mb-4">
                <div class="p-3 mr-4 text-gray-700 bg-gray-200 rounded-full">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <h4 class="text-lg font-semibold text-gray-700">10. Data Pengurus KUD</h4>
            </div>
            <p class="text-sm text-gray-600 mb-4">Cetak susunan kepengurusan KUD Gajah Mada.</p>
            <form action="{{ route('reports.export') }}" method="GET" class="mt-auto">
                <input type="hidden" name="report_type" value="pengurus">
                <button type="submit" name="action" value="pdf"
                    class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700">Download
                    PDF</button>
            </form>
        </div>

    </div>
</x-app-layout>
