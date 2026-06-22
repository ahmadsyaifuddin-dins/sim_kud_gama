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
            background-color: #f3e8ff;
            /* purple-100 */
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
                <th width="15%">No. Anggota</th>
                <th width="25%">Nama Lengkap</th>
                <th width="10%">Jenis Kelamin</th>
                <th width="20%">Dusun</th>
                <th width="15%">Tgl Bergabung</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $item->nomor_anggota }}</td>
                    <td>{{ $item->nama_lengkap }} <br><small>NIK: {{ $item->nik }}</small></td>
                    <td class="text-center">{{ $item->jenis_kelamin }}</td>
                    <td>{{ $item->dusun }}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_bergabung)->translatedFormat('d M Y') }}</td>
                    <td class="text-center">{{ strtoupper($item->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data anggota yang sesuai dengan filter.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @include('reports._signature')
</body>

</html>
