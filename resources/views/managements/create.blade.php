<x-app-layout>
    <x-slot name="header">
        {{ __('Tambah Pengurus Baru') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-alerts.error />

                    <form action="{{ route('managements.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('managements._form')

                        <div class="flex items-center justify-end gap-3 mt-8 pt-4 border-t border-gray-200">
                            <a href="{{ route('managements.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition font-medium">
                                <i class="fa-solid fa-arrow-left mr-2"></i> Batal
                            </a>
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 focus:ring-4 focus:ring-pink-300 transition font-medium shadow-sm">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Pengurus
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
