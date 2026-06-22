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
            background-color: #fef08a;
            /* yellow-200 */
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
                <th width="20%">Tgl Pembayaran</th>
                <th width="35%">Nama Anggota</th>
                <th width="20%">Status Bukti Transaksi</th>
                <th width="20%">Biaya Pendaftaran (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">
                        {{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->translatedFormat('d M Y') : '-' }}
                    </td>
                    <td>{{ $item->nama_lengkap }} <br><small>{{ $item->nomor_anggota }}</small></td>
                    <td class="text-center">{{ $item->file_bukti_bayar ? 'Terlampir di Sistem' : 'Tidak Ada' }}</td>
                    <td class="text-right">{{ number_format($item->biaya_pendaftaran, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada transaksi pembayaran pendaftaran di periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right font-bold">TOTAL PEMASUKAN PENDAFTARAN</td>
                <td class="text-right font-bold">{{ number_format($totalPemasukan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    {{-- @include('reports._signature', ['role' => 'Bendahara KUD']) --}}
    @include('reports._signature', ['type' => 'keuangan'])
</body>

</html>
