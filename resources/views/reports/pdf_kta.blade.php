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
            background-color: #ccfbf1;
            /* teal-100 */
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .badge-sukses {
            color: #166534;
            font-weight: bold;
        }

        .badge-gagal {
            color: #991b1b;
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
                <th width="20%">No. Anggota</th>
                <th width="30%">Nama Anggota</th>
                <th width="15%">Keanggotaan</th>
                <th width="15%">Status KTA</th>
                <th width="15%">Tgl Cetak</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $index => $item)
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
                    <td colspan="6" class="text-center">Tidak ada data KTA yang sesuai dengan filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @include('reports._signature', ['role' => 'Admin Keanggotaan'])
</body>

</html>
