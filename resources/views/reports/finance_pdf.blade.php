<!DOCTYPE html>
<html>

<head>
    <title>Laporan Keuangan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .data-table th,
        .data-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        .data-table th {
            background-color: #fff2cc;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    @include('reports._header', [
        'title' => 'Laporan Pemasukan Pendaftaran',
        'subtitle' =>
            'Periode: ' .
            ($request->start_date
                ? \Carbon\Carbon::parse($request->start_date)->translatedFormat('d M Y') .
                    ' s/d ' .
                    \Carbon\Carbon::parse($request->end_date)->translatedFormat('d M Y')
                : 'Semua Data'),
    ])

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Tanggal Bayar</th>
                <th width="30%">Nama Anggota</th>
                <th width="25%">No Anggota</th>
                <th width="20%">Nominal Bayar (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $index => $m)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($m->tanggal_bayar)->translatedFormat('d M Y') }}
                    </td>
                    <td>{{ $m->nama_lengkap }}</td>
                    <td class="text-center">{{ $m->nomor_anggota }}</td>
                    <td class="text-right">{{ number_format($m->biaya_pendaftaran, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada transaksi pemasukan pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right" style="font-weight: bold; padding: 8px;">Total Pemasukan:</td>
                <td class="text-right" style="font-weight: bold; background-color: #f2f2f2; padding: 8px;">
                    Rp {{ number_format($totalPemasukan, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    @include('reports._signature', ['role' => 'Bendahara KUD'])
</body>

</html>
