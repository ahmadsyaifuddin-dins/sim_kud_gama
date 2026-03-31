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
            background-color: #d1fae5;
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
    @include('reports._header')
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Tanggal Bayar</th>
                <th width="30%">Nama Anggota (Peminjam)</th>
                <th width="15%">Angsuran Ke</th>
                <th width="30%">Nominal Bayar (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_bayar)->translatedFormat('d M Y') }}
                    </td>
                    <td>{{ $item->pinjaman->member->nama_lengkap }}</td>
                    <td class="text-center">Ke-{{ $item->angsuran_ke }}</td>
                    <td class="text-right">{{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada angsuran masuk pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right" style="font-weight: bold; padding: 8px;">Total Pemasukan Angsuran:
                </td>
                <td class="text-right" style="font-weight: bold; background-color: #f9f9f9; padding: 8px;">
                    Rp {{ number_format($totalAngsuran, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>
    @include('reports._signature', ['role' => 'Bendahara KUD'])
</body>

</html>
