<x-app-layout>
    <x-slot name="header">
        {{ __('Data Pengurus Koperasi') }}
    </x-slot>

    <div class="p-6 bg-gray-50 min-h-screen">

        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-700">Struktur Organisasi</h2>
                <p class="text-sm text-gray-500">Kelola data ketua, sekretaris, bendahara, dan staf lainnya.</p>
            </div>

            <a href="{{ route('managements.create') }}"
                class="flex items-center px-5 py-2.5 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-pink-600 border border-transparent rounded-lg active:bg-pink-600 hover:bg-pink-700 focus:outline-none focus:shadow-outline-pink shadow-md">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Pengurus
            </a>
        </div>

        <x-alerts.success class="mb-6" />

        <div class="w-full overflow-hidden rounded-xl shadow-xs bg-white border border-gray-200">
            <div class="w-full overflow-x-auto">
                <table class="w-full whitespace-no-wrap">
                    <thead>
                        <tr
                            class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-100">
                            <th class="px-4 py-4 text-center w-12">No</th>
                            <th class="px-4 py-4">Nama Pengurus</th>
                            <th class="px-4 py-4">Jabatan</th>
                            <th class="px-4 py-4 text-center">Periode</th>
                            <th class="px-4 py-4 text-center">Status</th>
                            <th class="px-4 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y">
                        @forelse($managements as $index => $item)
                            <tr class="text-gray-700 hover:bg-gray-50 transition duration-150">
                                <td class="px-4 py-3 text-sm text-center">
                                    {{ $managements->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center text-sm">
                                        <div class="relative hidden w-10 h-10 mr-3 rounded-full md:block">
                                            <img class="object-cover w-full h-full rounded-full border"
                                                src="{{ $item->foto ? asset($item->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($item->nama) }}"
                                                alt="" loading="lazy" />
                                        </div>
                                        <div>
                                            <p class="font-bold text-gray-800">{{ $item->nama }}</p>
                                            <p class="text-xs text-gray-500">{{ $item->no_hp ?? '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-pink-700">
                                    {{ $item->jabatan }}
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    {{ $item->periode_mulai }} - {{ $item->periode_selesai }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if ($item->is_active)
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full text-xs">
                                            Menjabat
                                        </span>
                                    @else
                                        <span
                                            class="px-2 py-1 font-semibold leading-tight text-gray-700 bg-gray-200 rounded-full text-xs">
                                            Demisioner
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a href="{{ route('managements.edit', $item->id) }}"
                                            class="p-2 text-white bg-purple-500 rounded-lg hover:bg-purple-600 shadow-sm transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                                </path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('managements.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus data pengurus ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="p-2 text-white bg-red-500 rounded-lg hover:bg-red-600 shadow-sm transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">Belum ada data pengurus.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-4 py-3 border-t bg-gray-50">
                {{ $managements->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
