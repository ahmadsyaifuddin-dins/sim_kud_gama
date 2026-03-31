<x-app-layout>
    <x-slot name="header">
        Edit Pengajuan Pinjaman
    </x-slot>

    <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-pink-600">
        <x-alerts.error />

        <form action="{{ route('pinjaman.update', $pinjaman->id) }}" method="POST">
            @method('PUT')

            @include('pinjaman._form')

            <div class="mt-6 flex justify-end gap-3">
                <a href="{{ route('pinjaman.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">Batal</a>
                <button type="submit"
                    class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 transition">Update Data</button>
            </div>
        </form>
    </div>
</x-app-layout>
