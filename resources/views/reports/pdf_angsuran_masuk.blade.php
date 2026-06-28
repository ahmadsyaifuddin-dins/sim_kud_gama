@extends('reports.layout_pdf')

@section('content')
<style>
    /* Identitas warna hijau untuk laporan angsuran masuk */
    .data-table th { background-color: #d1fae5 !important; }
</style>

<table class="data-table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="20%">Tanggal Bayar</th>
            <th width="30%">Nama Anggota (Peminjam)</th>
            <th width="15%">Angsuran Ke</th>
            <th width="30%">Nominal Bayar (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">
                    {{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->translatedFormat('d M Y') : '-' }}
                </td>
                <td>{{ $item->pinjaman->member->nama_lengkap ?? 'Anggota Dihapus' }}</td>
                <td class="text-center">Ke-{{ $item->angsuran_ke }}</td>
                <td class="text-right">{{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 10px;">
                    <em>Tidak ada angsuran masuk pada periode ini.</em>
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr style="background-color: #f0fdf4; font-weight: bold;">
            <td colspan="4" class="text-right" style="padding: 10px;">TOTAL PEMASUKAN ANGSURAN :</td>
            <td class="text-right" style="padding: 10px;">
                Rp {{ number_format($totalAngsuran, 0, ',', '.') }}
            </td>
        </tr>
    </tfoot>
</table>
@endsection