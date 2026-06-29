<style>
    .kop-surat {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 5px;
        border-bottom: 3px double #000;
        /* Garis ganda langsung di tabel */
    }

    /* 1. Kolom Kiri (Logo) */
    .kop-kiri {
        width: 20%;
        /* Lebar fix */
        text-align: left;
        vertical-align: middle;
        padding-bottom: 10px;
    }

    /* 2. Kolom Tengah (Teks) */
    .kop-tengah {
        width: 60%;
        /* Sisa ruang */
        text-align: center;
        vertical-align: middle;
        padding-bottom: 10px;
    }

    /* 3. Kolom Kanan (QR Code) */
    .kop-kanan {
        width: 20%;
        /* Lebar SAMA dengan kiri biar seimbang */
        text-align: right; /* Ini memastikan QR Code merapat ke kanan */
        vertical-align: middle;
        padding-bottom: 10px;
    }

    .kop-tengah h2 {
        margin: 0;
        font-size: 20px;
        text-transform: uppercase;
        font-weight: 900;
        letter-spacing: 1px;
    }

    .kop-tengah p {
        margin: 0;
        font-size: 11px;
        line-height: 1.3;
    }

    .report-info {
        text-align: center;
        margin-top: 15px;
        margin-bottom: 20px;
    }

    .report-info h3 {
        margin: 0;
        font-size: 14px;
        text-transform: uppercase;
        text-decoration: underline;
    }

    .report-info p {
        margin: 2px 0;
        font-size: 11px;
        font-style: italic;
    }
</style>

<table class="kop-surat">
    <tr>
        <td class="kop-kiri">
            <img src="{{ public_path('logo/kud-logo.jpg') }}" style="width: 80px; height: auto;">
        </td>

        <td class="kop-tengah">
            <h2>KUD GAJAH MADA</h2>
            <p>
                Desa Telaga Sari, Kecamatan Kelumpang Hilir, Kabupaten Kotabaru,<br>
                Provinsi Kalimantan Selatan, Kode pos 72161
            </p>
        </td>

        <td class="kop-kanan">
            {{-- Render QR Code sebagai Base64 SVG agar terbaca oleh DomPDF --}}
            @if(isset($qrCodeData))
                <img src="data:image/svg+xml;base64, {!! base64_encode(QrCode::format('svg')->size(80)->generate($qrCodeData)) !!}" style="width: 80px; height: auto;">
            @endif
        </td>
    </tr>
</table>

<div class="report-info">
    <h3>{{ $title ?? 'Laporan KUD' }}</h3>

    @if (isset($subtitle) && $subtitle)
        <p>{{ $subtitle }}</p>
    @endif

    </div>