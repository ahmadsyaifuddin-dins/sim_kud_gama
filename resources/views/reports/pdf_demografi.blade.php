@extends('reports.layout_pdf')

@section('content')
<table class="data-table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="30%">Nama Anggota</th>
            <th width="10%">Usia</th>
            <th width="25%">Pekerjaan Utama</th>
            <th width="30%">Luasan Lahan (Hektar)</th>
        </tr>
    </thead>
    <tbody>
        @php $totalLahan = 0; @endphp
        {{-- Gunakan $data sesuai kesepakatan arsitektur --}}
        @forelse($data as $index => $item)
            @php $totalLahan += $item->luasan_lahan ?? 0; @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->nama_lengkap }}</td>
                <td class="text-center">
                    {{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->age . ' Thn' : '-' }}
                </td>
                <td>{{ $item->pekerjaan ?? 'Belum Diisi' }}</td>
                <td class="text-right">{{ number_format($item->luasan_lahan, 2, ',', '.') }} Ha</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 10px;">
                    <em>Belum ada data demografi anggota.</em>
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr style="background-color: #f3f4f6;">
            <td colspan="4" class="text-right font-bold" style="padding-right: 10px;">TOTAL POTENSI LAHAN KUD</td>
            <td class="text-right font-bold">{{ number_format($totalLahan, 2, ',', '.') }} Ha</td>
        </tr>
    </tfoot>
</table>
@endsection