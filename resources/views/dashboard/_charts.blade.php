<div class="grid gap-6 mb-8 md:grid-cols-3">
    <div class="md:col-span-2 min-w-0 p-6 bg-white rounded-2xl shadow-sm border border-gray-100">
        <div class="flex items-center gap-2 mb-4 border-b pb-3">
            <div class="p-2 bg-purple-100 rounded-lg text-purple-600"><i class="fa-solid fa-chart-pie"></i></div>
            <h4 class="font-bold text-gray-800">Sebaran Anggota per Dusun</h4>
        </div>
        <div class="relative h-64 w-full flex justify-center">
            <canvas id="dusunChart"></canvas>
        </div>
    </div>

    <div
        class="min-w-0 p-6 bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col relative overflow-hidden">
        <i class="fa-brands fa-laravel absolute -bottom-6 -right-6 text-9xl text-gray-50 opacity-50 z-0"></i>

        <div class="flex items-center gap-2 mb-4 border-b pb-3 relative z-10">
            <div class="p-2 bg-blue-100 rounded-lg text-blue-600"><i class="fa-solid fa-circle-info"></i></div>
            <h4 class="font-bold text-gray-800">Informasi Sistem</h4>
        </div>

        <div class="text-gray-600 text-sm flex-grow relative z-10">
            <p class="mb-4 text-justify">Selamat datang di <b>Sistem Informasi KUD Gajah Mada</b>. Seluruh modul telah
                beroperasi penuh.</p>

            <p class="font-bold text-gray-700 mb-2"><i class="fa-solid fa-layer-group mr-1"></i> Status Modul:</p>
            <ul class="space-y-2 text-gray-600">
                <li class="flex items-center gap-2 bg-gray-50 p-2 rounded-lg"><i
                        class="fa-solid fa-check text-green-500"></i> Pendaftaran & KTA Digital</li>
                <li class="flex items-center gap-2 bg-gray-50 p-2 rounded-lg"><i
                        class="fa-solid fa-check text-green-500"></i> Simpanan & Angsuran</li>
                <li class="flex items-center gap-2 bg-gray-50 p-2 rounded-lg"><i
                        class="fa-solid fa-check text-green-500"></i> Pusat Laporan PDF/Excel</li>
            </ul>
        </div>

        <div
            class="mt-6 p-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white rounded-xl flex items-center justify-center gap-2 font-bold text-sm shadow-md shadow-green-200 relative z-10">
            <i class="fa-solid fa-server animate-pulse"></i> Server Online & Aman
        </div>
    </div>
</div>
