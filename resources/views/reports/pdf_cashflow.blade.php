<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        .financial-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .financial-table th,
        .financial-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
            vertical-align: middle;
        }

        .financial-table th {
            background-color: #dbeafe;
            /* Warna biru muda */
            font-weight: bold;
            text-align: center;
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

        .bg-light {
            background-color: #f8fafc;
        }

        .section-title {
            font-size: 13px;
            margin-bottom: 8px;
            font-weight: bold;
            border-bottom: 1.5px solid #334155;
            padding-bottom: 4px;
        }
    </style>
</head>

<body>
    @include('reports._header')

    <div class="section-title">A. ARUS KAS MASUK (DEBIT)</div>
    <table class="financial-table">
        <tbody>
            <tr>
                <td width="5%" class="text-center">1</td>
                <td width="65%">Pemasukan dari Biaya Pendaftaran Anggota Baru</td>
                <td width="30%" class="text-right">Rp {{ number_format($pendaftaranMasuk, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-center">2</td>
                <td>Pemasukan dari Setoran Simpanan (Pokok, Wajib, Sukarela)</td>
                <td class="text-right">Rp {{ number_format($simpananMasuk, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-center">3</td>
                <td>Pemasukan dari Pembayaran Angsuran Pinjaman Anggota</td>
                <td class="text-right">Rp {{ number_format($angsuranMasuk, 0, ',', '.') }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="bg-light">
                <td colspan="2" class="text-right font-bold">TOTAL PEMASUKAN</td>
                <td class="text-right font-bold">Rp {{ number_format($totalMasuk, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="section-title" style="margin-top: 15px;">B. ARUS KAS KELUAR (KREDIT)</div>
    <table class="financial-table">
        <tbody>
            <tr>
                <td width="5%" class="text-center">1</td>
                <td width="65%">Pengeluaran untuk Pencairan Dana Pinjaman Anggota</td>
                <td width="30%" class="text-right">Rp {{ number_format($pinjamanKeluar, 0, ',', '.') }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="bg-light">
                <td colspan="2" class="text-right font-bold">TOTAL PENGELUARAN</td>
                <td class="text-right font-bold">Rp {{ number_format($pinjamanKeluar, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="section-title" style="margin-top: 15px;">C. REKAPITULASI SALDO KAS KUD</div>
    <table class="financial-table">
        <tbody>
            <tr>
                <td width="70%" class="text-right font-bold">SALDO KAS BERSIH (Pemasukan - Pengeluaran)</td>
                <td width="30%" class="text-right font-bold" style="font-size: 14px;">
                    Rp {{ number_format($saldoBersih, 0, ',', '.') }}
                </td>
            </tr>
        </tbody>
    </table>

    @include('reports._signature', ['role' => 'Bendahara KUD'])
</body>

</html>
