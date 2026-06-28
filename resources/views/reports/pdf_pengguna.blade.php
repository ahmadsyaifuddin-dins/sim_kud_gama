@extends('reports.layout_pdf')

@section('content')
<style>
    /* Identitas warna slate untuk data pengguna */
    .data-table th { background-color: #e2e8f0 !important; }
</style>

<table class="data-table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="25%">Nama Pengguna</th>
            <th width="30%">Alamat Email</th>
            <th width="20%">Hak Akses (Role)</th>
            <th width="20%">Tgl Pembuatan</th>
        </tr>
    </thead>
    <tbody>
        {{-- Menggunakan $data sesuai standar arsitektur Trait --}}
        @forelse($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td class="text-center">{{ strtoupper($item->role) }}</td>
                <td class="text-center">
                    {{ $item->created_at ? $item->created_at->translatedFormat('d M Y H:i') : '-' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 10px;">
                    <em>Data pengguna tidak ditemukan.</em>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection