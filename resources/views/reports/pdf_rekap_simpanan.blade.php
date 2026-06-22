<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
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
            background-color: #cffafe;
            /* Warna cyan muda menyesuaikan UI */
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    @include('reports._header')

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
            @forelse($members as $index => $item)
                @php $grandTotal += $item->total_semua; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_lengkap }} <br> <small>{{ $item->nomor_anggota }}</small></td>
                    <td class="text-right">{{ number_format($item->total_pokok, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->total_wajib, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->total_sukarela, 0, ',', '.') }}</td>
                    <td class="text-right font-bold">{{ number_format($item->total_semua, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data simpanan anggota.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right font-bold">TOTAL KESELURUHAN ASET SIMPANAN</td>
                <td class="text-right font-bold">{{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    @include('reports._signature')
</body>

</html>
