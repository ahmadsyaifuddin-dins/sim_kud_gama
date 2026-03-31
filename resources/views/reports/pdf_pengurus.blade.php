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
            background-color: #f3f4f6;
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
                <th width="30%">Nama Lengkap</th>
                <th width="25%">Jabatan</th>
                <th width="20%">Periode</th>
                <th width="20%">No. Handphone</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama }}</td>
                    <td class="text-center" style="font-weight: bold;">{{ strtoupper($item->jabatan) }}</td>
                    <td class="text-center">{{ $item->periode_mulai }} - {{ $item->periode_selesai }}</td>
                    <td class="text-center">{{ $item->no_hp ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Data pengurus belum tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @include('reports._signature', ['role' => 'Sekretaris KUD'])
</body>

</html>
