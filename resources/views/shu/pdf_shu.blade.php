@extends('reports.layout_pdf')

@section('content')
    <style>
        .financial-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .financial-table th,
        .financial-table td {
            border: 1px solid #000;
            padding: 6px;
            vertical-align: middle;
        }
        .financial-table th {
            background-color: #e9d5ff !important;
            text-align: center;
            font-weight: bold;
        }
        .section-title {
            font-size: 12px;
            margin-top: 12px;
            margin-bottom: 8px;
            font-weight: bold;
            border-bottom: 1.5px solid #334155;
            padding-bottom: 4px;
        }
        .bg-light {
            background-color: #f5f3ff;
        }
    </style>

    <div class="section-title">A. REKAPITULASI ALOKASI SHU</div>
    <table class="financial-table">
        <tbody>
            <tr>
                <td width="50%">Total SHU yang Dibagikan</td>
                <td width="50%" class="text-right font-bold">Rp {{ number_format($distribution->total_shu, 0, ',', '.') }}</td>
            </tr>
            <tr class="bg-light">
                <td>
                    Jasa Usaha / Modal ({{ rtrim(rtrim(number_format($distribution->jasa_modal_persen, 1, ',', '.'), '0'), ',') }}%)
                </td>
                <td class="text-right">Rp {{ number_format($distribution->total_jasa_modal, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>
                    Jasa Transaksi / Pinjaman ({{ rtrim(rtrim(number_format($distribution->jasa_transaksi_persen, 1, ',', '.'), '0'), ',') }}%)
                </td>
                <td class="text-right">Rp {{ number_format($distribution->total_jasa_transaksi, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Dibagikan ke Anggota</td>
                <td class="text-right font-bold">Rp {{ number_format($totalDibagikan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Cadangan Koperasi ({{ rtrim(rtrim(number_format($distribution->cadangan_persen, 1, ',', '.'), '0'), ',') }}%)</td>
                <td class="text-right">Rp {{ number_format($distribution->total_cadangan, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="section-title">B. RINCIAN PEMBAGIAN SHU PER ANGGOTA ({{ $distribution->total_member }} ANGGOTA)</div>
    <table class="financial-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="26%">Anggota</th>
                <th width="15%">Simpanan (Modal)</th>
                <th width="13%">Jasa Modal</th>
                <th width="15%">Transaksi</th>
                <th width="13%">Jasa Transaksi</th>
                <th width="13%">Total SHU</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $index => $row)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        {{ $row->member->nama_lengkap }}
                        <br>
                        <small>{{ $row->member->nomor_anggota }}</small>
                    </td>
                    <td class="text-right">{{ number_format($row->saldo_simpanan, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($row->jasa_modal, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($row->total_transaksi, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($row->jasa_transaksi, 0, ',', '.') }}</td>
                    <td class="text-right font-bold">{{ number_format($row->total_shu, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="bg-light">
                <td colspan="6" class="text-right font-bold">TOTAL DIBAGIKAN</td>
                <td class="text-right font-bold">Rp {{ number_format($totalDibagikan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
@endsection