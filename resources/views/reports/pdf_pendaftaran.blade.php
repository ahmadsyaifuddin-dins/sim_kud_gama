@extends('reports.layout_pdf')

@section('content')
<style>
    /* Identitas warna kuning untuk Laporan Pendaftaran */
    .data-table th { background-color: #fef08a !important; }
</style>

<table class="data-table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="20%">Tgl Pembayaran</th>
            <th width="35%">Nama Anggota</th>
            <th width="20%">Status Bukti</th>
            <th width="20%">Nominal (Rp)</th>
        </tr>
    </thead>
    <tbody>
        {{-- Menggunakan $data sesuai standar arsitektur --}}
        @forelse($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">
                    {{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->translatedFormat('d M Y') : '-' }}
                </td>
                <td>
                    {{ $item->nama_lengkap }}<br>
                    <small style="color: #666;">{{ $item->nomor_anggota }}</small>
                </td>
                <td class="text-center">
                    {{ $item->file_bukti_bayar ? 'Terlampir' : 'Tidak Ada' }}
                </td>
                <td class="text-right">
                    {{ number_format($item->biaya_pendaftaran, 0, ',', '.') }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 10px;">
                    <em>Tidak ada transaksi pembayaran pendaftaran di periode ini.</em>
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr style="background-color: #fef9c3;">
            <td colspan="4" class="text-right font-bold" style="padding-right: 10px;">
                TOTAL PEMASUKAN PENDAFTARAN
            </td>
            <td class="text-right font-bold">
                {{ number_format($totalPemasukan, 0, ',', '.') }}
            </td>
        </tr>
    </tfoot>
</table>
@endsection