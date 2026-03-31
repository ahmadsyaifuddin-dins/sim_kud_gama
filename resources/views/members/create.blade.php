<x-app-layout>
    <x-slot name="header">
        {{ __('Tambah Anggota Baru') }}
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 border-t-4 border-t-purple-600">

                    <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @include('members._form')

                        <div class="flex justify-end gap-3 mt-8 pt-5 border-t border-gray-200">
                            <a href="{{ route('members.index') }}"
                                class="px-5 py-2.5 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition font-bold flex items-center">
                                <i class="fa-solid fa-arrow-left mr-2"></i> Batal
                            </a>
                            <button type="submit"
                                class="px-5 py-2.5 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition font-bold shadow-md flex items-center gap-2">
                                <i class="fa-solid fa-save"></i> Simpan Data Anggota
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
