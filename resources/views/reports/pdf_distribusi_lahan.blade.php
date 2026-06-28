@extends('reports.layout_pdf')

@section('content')
<table class="data-table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="45%">Wilayah / Dusun</th>
            <th width="25%">Total Anggota (Orang)</th>
            <th width="25%">Total Luas Lahan (Hektar)</th>
        </tr>
    </thead>
    <tbody>
        @php
            $grandTotalAnggota = 0;
            $grandTotalHektar = 0;
        @endphp
        
        {{-- Menggunakan $dataLahan sesuai pengiriman data di Trait --}}
        @forelse($dataLahan as $index => $item)
            @php
                $grandTotalAnggota += $item->total_anggota;
                $grandTotalHektar += $item->total_hektar;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->dusun ?? 'Tidak Ada Data Dusun' }}</td>
                <td class="text-center">{{ $item->total_anggota }} Orang</td>
                <td class="text-center">{{ number_format($item->total_hektar, 2, ',', '.') }} Ha</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center" style="padding: 10px;">
                    <em>Tidak ada data lahan untuk ditampilkan.</em>
                </td>
            </tr>
        @endforelse

        @if (count($dataLahan) > 0)
            <tr style="background-color: #f3f4f6; font-weight: bold;">
                <td colspan="2" class="text-right" style="padding-right: 10px;">TOTAL KESELURUHAN :</td>
                <td class="text-center">{{ $grandTotalAnggota }} Orang</td>
                <td class="text-center">{{ number_format($grandTotalHektar, 2, ',', '.') }} Ha</td>
            </tr>
        @endif
    </tbody>
</table>
@endsection