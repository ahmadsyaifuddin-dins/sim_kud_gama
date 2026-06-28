@extends('reports.layout_pdf')

@section('content')
<style>
    /* Pertahankan warna biru khas laporan simpanan */
    .data-table th { background-color: #dbeafe !important; }
</style>

<table class="data-table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="15%">Tanggal Setor</th>
            <th width="25%">Nama Anggota</th>
            <th width="15%">Jenis Simpanan</th>
            <th width="20%">Keterangan</th>
            <th width="20%">Nominal (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @php $totalNominal = 0; @endphp
        
        {{-- Menggunakan $data sesuai arsitektur Trait kita --}}
        @forelse($data as $index => $item)
            @php $totalNominal += $item->jumlah; @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">
                    {{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->translatedFormat('d M Y') : '-' }}
                </td>
                <td>
                    {{ $item->member->nama_lengkap ?? 'Anggota Dihapus' }} <br>
                    <small style="color: #666;">{{ $item->member->nomor_anggota ?? '-' }}</small>
                </td>
                <td class="text-center" style="text-transform: capitalize;">{{ $item->jenis_simpanan }}</td>
                <td>{{ $item->keterangan ?? '-' }}</td>
                <td class="text-right">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 10px;">
                    <em>Tidak ada transaksi simpanan pada periode ini.</em>
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr style="background-color: #f3f4f6; font-weight: bold;">
            <td colspan="5" class="text-right" style="padding-right: 10px;">TOTAL SETORAN :</td>
            <td class="text-right">Rp {{ number_format($totalNominal, 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>
@endsection