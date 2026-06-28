@extends('reports.layout_pdf')

@section('content')
<style>
    /* Warna rose muda khas laporan kolektibilitas */
    .data-table th { background-color: #FFAFAF !important; }

    /* CSS Status tetap dipertahankan */
    .status-lunas { color: #166534; font-weight: bold; }
    .status-angsuran { color: #854d0e; font-weight: bold; }
    .status-macet { color: #991b1b; font-weight: bold; }
</style>

<table class="data-table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="20%">Nama Anggota</th>
            <th width="15%">Pinjaman (Rp)</th>
            <th width="15%">Terbayar (Rp)</th>
            <th width="15%">Sisa Hutang (Rp)</th>
            <th width="20%">Status Kolektibilitas</th>
        </tr>
    </thead>
    <tbody>
        {{-- Menggunakan $data sesuai standar arsitektur --}}
        @forelse($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    {{ $item->member->nama_lengkap }} <br> 
                    <small style="color: #666;">Tgl Cair: {{ $item->tanggal_pencairan ? \Carbon\Carbon::parse($item->tanggal_pencairan)->translatedFormat('d M Y') : '-' }}</small>
                </td>
                <td class="text-right">{{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->total_terbayar, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->sisa_hutang, 0, ',', '.') }}</td>
                <td class="text-center">
                    @if ($item->kolektibilitas == 'Lunas')
                        <span class="status-lunas">{{ $item->kolektibilitas }}</span>
                    @elseif($item->kolektibilitas == 'Dalam Angsuran')
                        <span class="status-angsuran">{{ $item->kolektibilitas }}</span>
                    @else
                        <span class="status-macet">{{ $item->kolektibilitas }}</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 10px;">
                    <em>Tidak ada data evaluasi pinjaman.</em>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection