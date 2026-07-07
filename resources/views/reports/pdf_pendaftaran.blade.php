@extends('reports.layout_pdf')

@section('content')
    <style>
        /* Identitas warna kuning untuk Laporan Pendaftaran */
        .data-table th {
            background-color: #fef08a !important;
        }
    </style>

    <table class="data-table">
        <thead>
            <tr>
                <th width="4%">No</th>
                <th width="12%">Tgl Bayar</th>
                <th width="17%">Nama Anggota</th>
                <th width="15%">Tempat, Tgl Lahir</th>
                <th width="20%">Alamat</th>
                <th width="12%">Tanggal Bergabung</th>
                <th width="10%">Status Bukti</th>
                <th width="10%">Nominal (Rp)</th>
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

                    <!-- Field Baru: Tempat dan Tanggal Lahir -->
                    <td>
                        {{ $item->tempat_lahir ?? '-' }},<br>
                        {{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->translatedFormat('d M Y') : '-' }}
                    </td>

                    <!-- Field Baru: Alamat Lengkap -->
                    <td>
                        {{ $item->alamat_lengkap ?? '-' }}
                    </td>

                    <!-- Field Baru: Prioritas Tgl Cetak KTA, jika belum maka Tgl Bergabung -->
                    <td class="text-center">
                        @if ($item->tanggal_cetak)
                            {{ \Carbon\Carbon::parse($item->tanggal_cetak)->translatedFormat('d M Y') }}
                        @else
                            {{ $item->tanggal_bergabung ? \Carbon\Carbon::parse($item->tanggal_bergabung)->translatedFormat('d M Y') : '-' }}
                        @endif
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
                    <!-- Colspan dinaikkan menjadi 8 menyesuaikan jumlah header -->
                    <td colspan="8" class="text-center" style="padding: 10px;">
                        <em>Tidak ada transaksi pembayaran pendaftaran di periode ini.</em>
                    </td>
                </tr>
            @endforelse
        </tbody>

        {{-- Tfoot hanya dirender jika ada data transaksi, mencegah munculnya Rp0 di baris kosong --}}
        @if ($data->count() > 0)
            <tfoot>
                <tr style="background-color: #fef9c3;">
                    <!-- Colspan diset 7 agar label total membentang sebelum kolom nominal -->
                    <td colspan="7" class="text-right font-bold" style="padding-right: 10px;">
                        TOTAL PEMASUKAN PENDAFTARAN
                    </td>
                    <td class="text-right font-bold">
                        {{ number_format($totalPemasukan, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        @endif
    </table>
@endsection
