@extends('reports.layout_pdf')

@section('content')
<style>
    /* Kita pertahankan warna teal khas laporan KTA */
    .data-table th { background-color: #ccfbf1 !important; }
    
    .badge-sukses { color: #166534; font-weight: bold; }
    .badge-gagal { color: #991b1b; font-weight: bold; }
</style>

<table class="data-table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="15%">No. Anggota</th>
            <th width="25%">Nama Anggota</th>
            <th width="15%">Keanggotaan</th>
            <th width="20%">Status KTA</th>
            <th width="20%">Tgl Cetak</th>
        </tr>
    </thead>
    <tbody>
        {{-- Menggunakan $data sesuai arsitektur Trait kita --}}
        @forelse($data as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $item->nomor_anggota }}</td>
                <td>{{ $item->nama_lengkap }}</td>
                <td class="text-center">{{ ucfirst($item->status) }}</td>
                <td class="text-center">
                    @if ($item->status_cetak)
                        <span class="badge-sukses">Sudah Dicetak</span>
                    @else
                        <span class="badge-gagal">Belum Dicetak</span>
                    @endif
                </td>
                <td class="text-center">
                    {{ $item->tanggal_cetak ? \Carbon\Carbon::parse($item->tanggal_cetak)->translatedFormat('d M Y') : '-' }}
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 10px;">
                    <em>Tidak ada data KTA yang sesuai dengan filter.</em>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection