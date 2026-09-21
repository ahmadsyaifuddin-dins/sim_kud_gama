<section id="kontak" class="relative overflow-hidden py-20">
    <div class="absolute inset-0 bg-gradient-to-br from-pink-700 via-rose-600 to-fuchsia-700"></div>
    <div class="absolute inset-0 opacity-15"
        style="background-image: radial-gradient(circle at 10% 20%, rgba(255,255,255,.4) 0, transparent 40%), radial-gradient(circle at 90% 80%, rgba(255,255,255,.3) 0, transparent 40%);">
    </div>

    <div class="relative mx-auto max-w-4xl px-4 text-center">
        <span
            class="inline-flex items-center gap-2 rounded-full border border-white/25 bg-white/10 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-pink-100 backdrop-blur">
            <i class="fa-solid fa-paper-plane"></i> Bergabunglah
        </span>
        <h2 class="mt-5 text-3xl font-extrabold text-white md:text-4xl">Siap Menjadi Anggota KUD Gajah Mada?</h2>
        <p class="mx-auto mt-4 max-w-xl text-pink-50/90">
            Daftarkan diri Anda sekarang dan nikmati kemudahan simpanan, pinjaman, serta pembagian SHU secara
            transparan.
        </p>
        <div class="mt-9 flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a href="{{ route('public.register') }}"
                class="group inline-flex w-full items-center justify-center gap-2 rounded-full bg-white px-8 py-3.5 font-bold text-pink-700 shadow-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl sm:w-auto">
                <i class="fa-solid fa-user-plus text-pink-600"></i> Daftar Jadi Anggota
                <i class="fa-solid fa-arrow-right text-sm transition-transform group-hover:translate-x-1"></i>
            </a>
            <a href="{{ route('login') }}"
                class="inline-flex w-full items-center justify-center gap-2 rounded-full border-2 border-white/60 px-8 py-3.5 font-bold text-white transition-all duration-300 hover:-translate-y-1 hover:bg-white/10 sm:w-auto">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk Admin
            </a>
        </div>

        <div class="mt-12 grid gap-5 border-t border-white/15 pt-10 text-white sm:grid-cols-3">
            <div class="flex flex-col items-center gap-2 text-sm">
                <i class="fa-solid fa-location-dot text-2xl text-pink-200"></i>
                <p class="font-bold">Alamat</p>
                <p class="text-pink-100/85">Desa Telaga Sari, Kec. Kelumpang Hilir, Kab. Kotabaru</p>
            </div>
            <div class="flex flex-col items-center gap-2 text-sm">
                <i class="fa-solid fa-clock text-2xl text-pink-200"></i>
                <p class="font-bold">Jam Operasional</p>
                <p class="text-pink-100/85">Senin – Sabtu, 08.00 – 16.00 WITA</p>
            </div>
            <div class="flex flex-col items-center gap-2 text-sm">
                <i class="fa-solid fa-chart-pie text-2xl text-pink-200"></i>
                <p class="font-bold">Sistem</p>
                <p class="text-pink-100/85">SIM KUD GAMA — Manajemen digital koperasi</p>
            </div>
        </div>
    </div>
</section>