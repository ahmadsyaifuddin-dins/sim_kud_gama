<h3 class="mb-4 text-lg font-extrabold text-gray-700 tracking-wide flex items-center gap-2">
    <i class="fa-solid fa-chart-line text-pink-500"></i> Ringkasan Kinerja
</h3>
<div class="grid gap-6 mb-8 md:grid-cols-2 xl:grid-cols-4">

    <div
        class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group overflow-hidden">
        <div
            class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-pink-50 group-hover:scale-150 transition-transform duration-700 ease-in-out z-0">
        </div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Total Anggota</p>
                <h4 class="text-3xl font-black text-gray-800">{{ $totalAnggota }} <span
                        class="text-sm font-bold text-gray-400">Orang</span></h4>
            </div>
            <div
                class="w-14 h-14 flex items-center justify-center rounded-xl bg-gradient-to-br from-pink-400 to-rose-600 text-white shadow-lg shadow-pink-200">
                <i class="fa-solid fa-users text-2xl"></i>
            </div>
        </div>
    </div>

    <div
        class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group overflow-hidden">
        <div
            class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-green-50 group-hover:scale-150 transition-transform duration-700 ease-in-out z-0">
        </div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Kas Masuk</p>
                <h4 class="text-2xl font-black text-gray-800">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</h4>
                <p class="text-[10px] text-gray-400 font-semibold mt-1">Daftar + Simpanan + Angsuran</p>
            </div>
            <div
                class="w-14 h-14 flex items-center justify-center rounded-xl bg-gradient-to-br from-emerald-400 to-green-600 text-white shadow-lg shadow-green-200">
                <i class="fa-solid fa-vault text-2xl"></i>
            </div>
        </div>
    </div>

    <div
        class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group overflow-hidden">
        <div
            class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-blue-50 group-hover:scale-150 transition-transform duration-700 ease-in-out z-0">
        </div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Pinjaman Keluar</p>
                <h4 class="text-2xl font-black text-gray-800">Rp {{ number_format($totalPinjamanKeluar, 0, ',', '.') }}
                </h4>
                <p class="text-[10px] text-gray-400 font-semibold mt-1">Total pencairan dana</p>
            </div>
            <div
                class="w-14 h-14 flex items-center justify-center rounded-xl bg-gradient-to-br from-cyan-400 to-blue-600 text-white shadow-lg shadow-blue-200">
                <i class="fa-solid fa-hand-holding-dollar text-2xl"></i>
            </div>
        </div>
    </div>

    <div
        class="relative bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group overflow-hidden">
        <div
            class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-amber-50 group-hover:scale-150 transition-transform duration-700 ease-in-out z-0">
        </div>
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <p class="text-sm font-bold text-gray-500 mb-1 uppercase tracking-wider">Luas Lahan</p>
                <h4 class="text-3xl font-black text-gray-800">{{ $totalLahan }} <span
                        class="text-sm font-bold text-gray-400">Ha</span></h4>
            </div>
            <div
                class="w-14 h-14 flex items-center justify-center rounded-xl bg-gradient-to-br from-yellow-400 to-amber-600 text-white shadow-lg shadow-amber-200">
                <i class="fa-solid fa-seedling text-2xl"></i>
            </div>
        </div>
    </div>

</div>
