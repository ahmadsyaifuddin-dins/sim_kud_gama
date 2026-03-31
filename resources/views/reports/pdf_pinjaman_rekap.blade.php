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
            background-color: #e0e7ff;
            text-align: center;
            font-weight: bold;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    @include('reports._header')
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tgl Pengajuan</th>
                <th width="20%">Nama Anggota</th>
                <th width="10%">Tenor</th>
                <th width="20%">Keperluan</th>
                <th width="15%">Jumlah (Rp)</th>
                <th width="15%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_pengajuan)->translatedFormat('d M Y') }}</td>
                    <td>{{ $item->member->nama_lengkap }} <br> <small>{{ $item->member->nomor_anggota }}</small></td>
                    <td class="text-center">{{ $item->lama_angsuran }} Bulan</td>
                    <td>{{ $item->keperluan }}</td>
                    <td class="text-right">{{ number_format($item->jumlah_pinjaman, 0, ',', '.') }}</td>
                    <td class="text-center" style="font-weight: bold;">{{ strtoupper($item->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data pinjaman.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
    @include('reports._signature', ['role' => 'Ketua KUD'])
</body>

</html>
