<div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false"
    class="fixed z-20 inset-0 bg-pink-900 opacity-50 transition-opacity lg:hidden"></div>

<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
    class="fixed z-30 inset-y-0 left-0 w-70 transition duration-300 transform bg-pink-700 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0 border-r border-pink-500 shadow-xl">

    <div class="relative flex items-center justify-center mt-8 mb-6 pt-1">
        {{-- Glow aurora di belakang --}}
        <div
            class="absolute h-24 w-44 bg-gradient-to-br from-pink-400/40 via-fuchsia-400/25 to-transparent blur-2xl rounded-full pointer-events-none animate-pulse">
        </div>

        <div class="relative flex flex-col items-center gap-3">
            {{-- Logo dengan cincin gradien berputar --}}
            <div class="relative">
                <div
                    class="absolute -inset-1.5 rounded-full opacity-60 blur-[3px] bg-[conic-gradient(from_180deg_at_50%_50%,#fb7185,#c084fc,#f472b6,#fb7185)] animate-spin [animation-duration:8s]">
                </div>
                <div
                    class="relative h-20 w-20 rounded-full bg-gradient-to-br from-pink-300 via-white to-fuchsia-300 p-[3px] shadow-xl shadow-pink-900/40">
                    <div class="h-full w-full rounded-full bg-white overflow-hidden ring-1 ring-pink-200/60">
                        <img src="{{ asset('logo/kud-logo.jpg') }}" alt="Logo KUD"
                            class="h-full w-full rounded-full object-cover">
                    </div>
                </div>
                <span
                    class="absolute -bottom-0.5 -right-0.5 h-5 w-5 rounded-full bg-gradient-to-br from-fuchsia-400 to-pink-600 border-2 border-pink-700 flex items-center justify-center shadow-md">
                    <i class="fa-solid fa-bolt text-[8px] text-white"></i>
                </span>
            </div>

            {{-- Nama & tagline --}}
            <div class="relative text-center">
                <span
                    class="block text-2xl font-black tracking-[0.25em] bg-clip-text text-transparent bg-gradient-to-r from-pink-100 via-white to-fuchsia-200 drop-shadow-[0_2px_6px_rgba(236,72,153,0.35)]">
                    KUD GAMA
                </span>
                <div class="mt-1.5 flex items-center justify-center gap-2">
                    <span class="h-px w-8 bg-gradient-to-r from-transparent to-pink-300/80"></span>
                    <span class="text-[9px] font-bold tracking-[0.3em] text-pink-200/90 uppercase">Manajemen Sistem KUD</span>
                    <span class="h-px w-8 bg-gradient-to-l from-transparent to-pink-300/80"></span>
                </div>
                <span
                    class="mt-2.5 inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 backdrop-blur border border-white/15 text-[9px] font-bold text-pink-100 tracking-wider uppercase shadow-inner">
                    <i class="fa-solid fa-wand-magic-sparkles text-fuchsia-200 text-[9px]"></i>
                    SIMKUD GAMA 2.O
                </span>
            </div>
        </div>
    </div>

    <nav class="mt-4 px-2" x-data="{ isMultiLevelMenuOpen: false }">

        <div class="mb-6">
            <p class="px-4 text-[11px] font-bold text-pink-300 uppercase tracking-widest mb-2 opacity-80">
                Main Menu
            </p>
            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                <x-slot name="icon">
                    <i class="fa-solid fa-house text-lg w-6 text-center"></i>
                </x-slot>
                {{ __('Dashboard') }}
            </x-nav-link>

            <x-nav-link href="{{ route('guide.index') }}" :active="request()->routeIs('guide.*')">
                <x-slot name="icon">
                    <i class="fa-solid fa-compass text-lg w-6 text-center"></i>
                </x-slot>
                {{ __('Panduan Uji Coba') }}
            </x-nav-link>
        </div>

        @if (auth()->user()->role === 'admin')
            <div class="mb-6">
                <p class="px-4 text-[11px] font-bold text-pink-300 uppercase tracking-widest mb-2 opacity-80">
                    Operasional
                </p>

                <x-nav-link href="{{ route('members.index') }}" :active="request()->routeIs('members.*')">
                    <x-slot name="icon">
                        <i class="fa-solid fa-users text-lg w-6 text-center"></i>
                    </x-slot>
                    {{ __('Data Anggota') }}
                </x-nav-link>

                <x-nav-link href="{{ route('savings.index') }}" :active="request()->routeIs('savings.*')">
                    <x-slot name="icon">
                        <i class="fa-solid fa-piggy-bank text-lg w-6 text-center"></i>
                    </x-slot>
                    {{ __('Iuran & Simpanan') }}
                </x-nav-link>

                <x-nav-link href="{{ route('pinjaman.index') }}" :active="request()->routeIs('pinjaman.*')">
                    <x-slot name="icon">
                        <i class="fa-solid fa-hand-holding-dollar text-lg w-6 text-center"></i>
                    </x-slot>
                    {{ __('Pinjaman Anggota') }}
                </x-nav-link>

                <x-nav-link href="{{ route('angsuran.index') }}" :active="request()->routeIs('angsuran.*')">
                    <x-slot name="icon">
                        <i class="fa-solid fa-file-invoice-dollar text-lg w-6 text-center"></i>
                    </x-slot>
                    {{ __('Pembayaran Angsuran') }}
                </x-nav-link>

                <x-nav-link href="{{ route('periods.index') }}" :active="request()->routeIs('periods.*')">
                    <x-slot name="icon">
                        <i class="fa-solid fa-calendar-xmark text-lg w-6 text-center"></i>
                    </x-slot>
                    {{ __('Tutup Buku & Periode') }}
                </x-nav-link>

                <x-nav-link href="{{ route('shu.index') }}" :active="request()->routeIs('shu.*')">
                    <x-slot name="icon">
                        <i class="fa-solid fa-scale-balanced text-lg w-6 text-center"></i>
                    </x-slot>
                    {{ __('Pembagian SHU') }}
                </x-nav-link>

                <x-nav-link href="{{ route('managements.index') }}" :active="request()->routeIs('managements.*')">
                    <x-slot name="icon">
                        <i class="fa-solid fa-user-tie text-lg w-6 text-center"></i>
                    </x-slot>
                    {{ __('Data Pengurus') }}
                </x-nav-link>
            </div>
        @endif

        <div class="mb-6">
            <p class="px-4 text-[11px] font-bold text-pink-300 uppercase tracking-widest mb-2 opacity-80">
                Pelaporan
            </p>
            <x-nav-link href="{{ route('reports.index') }}" :active="request()->routeIs('reports.*')">
                <x-slot name="icon">
                    <i class="fa-solid fa-chart-pie text-lg w-6 text-center"></i>
                </x-slot>
                {{ __('Pusat Laporan') }}
            </x-nav-link>
        </div>

        @if (auth()->user()->role === 'admin')
            <div class="mb-6">
                <p class="px-4 text-[11px] font-bold text-pink-300 uppercase tracking-widest mb-2 opacity-80">
                    Pengaturan
                </p>
                <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')">
                    <x-slot name="icon">
                        <i class="fa-solid fa-users-gear text-lg w-6 text-center"></i>
                    </x-slot>
                    {{ __('Admin / Pengguna') }}
                </x-nav-link>

                <x-nav-link href="{{ route('settings.index') }}" :active="request()->routeIs('settings.*')">
                    <x-slot name="icon">
                        <i class="fa-solid fa-sliders text-lg w-6 text-center"></i>
                    </x-slot>
                    {{ __('Kebijakan & Pengaturan') }}
                </x-nav-link>
            </div>
        @endif

    </nav>
</div>
