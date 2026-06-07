<x-app-layout>
    <x-slot name="header">
        {{ __('Input Pembayaran Angsuran') }}
    </x-slot>

    <div class="bg-white p-6 rounded-lg shadow-md border-t-4 border-pink-600">
        <x-alerts.error />

        <form action="{{ route('angsuran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf @include('angsuran._form')

            <div class="flex items-center justify-end gap-3 mt-8 pt-4 border-t border-slate-200">
                <a href="{{ route('angsuran.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-slate-200 text-slate-700 rounded-md hover:bg-slate-300 transition font-medium">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Batal
                </a>
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-pink-600 text-white rounded-md hover:bg-pink-700 focus:ring-4 focus:ring-pink-300 transition font-medium shadow-sm">
                    <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Angsuran
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
