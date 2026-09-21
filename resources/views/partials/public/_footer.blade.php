<footer class="bg-gray-900 py-10 text-white">
    <div class="mx-auto max-w-6xl px-4">
        <div class="flex flex-col items-center justify-between gap-6 md:flex-row">
            <div class="flex items-center gap-3">
                <div class="rounded-full bg-gradient-to-br from-pink-500 via-rose-500 to-fuchsia-600 p-[2px]">
                    <img src="{{ asset('logo/kud-logo.jpg') }}" alt="Logo KUD"
                        class="h-9 w-9 rounded-full border-2 border-white object-cover">
                </div>
                <div>
                    <span class="block font-extrabold tracking-wide">KUD GAMA</span>
                    <span class="block text-[10px] font-semibold uppercase tracking-[0.25em] text-pink-300">Gajah Mada</span>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-6 text-sm font-semibold text-gray-400">
                <a href="#beranda" class="transition hover:text-pink-300">Beranda</a>
                <a href="#fitur" class="transition hover:text-pink-300">Fitur</a>
                <a href="#visi-misi" class="transition hover:text-pink-300">Visi & Misi</a>
                <a href="#kontak" class="transition hover:text-pink-300">Kontak</a>
            </div>

            <div class="flex items-center gap-3">
                <a href="#" aria-label="Facebook"
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-white/5 transition hover:bg-pink-600">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
                <a href="#" aria-label="Instagram"
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-white/5 transition hover:bg-pink-600">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" aria-label="WhatsApp"
                    class="flex h-10 w-10 items-center justify-center rounded-full bg-white/5 transition hover:bg-pink-600">
                    <i class="fa-brands fa-whatsapp"></i>
                </a>
            </div>
        </div>

        <div class="mt-8 border-t border-white/10 pt-6 text-center">
            <p>&copy; {{ date('Y') }} KUD Gajah Mada. All rights reserved.</p>
            <p class="mt-2 text-xs text-pink-300/80">Dibuat dengan <i class="fa-solid fa-heart text-rose-500"></i> untuk
                Desa Telaga Sari</p>
        </div>
    </div>
</footer>