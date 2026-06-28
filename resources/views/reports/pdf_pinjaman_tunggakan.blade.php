@extends('reports.layout_pdf')

@section('content')
<style>
    /* Identitas warna merah muda khas laporan tunggakan */
    .data-table th { background-color: #FFAFAF !important; }
</style>

<table class="data-table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="30%">Nama Anggota</th>
            <th width="20%">Tgl Cair</th>
            <th width="15%">Tenor</th>
            <th width="30%">Total Pinjaman (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    {{ $item->member->nama_lengkap }} <br> 
                    <small style="color: #666;">Kontak: {{ $item->member->no_hp ?? '-' }}</small>
                </td>
                <td class="text-center">
                    {{ $item->tanggal_pencairan ? \Carbon\Carbon::parse($item->tanggal_pencairan)->translatedFormat('d M Y') : '-' }}
                </td>
                <td class="text-center">{{ $item->lama_angsuran }} Bln</td>
                <td class="text-right">{{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 10px;">
                    <em>Tidak ada data pinjaman yang tertunggak.</em>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection