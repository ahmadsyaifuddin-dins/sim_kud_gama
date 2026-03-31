<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #e6f7ff;
            text-align: center;
            font-weight: bold;
        }

        /* Warna beda sedikit untuk variasi */
        .text-center {
            text-align: center;
        }

        .highlight-dusun {
            background-color: #ffffcc;
            font-weight: bold;
        }

        /* Highlight untuk kolom dusun */
    </style>
</head>

<body>
    @include('reports._header')

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="20%">Wilayah / Dusun</th>
                <th width="15%">No Anggota</th>
                <th width="25%">Nama Lengkap</th>
                <th width="20%">Pekerjaan</th>
                <th width="15%">No. HP</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $index => $m)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="highlight-dusun">{{ $m->dusun ?? 'Belum Ditentukan' }}</td>
                    <td class="text-center">{{ $m->nomor_anggota }}</td>
                    <td>{{ $m->nama_lengkap }}</td>
                    <td>{{ $m->pekerjaan ?? '-' }}</td>
                    <td>{{ $m->no_hp ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data di wilayah ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @include('reports._signature', ['role' => 'Ketua KUD'])
</body>

</html>
