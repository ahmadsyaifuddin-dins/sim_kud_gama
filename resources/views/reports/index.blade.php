<x-app-layout>
    <x-slot name="header">
        {{ __('Pusat Laporan & Arsip KUD Gajah Mada') }}
    </x-slot>

    <div class="mb-6">
        <p class="text-slate-600">Pilih jenis laporan yang ingin Anda unduh. Sistem secara otomatis akan memproses data
            sesuai parameter yang Anda tentukan.</p>
    </div>

    <div class="flex flex-col gap-10">
        @include('reports.partials._anggota', ['dusunList' => $dusunList])

        @include('reports.partials._keuangan')

        @include('reports.partials._pinjaman')

        @include('reports.partials._sistem')
    </div>
</x-app-layout>
