@extends('reports.layout_pdf')

@section('content')
    <style>
        /* Warna khas untuk laporan pinjaman */
        .data-table th {
            background-color: #e0e7ff !important;
        }
    </style>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tgl Pengajuan</th>
                <th width="20%">Nama Anggota</th>
                <th width="10%">Tenor</th>
                <th width="20%">Keperluan</th>
                <th width="15%">Jumlah (Rp)</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
                @php
                    // Logika penentuan warna menggunakan PHP 8 match expression
                    $statusColor = match (strtolower($item->status)) {
                        'menunggu' => '#d97706', // Orange / Amber
                        'disetujui' => '#0284c7', // Biru Laut (Sedang berjalan)
                        'lunas' => '#16a34a', // Hijau (Selesai/Aman)
                        'ditolak' => '#dc2626', // Merah (Batal)
                        default => '#374151', // Abu-abu gelap (Fallback)
                    };
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d M Y') }}
                    </td>
                    <td>
                        {{ $item->member->nama_lengkap }} <br>
                        <small style="color: #666;">{{ $item->member->nomor_anggota }}</small>
                    </td>
                    <td class="text-center">{{ $item->lama_angsuran }} Bulan</td>
                    <td>{{ $item->keperluan }}</td>
                    <td class="text-right">{{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td>

                    <td class="text-center" style="font-weight: bold; color: {{ $statusColor }};">
                        {{ strtoupper($item->status) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center" style="padding: 10px;">
                        <em>Tidak ada data pinjaman yang ditemukan.</em>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
