<x-app-layout>
    <x-slot name="header">
        {{ __('Data Anggota KUD Gajah Mada') }}
    </x-slot>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div x-data="{ viewMode: localStorage.getItem('memberViewMode') || 'table' }" 
         x-init="$watch('viewMode', val => localStorage.setItem('memberViewMode', val))" 
         class="p-6 bg-gray-50 min-h-screen">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-700">Daftar Anggota</h2>
                <p class="text-sm text-gray-500">Kelola data anggota, verifikasi pendaftaran, dan cetak kartu.</p>
            </div>

            <div class="flex items-center gap-4 w-full md:w-auto justify-between">
                <div class="flex items-center p-1 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <button @click="viewMode = 'table'" 
                            :class="viewMode === 'table' ? 'bg-pink-100 text-pink-700' : 'text-gray-400 hover:text-gray-600'" 
                            class="px-3 py-1.5 rounded-md text-sm font-semibold transition-colors duration-200" title="Table View Mode">
                        <i class="fa-solid fa-table-list"></i>
                    </button>
                    <button @click="viewMode = 'card'" 
                            :class="viewMode === 'card' ? 'bg-pink-100 text-pink-700' : 'text-gray-400 hover:text-gray-600'" 
                            class="px-3 py-1.5 rounded-md text-sm font-semibold transition-colors duration-200" title="Card View Mode">
                        <i class="fa-solid fa-address-card"></i>
                    </button>
                </div>

                <a href="{{ route('members.create') }}"
                    class="flex items-center px-5 py-2.5 text-sm font-bold leading-5 text-white transition-colors duration-150 bg-pink-600 border border-transparent rounded-lg active:bg-pink-600 hover:bg-pink-700 shadow-md">
                    <i class="fa-solid fa-user-plus mr-2 text-lg"></i> Tambah Anggota
                </a>
            </div>
        </div>

        <x-alerts.success class="mb-6" />
        <x-alerts.error class="mb-6" />

        @include('members.partials.index.table')
        @include('members.partials.index.card')

        @if ($members->hasPages())
            <div class="mt-6 px-4 py-3 border-t bg-gray-50 rounded-lg shadow-sm">
                {{ $members->links() }}
            </div>
        @endif

    </div>
</x-app-layout>