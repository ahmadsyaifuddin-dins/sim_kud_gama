<h3 class="mb-4 text-lg font-extrabold text-gray-700 tracking-wide flex items-center gap-2 mt-4">
    <i class="fa-solid fa-bell text-orange-500"></i> Status & Notifikasi Operasional
</h3>
<div class="grid gap-6 mb-8 md:grid-cols-4">

    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-full bg-green-100 text-green-600">
            <i class="fa-solid fa-user-check text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase">Anggota Aktif</p>
            <p class="text-2xl font-black text-gray-800">{{ $statusCounts['active'] }}</p>
        </div>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center gap-4">
        <div class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-full bg-yellow-100 text-yellow-600">
            <i class="fa-solid fa-user-clock text-xl"></i>
        </div>
        <div>
            <p class="text-xs font-bold text-gray-500 uppercase">Pasif / Cuti</p>
            <p class="text-2xl font-black text-gray-800">{{ $statusCounts['inactive'] }}</p>
        </div>
    </div>

    <div
        class="{{ $belumCetak > 0 ? 'bg-gradient-to-r from-red-50 to-white border-red-200' : 'bg-white border-gray-100' }} p-5 rounded-2xl shadow-sm border flex items-center gap-4 relative overflow-hidden">
        <div
            class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-full {{ $belumCetak > 0 ? 'bg-red-100 text-red-600 animate-bounce' : 'bg-gray-100 text-gray-400' }}">
            <i class="fa-solid fa-id-card text-xl"></i>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-bold {{ $belumCetak > 0 ? 'text-red-600' : 'text-gray-500' }} uppercase">Belum Cetak
                KTA</p>
            <p class="text-2xl font-black {{ $belumCetak > 0 ? 'text-red-700' : 'text-gray-800' }}">{{ $belumCetak }}
            </p>
        </div>
    </div>

    <div
        class="{{ $pinjamanPending > 0 ? 'bg-gradient-to-r from-orange-50 to-white border-orange-200' : 'bg-white border-gray-100' }} p-5 rounded-2xl shadow-sm border flex items-center gap-4 relative overflow-hidden">
        <div
            class="w-12 h-12 flex-shrink-0 flex items-center justify-center rounded-full {{ $pinjamanPending > 0 ? 'bg-orange-100 text-orange-600 animate-pulse' : 'bg-gray-100 text-gray-400' }}">
            <i class="fa-solid fa-file-signature text-xl"></i>
        </div>
        <div class="relative z-10">
            <p class="text-xs font-bold {{ $pinjamanPending > 0 ? 'text-orange-600' : 'text-gray-500' }} uppercase">
                Pinjaman Pending</p>
            <p class="text-2xl font-black {{ $pinjamanPending > 0 ? 'text-orange-700' : 'text-gray-800' }}">
                {{ $pinjamanPending }}</p>
        </div>
    </div>

</div>
