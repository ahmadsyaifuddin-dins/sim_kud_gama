<div :class="sidebarOpen ? 'block' : 'hidden'" @click="sidebarOpen = false"
    class="fixed z-20 inset-0 bg-pink-900 opacity-50 transition-opacity lg:hidden"></div>

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
                MENU UTAMA
            </p>
            <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                <x-slot name="icon">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                    </svg>
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
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </x-slot>
                    {{ __('Data Anggota') }}
                </x-nav-link>

                <x-nav-link href="{{ route('savings.index') }}" :active="request()->routeIs('savings.*')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </x-slot>
                    {{ __('Iuran & Simpanan') }}
                </x-nav-link>

                <x-nav-link href="{{ route('pinjaman.index') }}" :active="request()->routeIs('pinjaman.*')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </x-slot>
                    {{ __('Pinjaman Anggota') }}
                </x-nav-link>

                <x-nav-link href="{{ route('angsuran.index') }}" :active="request()->routeIs('angsuran.*')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                        </svg>
                    </x-slot>
                    {{ __('Pembayaran Angsuran') }}
                </x-nav-link>

                <x-nav-link href="{{ route('managements.index') }}" :active="request()->routeIs('managements.*')">
                    <x-slot name="icon">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z" />
                        </svg>
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
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
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
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </x-slot>
                    {{ __('Admin / Pengguna') }}
                </x-nav-link>
            </div>
        @endif

    </nav>
</div>
