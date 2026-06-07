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
            background-color: #e2e8f0;
            /* slate-200 */
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
                <th width="25%">Nama Pengguna</th>
                <th width="30%">Alamat Email</th>
                <th width="20%">Hak Akses (Role)</th>
                <th width="20%">Tgl Pembuatan Akun</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td class="text-center">{{ strtoupper($item->role) }}</td>
                    <td class="text-center">
                        {{ $item->created_at ? $item->created_at->translatedFormat('d M Y H:i') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Data pengguna tidak ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @include('reports._signature', ['role' => 'Administrator Sistem'])
</body>

</html>
