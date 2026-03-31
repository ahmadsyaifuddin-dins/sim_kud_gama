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
            background-color: #e2f0d9;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    @include('reports._header')

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">No Anggota</th>
                <th width="30%">Nama Lengkap</th>
                <th width="20%">Tanggal Bergabung</th>
                <th width="25%">Status Cetak KTA</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $index => $m)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $m->nomor_anggota }}</td>
                    <td>{{ $m->nama_lengkap }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($m->tanggal_bergabung)->translatedFormat('d M Y') }}
                    </td>
                    <td class="text-center" style="font-weight: bold; color: {{ $m->status_cetak ? 'green' : 'red' }};">
                        {{ $m->status_cetak ? 'SUDAH DICETAK' : 'BELUM DICETAK' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data untuk filter ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @include('reports._signature', ['role' => 'Sekretaris KUD'])
</body>

</html>
