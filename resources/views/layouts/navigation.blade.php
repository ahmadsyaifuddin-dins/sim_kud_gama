<div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false"
    class="fixed z-20 inset-0 bg-pink-900 opacity-50 transition-opacity lg:hidden"></div>

<div :class="sidebarOpen ? 'translate-x-0 ease-out' : '-translate-x-full ease-in'"
    class="fixed z-30 inset-y-0 left-0 w-64 transition duration-300 transform bg-pink-700 overflow-y-auto lg:translate-x-0 lg:static lg:inset-0 border-r border-pink-500 shadow-xl">

    <div class="flex items-center justify-center mt-8 mb-6">
        <div class="flex flex-col items-center gap-2">
            <div class="bg-white p-1 rounded-full shadow-lg">
                <img src="{{ asset('logo/kud-logo.jpg') }}" alt="Logo KUD" class="h-16 w-16 rounded-full object-cover">
            </div>
            <span class="text-white text-xl font-bold tracking-wide mt-2">
                KUD GAMA
            </span>
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
            </div>
        @endif

    </nav>
</div>
