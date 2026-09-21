<section class="relative overflow-hidden bg-gradient-to-r from-pink-700 via-rose-600 to-fuchsia-700 py-12">
    <div class="absolute inset-0 opacity-20"
        style="background-image: radial-gradient(circle at 15% 30%, rgba(255,255,255,.4) 0, transparent 40%), radial-gradient(circle at 85% 75%, rgba(255,255,255,.3) 0, transparent 40%);">
    </div>
    <div class="relative mx-auto grid max-w-6xl grid-cols-2 gap-8 px-4 text-center text-white md:grid-cols-4">
        <div class="reveal">
            <div class="text-3xl font-extrabold drop-shadow-sm md:text-4xl">
                {{ number_format($totalAnggota, 0, ',', '.') }}+
            </div>
            <p class="mt-1 text-xs font-semibold uppercase tracking-widest text-pink-100 md:text-sm">Anggota Terdaftar</p>
        </div>
        <div class="reveal">
            <div class="text-3xl font-extrabold drop-shadow-sm md:text-4xl">
                Rp {{ number_format($totalSimpanan, 0, ',', '.') }}
            </div>
            <p class="mt-1 text-xs font-semibold uppercase tracking-widest text-pink-100 md:text-sm">Total Simpanan</p>
        </div>
        <div class="reveal">
            <div class="text-3xl font-extrabold drop-shadow-sm md:text-4xl">
                {{ number_format($totalPinjaman, 0, ',', '.') }}+
            </div>
            <p class="mt-1 text-xs font-semibold uppercase tracking-widest text-pink-100 md:text-sm">Pinjaman Terlayani</p>
        </div>
        <div class="reveal">
            <div class="text-3xl font-extrabold drop-shadow-sm md:text-4xl">
                Rp {{ number_format($totalShu, 0, ',', '.') }}
            </div>
            <p class="mt-1 text-xs font-semibold uppercase tracking-widest text-pink-100 md:text-sm">Total SHU Dibagikan</p>
        </div>
    </div>
</section>