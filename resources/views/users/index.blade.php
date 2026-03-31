<x-app-layout>
    <x-slot name="header">
        {{ __('Manajemen Pengguna (Users)') }}
    </x-slot>

    <x-alerts.success />

    <div class="flex justify-between items-center mb-6">
        <div class="inline-flex overflow-hidden bg-white rounded-lg shadow-md border border-blue-100">
            <div class="flex justify-center items-center w-12 bg-blue-600">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
            </div>
            <div class="px-4 py-2">
                <span class="font-bold text-blue-600 text-lg">{{ $users->total() }}</span>
                <p class="text-xs text-gray-500 uppercase tracking-wider font-semibold">Total Pengguna</p>
            </div>
        </div>

        <a href="{{ route('users.create') }}"
            class="px-5 py-2 text-sm font-bold text-white transition-colors duration-150 bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Tambah User Baru
        </a>
    </div>

    <div class="overflow-hidden min-w-full rounded-lg shadow-md border border-gray-200">
        <table class="min-w-full leading-normal">
            <thead>
                <tr>
                    <th
                        class="px-5 py-3 text-xs font-bold text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                        Nama Pengguna</th>
                    <th
                        class="px-5 py-3 text-xs font-bold text-left text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                        Email</th>
                    <th
                        class="px-5 py-3 text-xs font-bold text-center text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                        Role</th>
                    <th
                        class="px-5 py-3 text-xs font-bold text-center text-gray-600 uppercase bg-gray-100 border-b-2 border-gray-200">
                        Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-5 py-4 text-sm bg-white border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 w-10 h-10">
                                    <img class="w-full h-full rounded-full border-2 border-blue-100"
                                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=1d4ed8&background=eff6ff"
                                        alt="Avatar" />
                                </div>
                                <div class="ml-3">
                                    <p class="text-gray-900 font-bold">{{ $user->name }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 text-sm bg-white border-b border-gray-200">
                            <p class="text-gray-600">{{ $user->email }}</p>
                        </td>
                        <td class="px-5 py-4 text-sm bg-white border-b border-gray-200 text-center">
                            @if ($user->role === 'admin')
                                <span
                                    class="px-3 py-1 text-[10px] font-black uppercase tracking-widest text-blue-700 bg-blue-100 rounded-full border border-blue-200">Administrator</span>
                            @else
                                <span
                                    class="px-3 py-1 text-[10px] font-black uppercase tracking-widest text-green-700 bg-green-100 rounded-full border border-green-200">Pimpinan</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 text-sm bg-white border-b border-gray-200 text-center">
                            <div class="flex justify-center space-x-3">
                                <a href="{{ route('users.edit', $user->id) }}"
                                    class="text-indigo-600 hover:text-indigo-900 transition p-1 rounded-md hover:bg-indigo-50">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </a>

                                <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="text-red-600 hover:text-red-900 transition p-1 rounded-md hover:bg-red-50 {{ Auth::id() == $user->id ? 'hidden' : '' }}">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="px-5 py-5 bg-white border-t">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
