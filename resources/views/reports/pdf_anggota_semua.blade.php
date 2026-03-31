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
            background-color: #f0f0f0;
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

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">No Anggota</th>
                <th width="15%">NIK</th>
                <th width="20%">Nama Lengkap</th>
                <th width="20%">Alamat / Dusun</th>
                <th width="10%">L. Lahan</th>
                <th width="15%">Tgl Gabung</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $index => $m)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $m->nomor_anggota }}</td>
                    <td>{{ $m->nik }}</td>
                    <td>{{ $m->nama_lengkap }}</td>
                    <td>{{ $m->dusun ?? '-' }}, {{ $m->desa }}</td>
                    <td class="text-center">{{ $m->luasan_lahan }} Ha</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($m->tanggal_bergabung)->translatedFormat('d/m/Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data anggota.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @include('reports._signature', ['role' => 'Ketua KUD'])
</body>

</html>
