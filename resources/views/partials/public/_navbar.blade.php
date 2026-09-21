<nav id="navbar"
    class="fixed inset-x-0 top-0 z-50 transition-all duration-300 {{ request()->routeIs('landing') ? '' : '' }}">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-16 items-center justify-between lg:h-20">
            <a href="#beranda" class="flex items-center gap-3">
                <div class="rounded-full bg-gradient-to-br from-pink-500 via-rose-500 to-fuchsia-600 p-[2px] shadow-lg shadow-pink-200/60">
                    <img src="{{ asset('logo/kud-logo.jpg') }}" alt="Logo KUD"
                        class="h-10 w-10 rounded-full border-2 border-white object-cover">
                </div>
                <div>
                    <span class="block text-lg font-extrabold leading-none tracking-wide text-pink-700">KUD GAMA</span>
                    <span class="mt-0.5 block text-[10px] font-semibold uppercase tracking-[0.25em] text-gray-500">Gajah Mada</span>
                </div>
            </a>

            <div class="hidden items-center gap-8 text-sm font-semibold text-gray-600 md:flex">
                <a href="#beranda" class="transition hover:text-pink-600">Beranda</a>
                <a href="#fitur" class="transition hover:text-pink-600">Fitur</a>
                <a href="#visi-misi" class="transition hover:text-pink-600">Visi & Misi</a>
                <a href="#kontak" class="transition hover:text-pink-600">Kontak</a>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ url('/dashboard') }}"
                        class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-pink-600 to-fuchsia-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-pink-300/50 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-pink-400/60">
                        <i class="fa-solid fa-gauge-high"></i> Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('public.register') }}"
                        class="hidden items-center gap-2 rounded-full border-2 border-pink-600 px-5 py-2.5 text-sm font-bold text-pink-600 transition hover:bg-pink-50 sm:inline-flex">
                        <i class="fa-solid fa-user-plus"></i> Daftar Anggota
                    </a>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 rounded-full bg-gradient-to-r from-pink-600 to-fuchsia-600 px-5 py-2.5 text-sm font-bold text-white shadow-lg shadow-pink-300/50 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-pink-400/60">
                        <i class="fa-solid fa-right-to-bracket"></i> Masuk
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>