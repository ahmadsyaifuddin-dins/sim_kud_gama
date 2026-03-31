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

        /* Container Kartu */
        .card-container {
            width: 85.6mm;
            height: 54mm;
            border: 1px solid #000;
            position: relative;
            background-image: linear-gradient(to bottom right, #ffffff, #e6ffe6);
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* --- HEADER BARU (Pakai Table biar Logo & Teks Rapi) --- */
        .header {
            background-color: #166534;
            /* Hijau Tua */
            color: white;
            padding: 4px 8px;
            height: 38px;
            width: 100%;
            box-sizing: border-box;
        }

        .header table {
            width: 100%;
            border-collapse: collapse;
        }

        .header-logo-col {
            width: 35px;
            vertical-align: middle;
            text-align: left;
        }

        .header-text-col {
            vertical-align: middle;
            text-align: center;
        }

        /* Styling Judul KUD */
        .header h2 {
            margin: 0;
            font-size: 13px;
            text-transform: uppercase;
            font-weight: 900;
            letter-spacing: 1px;
            line-height: 1;
            margin-bottom: 2px;
        }

        /* Styling Alamat (Font Kecil supaya muat) */
        .header p {
            margin: 0;
            font-size: 5px;
            line-height: 1.1;
            font-weight: normal;
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
            border: 1px solid #999;
            background-color: #eee;
            object-fit: cover;
            border-radius: 2px;
        }

        .details-area {
            display: table-cell;
            vertical-align: top;
            padding-left: 10px;
        }

        /* Baris Data */
        .row {
            margin-bottom: 1px;
            font-size: 9px;
            line-height: 1.2;
            color: #000;
        }

        .label {
            font-weight: bold;
            display: inline-block;
            width: 50px;
        }

        /* --- FOOTER (TANDA TANGAN) --- */
        .footer {
            position: absolute;
            top: 40mm;
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

        /* Watermark Background */
        .watermark {
            position: absolute;
            top: 55%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 40px;
            color: rgba(22, 101, 52, 0.08);
            /* Hijau transparan */
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
            border-radius: 2px;
            overflow: hidden;
        }

        .qr-area svg {
            width: 100%;
            height: 100%;
        }
    </style>
</head>

<body>

    <div class="card-container">
        <div class="watermark">KUD GM</div>

        <div class="header">
            <table>
                <tr>
                    <td class="header-logo-col">
                        <img src="{{ public_path('logo/kud-logo.jpg') }}"
                            style="height: 30px; width: auto; background: white; border-radius: 50%; padding: 1px;">
                    </td>

                    <td class="header-text-col">
                        <h2>KUD GAJAH MADA</h2>
                        <p>
                            Desa Telaga Sari, Kecamatan Kelumpang Hilir, Kabupaten Kotabaru,<br>
                            Provinsi Kalimantan Selatan, Kode pos 72161
                        </p>
                    </td>
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

                <div style="font-size: 8px; margin-top: 3px; font-weight: bold; color: #166534;">
                    {{ $member->nomor_anggota }}
                </div>
            </div>

            <div class="details-area">
                <div class="row">
                    <span class="label">Nama</span>: {{ strtoupper($member->nama_lengkap) }}
                </div>
                <div class="row">
                    <span class="label">NIK</span>: {{ $member->nik }}
                </div>
                <div class="row">
                    <span class="label">TTL</span>: {{ $member->tempat_lahir }},
                    {{ \Carbon\Carbon::parse($member->tanggal_lahir)->format('d-m-Y') }}
                </div>
                <div class="row">
                    <span class="label">Alamat</span>: {{ Str::limit($member->alamat_lengkap, 25) }}
                </div>
                <div class="row">
                    <span class="label">Dusun</span>: {{ $member->dusun }}
                </div>
                <div class="row" style="font-weight: bold; color: #166534;">
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
            <p><u>( ........................... )</u></p>
        </div>
    </div>

    <p style="font-size: 10px; color: gray; margin-top: 10px;">
        *Silakan gunting sesuai garis kotak. Kartu ini sah sebagai identitas resmi anggota KUD Gajah Mada.
    </p>

</body>

</html>
