@php
    $ketua = \App\Models\Management::where('jabatan', 'Ketua')->where('is_active', true)->first();
    $namaKetua = $ketua ? $ketua->nama : 'NAMA KETUA BELUM DISET';
@endphp

<!DOCTYPE html>
<html>

<head>
    <title>Kartu Anggota - {{ $member->nama_lengkap }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        /* --- WRAPPER GARIS POTONG (Desain Baru) --- */
        .cut-wrapper {
            width: 86.1mm;
            padding: 0.5mm;
            border: 1px dashed #999;
            position: relative;
            display: inline-block;
        }

        .cut-text {
            position: absolute;
            top: -12px;
            left: 2px;
            background: white;
            padding: 0 4px;
            font-size: 9px;
            color: #666;
            font-style: italic;
        }

        /* Container Kartu */
        .card-container {
            width: 85.6mm;
            height: 54mm;
            border: 1px solid #000;
            position: relative;
            background-image: linear-gradient(to bottom right, #ffffff, #f0fdf4);
            /* Gradasi putih ke hijau sangat muda */
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* --- HEADER (Modern UI Upgrade) --- */
        .header {
            background-color: #14532d;
            /* Wajib pakai solid color untuk dompdf */
            color: #ffffff;
            padding: 4px 8px;
            height: 38px;
            width: 100%;
            box-sizing: border-box;
            position: relative;
            overflow: hidden;
            border-bottom: 2px solid #eab308;
            /* Garis emas tetap ada */
        }

        /* Efek Modern: Lingkaran Transparan Bertumpuk */
        .header-circle-1 {
            position: absolute;
            top: -15px;
            right: -10px;
            width: 55px;
            height: 55px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            z-index: 1;
        }

        .header-circle-2 {
            position: absolute;
            top: 15px;
            right: 25px;
            width: 35px;
            height: 35px;
            background-color: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            z-index: 1;
        }

        .header table {
            width: 100%;
            border-collapse: collapse;
            position: relative;
            z-index: 2;
        }

        .header-logo-col {
            width: 45px;
            /* Beri lebar pasti */
            vertical-align: middle;
            text-align: left;
            padding-left: 2px;
        }

        .header-text-col {
            vertical-align: middle;
            text-align: center;
        }

        .header-spacer-col {
            width: 45px;
            /* Lebarnya WAJIB SAMA dengan header-logo-col */
        }

        .header h2 {
            margin: 0;
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 900;
            letter-spacing: 1px;
            line-height: 1;
            margin-bottom: 2px;
            color: #ffffff;
            /* Pastikan warna teks eksplisit */
        }

        .header p {
            margin: 0;
            font-size: 5px;
            line-height: 1.1;
            font-weight: normal;
            color: #dcfce7;
        }

        /* --- KONTEN --- */
        .content {
            padding: 6px 10px;
            display: table;
            width: 100%;
        }

        .photo-area {
            display: table-cell;
            width: 25mm;
            vertical-align: top;
            text-align: center;
            padding-top: 2px;
        }

        .photo-box {
            width: 20mm;
            height: 25mm;
            border: 1px solid #ccc;
            /* Border lebih soft */
            background-color: #eee;
            object-fit: cover;
            border-radius: 4px;
            /* Sudut foto sedikit melengkung */
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.2);
        }

        .details-area {
            display: table-cell;
            vertical-align: top;
            padding-left: 10px;
            padding-top: 2px;
        }

        .row {
            margin-bottom: 1px;
            font-size: 9px;
            line-height: 1.25;
            color: #1f2937;
        }

        .label {
            font-weight: bold;
            display: inline-block;
            width: 48px;
        }

        /* --- FOOTER (TANDA TANGAN) --- */
        .footer {
            position: absolute;
            top: 38mm;
            right: 10px;
            width: 45mm;
            text-align: center;
            font-size: 8px;
            z-index: 10;
        }

        .footer p {
            margin: 0;
            line-height: 1.2;
        }

        .sign-area {
            height: 8mm;
        }

        .sign-name {
            font-weight: bold;
            text-decoration: underline;
        }

        /* Watermark Background */
        .watermark {
            position: absolute;
            top: 55%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 40px;
            color: rgba(22, 101, 52, 0.05);
            /* Sedikit lebih transparan agar tidak mengganggu bacaan */
            font-weight: bold;
            z-index: 0;
            pointer-events: none;
        }

        .qr-area {
            position: absolute;
            bottom: 5px;
            right: 42mm;
            width: 13mm;
            height: 13mm;
            z-index: 20;
            background: white;
            padding: 2px;
            border-radius: 3px;
            border: 1px solid #e5e7eb;
        }

        .qr-area svg {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>

    <div class="cut-wrapper">
        <span class="cut-text">Gunting di sepanjang garis putus-putus</span>

        <div class="card-container">
            <div class="watermark">KUD GM</div>

            <div class="header">
                <div class="header-circle-1"></div>
                <div class="header-circle-2"></div>

                <table>
                    <tr>
                        <td class="header-logo-col">
                            <img src="{{ public_path('logo/kud-logo.jpg') }}"
                                style="height: 30px; width: auto; background: white; border-radius: 50%; padding: 1.5px;">
                        </td>

                        <td class="header-text-col">
                            <h2>KUD GAJAH MADA</h2>
                            <p>
                                Desa Telaga Sari, Kecamatan Kelumpang Hilir, Kabupaten Kotabaru,<br>
                                Provinsi Kalimantan Selatan, Kode pos 72161
                            </p>
                        </td>

                        <td class="header-spacer-col"></td>
                    </tr>
                </table>
            </div>

            <div class="content">
                <div class="photo-area">
                    @if ($member->foto)
                        <img src="{{ public_path($member->foto) }}" class="photo-box">
                    @else
                        <div class="photo-box" style="line-height: 25mm; font-size: 8px;">No Photo</div>
                    @endif

                    <div style="font-size: 8px; margin-top: 4px; font-weight: bold; color: #15803d;">
                        {{ $member->nomor_anggota }}
                    </div>
                </div>

                <div class="details-area">
                    <div class="row">
                        <span class="label">Nama</span>: <span
                            style="font-weight: bold;">{{ strtoupper($member->nama_lengkap) }}</span>
                    </div>
                    <div class="row">
                        <span class="label">NIK</span>: {{ $member->nik }}
                    </div>
                    <div class="row">
                        <span class="label">TTL</span>: {{ $member->tempat_lahir }},
                        {{ \Carbon\Carbon::parse($member->tanggal_lahir)->format('d-m-Y') }}
                    </div>
                    <div class="row">
                        <span class="label">Alamat</span>: {{ Str::limit($member->alamat_lengkap, 28) }}
                    </div>
                    <div class="row">
                        <span class="label">Dusun</span>: {{ $member->dusun }}
                    </div>
                    <div class="row" style="font-weight: bold; color: #15803d;">
                        <span class="label">Lahan</span>: {{ $member->luasan_lahan }} Hektar
                    </div>
                    <div class="row">
                        <span class="label">Berlaku</span>: Seumur Hidup
                    </div>
                </div>
            </div>

            <div class="qr-area">
                <img src="data:image/svg+xml;base64, {{ $qrCode }}" style="width: 100%; height: 100%;">
            </div>

            <div class="footer">
                <p>Ketua KUD Gajah Mada</p>
                <div class="sign-area"></div>
                <p class="sign-name">{{ $namaKetua }}</p>
            </div>
        </div>
    </div>

</body>

</html>
