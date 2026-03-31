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
            background-color: #fce4d6;
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
                <th width="15%">No Anggota</th>
                <th width="25%">Nama Lengkap</th>
                <th width="20%">Pekerjaan</th>
                <th width="15%">Tgl Bergabung</th>
                <th width="20%">Status Keanggotaan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $index => $m)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $m->nomor_anggota }}</td>
                    <td>{{ $m->nama_lengkap }}</td>
                    <td>{{ $m->pekerjaan ?? '-' }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($m->tanggal_bergabung)->translatedFormat('d M Y') }}
                    </td>
                    <td class="text-center" style="font-weight: bold;">
                        @if ($m->status == 'active')
                            <span style="color: green;">AKTIF</span>
                        @elseif($m->status == 'inactive')
                            <span style="color: orange;">PASIF</span>
                        @elseif($m->status == 'stopped')
                            <span style="color: red;">BERHENTI</span>
                        @else
                            <span style="color: gray;">PENDING</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data dengan status tersebut.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @include('reports._signature', ['role' => 'Ketua KUD'])
</body>

</html>
