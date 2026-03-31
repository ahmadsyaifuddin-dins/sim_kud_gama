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
            background-color: #fee2e2;
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
                <th width="30%">Nama Anggota</th>
                <th width="20%">Tgl Cair</th>
                <th width="15%">Tenor</th>
                <th width="30%">Total Pinjaman (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->member->nama_lengkap }} <br> <small>{{ $item->member->no_hp ?? '-' }}</small></td>
                    <td class="text-center">
                        {{ $item->tanggal_pencairan ? \Carbon\Carbon::parse($item->tanggal_pencairan)->translatedFormat('d M Y') : '-' }}
                    </td>
                    <td class="text-center">{{ $item->lama_angsuran }} Bln</td>
                    <td class="text-right">{{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada pinjaman yang tertunggak.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @include('reports._signature', ['role' => 'Bendahara KUD'])
</body>

</html>
