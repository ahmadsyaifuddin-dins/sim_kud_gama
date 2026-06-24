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
            vertical-align: middle;
        }

        .data-table th {
            background-color: #dbeafe;
            /* Biru muda */
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .bg-gray {
            background-color: #f3f4f6;
            font-weight: bold;
        }
    </style>
</head>

<body>
    @include('reports._header')

    <h3 class="text-center" style="margin-bottom: 5px;">{{ $title }}</h3>
    <p class="text-center" style="margin-top: 0; margin-bottom: 20px; font-style: italic;">{{ $subtitle }}</p>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal Setor</th>
                <th width="25%">Nama Anggota</th>
                <th width="15%">Jenis Simpanan</th>
                <th width="20%">Keterangan</th>
                <th width="20%">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $totalNominal = 0; @endphp
            @forelse($data as $index => $item)
                @php $totalNominal += $item->jumlah; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y') }}</td>
                    <td>{{ $item->member->nama_lengkap ?? 'Anggota Dihapus' }}</td>
                    <td class="text-center" style="text-transform: capitalize;">{{ $item->jenis_simpanan }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td class="text-right">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada transaksi simpanan pada periode ini.</td>
                </tr>
            @endforelse

            @if (count($data) > 0)
                <tr class="bg-gray">
                    <td colspan="5" class="text-right">TOTAL SETORAN :</td>
                    <td class="text-right">Rp {{ number_format($totalNominal, 0, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
    </table>

    @include('reports._signature', ['type' => 'keuangan'])
</body>

</html>
