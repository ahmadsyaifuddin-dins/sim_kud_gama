@extends('reports.layout_pdf')

@section('content')
<style>
    /* Identitas warna pink khas laporan realisasi pencairan */
    .data-table th { background-color: #FFAFAF !important; }
</style>

<table class="data-table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="15%">Tanggal Cair</th>
            <th width="25%">Nama Peminjam</th>
            <th width="25%">Keperluan Kredit</th>
            <th width="10%">Tenor</th>
            <th width="20%">Nominal Cair (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @php $totalPencairan = 0; @endphp
        
        @forelse($data as $index => $item)
            @php $totalPencairan += $item->jumlah_pinjaman; @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">
                    {{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->translatedFormat('d M Y') : '-' }}
                </td>
                <td>
                    {{ $item->member->nama_lengkap ?? 'Anggota Dihapus' }}
                </td>
                <td>{{ $item->keperluan }}</td>
                <td class="text-center">{{ $item->lama_angsuran }} Bln</td>
                <td class="text-right">{{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 10px;">
                    <em>Tidak ada realisasi pencairan pinjaman pada periode ini.</em>
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr style="background-color: #f3f4f6; font-weight: bold;">
            <td colspan="5" class="text-right" style="padding-right: 10px;">TOTAL UANG KELUAR :</td>
            <td class="text-right">Rp {{ number_format($totalPencairan, 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>
@endsection