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
            background-color: #dbeafe;
            /* blue-100 */
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .font-bold {
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
                <th width="30%">Nama Anggota</th>
                <th width="10%">Usia</th>
                <th width="25%">Pekerjaan Utama</th>
                <th width="30%">Luasan Lahan (Hektar)</th>
            </tr>
        </thead>
        <tbody>
            @php $totalLahan = 0; @endphp
            @forelse($members as $index => $item)
                @php $totalLahan += $item->luasan_lahan ?? 0; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->nama_lengkap }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($item->tanggal_lahir)->age }} Thn</td>
                    <td>{{ $item->pekerjaan ?? 'Belum Diisi' }}</td>
                    <td class="text-right">{{ number_format($item->luasan_lahan, 2, ',', '.') }} Ha</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data demografi anggota.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right font-bold">TOTAL POTENSI LAHAN KUD</td>
                <td class="text-right font-bold">{{ number_format($totalLahan, 2, ',', '.') }} Ha</td>
            </tr>
        </tfoot>
    </table>

    @include('reports._signature', ['role' => 'Ketua KUD'])
</body>

</html>
