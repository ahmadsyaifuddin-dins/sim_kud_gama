@php
    // 1. Tangkap variabel yang di-passing dari @include, beri nilai default jika kosong
    $type = $type ?? 'biasa';
    $jabatanKanan = $role ?? 'Ketua';
    $lokasi = 'Kotabaru';
    $tanggal = \Carbon\Carbon::now()->translatedFormat('d F Y');

    // 2. Query otomatis ke tabel managements untuk sisi Kanan (Sesuai $role)
    $pengurusKanan = \App\Models\Management::where('jabatan', $jabatanKanan)->where('is_active', true)->first();
    $namaKanan = $pengurusKanan ? $pengurusKanan->nama : '(Belum Ada Data ' . $jabatanKanan . ')';
    $idKanan = $pengurusKanan ? $pengurusKanan->no_hp : '...................';

    // 3. Query otomatis untuk sisi Kiri jika type laporan adalah 'keuangan'
    if ($type === 'keuangan') {
        $pengurusKiri = \App\Models\Management::where('jabatan', 'Bendahara')->where('is_active', true)->first();
        $namaKiri = $pengurusKiri ? $pengurusKiri->nama : '(Belum Ada Data Bendahara)';
        $idKiri = $pengurusKiri ? $pengurusKiri->no_hp : '...................';
    }

    // 4. Logika Lebar Kolom Dinamis (Trik agar TTD pas di kanan!)
    $leftWidth = $type === 'keuangan' ? '50%' : '70%';
    $rightWidth = $type === 'keuangan' ? '50%' : '30%';
@endphp

<table style="width: 100%; margin-top: 40px; page-break-inside: avoid; border: none;">
    <tr>
        <td
            style="width: {{ $leftWidth }}; text-align: center; font-size: 11px; border: none; vertical-align: bottom;">
            @if ($type === 'keuangan')
                <p style="margin: 0; margin-bottom: 5px;">&nbsp;</p>
                <p style="margin: 0;">Dibuat Oleh,</p>
                <p style="margin: 0; font-weight: bold;">
                    Bendahara KUD Gajah Mada
                </p>

                <br><br><br><br>

                <p style="margin: 0; font-weight: bold; text-decoration: underline;">
                    {{ $namaKiri }}
                </p>
                <p style="margin: 0;">No. {{ $idKiri }}</p>
            @endif
        </td>

        <td
            style="width: {{ $rightWidth }}; text-align: center; font-size: 11px; border: none; vertical-align: bottom;">
            <p style="margin: 0; margin-bottom: 5px;">
                {{ $lokasi }}, {{ $tanggal }}
            </p>
            <p style="margin: 0;">Mengetahui,</p>
            <p style="margin: 0; font-weight: bold;">
                {{ $jabatanKanan }} KUD Gajah Mada
            </p>

            <br><br><br><br>

            <p style="margin: 0; font-weight: bold; text-decoration: underline;">
                {{ $namaKanan }}
            </p>
            <p style="margin: 0;">No. {{ $idKanan }}</p>
        </td>
    </tr>
</table>
