@extends('reports.layout_pdf')

@section('content')
<style>
    /* Identitas warna netral untuk data master */
    .data-table th { background-color: #f3f4f6 !important; }
</style>

<table class="data-table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="30%">Nama Lengkap</th>
            <th width="25%">Jabatan</th>
            <th width="20%">Periode</th>
            <th width="20%">No. Handphone</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nama }}</td>
                <td class="text-center" style="font-weight: bold;">{{ strtoupper($item->jabatan) }}</td>
                <td class="text-center">{{ $item->periode_mulai }} - {{ $item->periode_selesai }}</td>
                <td class="text-center">{{ $item->no_hp ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 10px;">
                    <em>Data pengurus belum tersedia.</em>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection