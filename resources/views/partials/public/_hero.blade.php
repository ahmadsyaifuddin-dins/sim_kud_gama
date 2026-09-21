<section id="beranda" class="relative overflow-hidden pb-20 pt-28 lg:pt-36">
    {{-- Aurora latar --}}
    <div class="absolute inset-0 bg-gradient-to-br from-pink-100 via-rose-50 to-fuchsia-100"></div>
    <div class="absolute -left-24 -top-24 h-96 w-96 rounded-full bg-pink-300/50 blur-3xl"></div>
    <div class="absolute -right-20 top-1/3 h-80 w-80 rounded-full bg-fuchsia-300/40 blur-3xl"></div>
    <div class="absolute bottom-0 left-1/3 h-64 w-64 rounded-full bg-rose-300/30 blur-3xl"></div>

    <div class="relative mx-auto max-w-4xl px-4 text-center">
        @if (session('success'))
            <div
                class="mb-8 inline-flex items-center gap-3 rounded-2xl border border-green-300 bg-green-100 px-5 py-3 text-sm font-semibold text-green-700 shadow-sm">
                <i class="fa-solid fa-circle-check text-lg"></i> {{ session('success') }}
            </div>
        @endif

        <span
            class="inline-flex items-center gap-2 rounded-full border border-pink-200 bg-white/70 px-4 py-1.5 text-xs font-bold tracking-wide text-pink-700 shadow-sm backdrop-blur">
            <i class="fa-solid fa-heart text-rose-500"></i> Koperasi Unit Desa Gajah Mada
        </span>

        <h1 class="mt-6 text-4xl font-extrabold leading-tight text-gray-900 md:text-6xl">
            Selamat Datang di
            <span
                class="mt-1 block bg-gradient-to-r from-pink-600 via-rose-500 to-fuchsia-600 bg-clip-text pb-1 leading-snug text-transparent">
                KUD Gajah Mada
            </span>
        </h1>

        <p class="mx-auto mt-6 max-w-2xl text-lg leading-relaxed text-gray-600">
            Desa Telaga Sari, Kec. Kelumpang Hilir, Kab. Kotabaru.
            Mewujudkan kesejahteraan anggota melalui pengelolaan lahan sawit yang transparan dan profesional.
        </p>

        <div class="mt-9 flex flex-col items-center justify-center gap-4 sm:flex-row">
            <a href="{{ route('public.register') }}"
                class="group inline-flex w-full items-center justify-center gap-2 rounded-full bg-gradient-to-r from-pink-600 via-rose-500 to-fuchsia-600 px-8 py-3.5 font-bold text-white shadow-xl shadow-pink-300/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl hover:shadow-pink-400/60 sm:w-auto">
                <i class="fa-solid fa-user-plus"></i> Daftar Jadi Anggota Sekarang
                <i class="fa-solid fa-arrow-right text-sm transition-transform group-hover:translate-x-1"></i>
            </a>
            <a href="#fitur"
                class="inline-flex w-full items-center justify-center gap-2 rounded-full border border-pink-300 bg-white/80 px-8 py-3.5 font-bold text-pink-700 shadow-lg backdrop-blur transition-all duration-300 hover:-translate-y-1 hover:bg-pink-50 sm:w-auto">
                <i class="fa-solid fa-binoculars"></i> Cek Status
            </a>
        </div>

        <div class="mt-14 flex flex-wrap items-center justify-center gap-3 text-xs font-bold">
            <span
                class="inline-flex items-center gap-2 rounded-full border border-pink-100 bg-white/70 px-4 py-2 text-pink-700 shadow-sm backdrop-blur">
                <i class="fa-solid fa-piggy-bank text-fuchsia-500"></i> Simpanan Digital
            </span>
            <span
                class="inline-flex items-center gap-2 rounded-full border border-pink-100 bg-white/70 px-4 py-2 text-pink-700 shadow-sm backdrop-blur">
                <i class="fa-solid fa-hand-holding-dollar text-rose-500"></i> Pinjaman & SHU
            </span>
            <span
                class="inline-flex items-center gap-2 rounded-full border border-pink-100 bg-white/70 px-4 py-2 text-pink-700 shadow-sm backdrop-blur">
                <i class="fa-solid fa-qrcode text-fuchsia-500"></i> Kartu Anggota QR
            </span>
        </div>
    </div>
</section>