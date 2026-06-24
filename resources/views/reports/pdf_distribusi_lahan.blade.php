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
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .bg-gray {
            background-color: #f9fafb;
            font-weight: bold;
        }
    </style>
</head>

<body>
    @include('reports._header')

    <h3 class="text-center" style="margin-bottom: 5px;">{{ $title }}</h3>
    <p class="text-center" style="margin-top: 0; margin-bottom: 20px; font-style: italic;">{{ $subtitle }}</p>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="45%">Wilayah / Dusun</th>
                <th width="25%">Total Anggota (Orang)</th>
                <th width="25%">Total Luas Lahan (Hektar)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $grandTotalAnggota = 0;
                $grandTotalHektar = 0;
            @endphp
            @forelse($dataLahan as $index => $item)
                @php
                    $grandTotalAnggota += $item->total_anggota;
                    $grandTotalHektar += $item->total_hektar;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->dusun ?? 'Tidak Ada Data Dusun' }}</td>
                    <td class="text-center">{{ $item->total_anggota }} Orang</td>
                    <td class="text-center">{{ number_format($item->total_hektar, 2, ',', '.') }} Ha</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">Tidak ada data lahan untuk ditampilkan.</td>
                </tr>
            @endforelse

            @if (count($dataLahan) > 0)
                <tr class="bg-gray">
                    <td colspan="2" class="text-right">TOTAL KESELURUHAN :</td>
                    <td class="text-center">{{ $grandTotalAnggota }} Orang</td>
                    <td class="text-center">{{ number_format($grandTotalHektar, 2, ',', '.') }} Ha</td>
                </tr>
            @endif
        </tbody>
    </table>

    @include('reports._signature')
</body>

</html>
