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
            background-color: #fff3e6;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }
    </style>
</head>

<body>
    @include('reports._header')

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tgl Bergabung</th>
                <th width="15%">No Anggota</th>
                <th width="25%">Nama Lengkap</th>
                <th width="10%">L/P</th>
                <th width="15%">Status Anggota</th>
                <th width="15%">Biaya Daftar</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $index => $m)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center text-bold">
                        {{ \Carbon\Carbon::parse($m->tanggal_bergabung)->translatedFormat('d M Y') }}</td>
                    <td class="text-center">{{ $m->nomor_anggota }}</td>
                    <td>{{ $m->nama_lengkap }}</td>
                    <td class="text-center">{{ $m->jenis_kelamin }}</td>
                    <td class="text-center">
                        @if ($m->status == 'active')
                            Aktif
                        @elseif($m->status == 'inactive')
                            Pasif
                        @elseif($m->status == 'stopped')
                            Keluar
                        @else
                            Pending
                        @endif
                    </td>
                    <td class="text-center">Rp {{ number_format($m->biaya_pendaftaran, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada anggota yang bergabung pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @include('reports._signature', ['role' => 'Ketua KUD'])
</body>

</html>
