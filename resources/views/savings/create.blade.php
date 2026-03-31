<x-app-layout>
    <x-slot name="header">
        {{ __('Catat Transaksi Baru') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 border-t-4 border-t-pink-600">

                    <x-alerts.error />

                    <form action="{{ route('savings.store') }}" method="POST" enctype="multipart/form-data">
                        @include('savings._form')

                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                            <a href="{{ route('savings.index') }}"
                                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition font-medium">Batal</a>
                            <button type="submit"
                                class="px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 transition font-medium flex items-center gap-2">
                                <i class="fa-solid fa-save"></i> Simpan Transaksi
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
