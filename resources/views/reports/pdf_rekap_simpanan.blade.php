@extends('reports.layout_pdf')

@section('content')
<style>
    /* Identitas warna cyan untuk laporan simpanan */
    .data-table th { background-color: #cffafe !important; }
</style>

<table class="data-table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="25%">Data Anggota</th>
            <th width="15%">S. Pokok (Rp)</th>
            <th width="15%">S. Wajib (Rp)</th>
            <th width="15%">S. Sukarela (Rp)</th>
            <th width="25%">Total Simpanan (Rp)</th>
        </tr>
    </thead>
    <tbody>
        @php $grandTotal = 0; @endphp
        
        {{-- Menggunakan $data sesuai arsitektur Trait kita --}}
        @forelse($data as $index => $item)
            @php $grandTotal += $item->total_semua; @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    {{ $item->nama_lengkap }} <br> 
                    <small style="color: #666;">{{ $item->nomor_anggota }}</small>
                </td>
                <td class="text-right">{{ number_format($item->total_pokok, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->total_wajib, 0, ',', '.') }}</td>
                <td class="text-right">{{ number_format($item->total_sukarela, 0, ',', '.') }}</td>
                <td class="text-right font-bold">{{ number_format($item->total_semua, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 10px;">
                    <em>Belum ada data simpanan anggota untuk ditampilkan.</em>
                </td>
            </tr>
        @endforelse
    </tbody>
    <tfoot>
        <tr style="background-color: #e0f2fe;">
            <td colspan="5" class="text-right font-bold" style="padding-right: 10px;">
                TOTAL KESELURUHAN ASET SIMPANAN
            </td>
            <td class="text-right font-bold">
                {{ number_format($grandTotal, 0, ',', '.') }}
            </td>
        </tr>
    </tfoot>
</table>
@endsection