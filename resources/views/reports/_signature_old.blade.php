<style>
    .signature-wrapper {
        margin-top: 30px;
        width: 100%;
        text-align: right;
        /* Hati-hati dengan page-break di PDF */
        page-break-inside: avoid;
    }

    .signature-box {
        display: inline-block;
        width: 200px;
        text-align: center;
    }

    .signature-space {
        height: 60px;
        /* Ruang untuk tanda tangan basah */
    }
</style>

<div class="signature-wrapper">
    <div class="signature-box">
        <p>Kotabaru, {{ now()->translatedFormat('d F Y') }}</p>

        <p>{{ $role ?? 'Mengetahui,' }}</p>

        <div class="signature-space"></div>

        <p style="font-weight: bold; text-decoration: underline;">
            ( ........................................ )
        </p>
    </div>
</div>
