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
            background-color: #ffe4e6;
            /* Warna rose muda menyesuaikan UI */
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

        .status-lunas {
            color: #166534;
            font-weight: bold;
        }

        .status-angsuran {
            color: #854d0e;
            font-weight: bold;
        }

        .status-macet {
            color: #991b1b;
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
                <th width="20%">Nama Anggota</th>
                <th width="15%">Pinjaman (Rp)</th>
                <th width="15%">Terbayar (Rp)</th>
                <th width="15%">Sisa Hutang (Rp)</th>
                <th width="20%">Status Kolektibilitas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pinjamans as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $item->member->nama_lengkap }} <br> <small>Tgl Cair:
                            {{ $item->tanggal_pencairan ? \Carbon\Carbon::parse($item->tanggal_pencairan)->translatedFormat('d M Y') : '-' }}</small>
                    </td>
                    <td class="text-right">{{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->total_terbayar, 0, ',', '.') }}</td>
                    <td class="text-right">{{ number_format($item->sisa_hutang, 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if ($item->kolektibilitas == 'Lunas')
                            <span class="status-lunas">{{ $item->kolektibilitas }}</span>
                        @elseif($item->kolektibilitas == 'Dalam Angsuran')
                            <span class="status-angsuran">{{ $item->kolektibilitas }}</span>
                        @else
                            <span class="status-macet">{{ $item->kolektibilitas }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data evaluasi pinjaman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- @include('reports._signature', ['role' => 'Kepala Unit Simpan Pinjam']) --}}
    @include('reports._signature')
</body>

</html>
