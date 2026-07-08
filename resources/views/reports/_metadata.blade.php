<div class="metadata-box">
    <table class="metadata-table">
        <tbody>
            <tr>
                <td width="15%"><strong>Waktu Cetak</strong></td>
                <td width="35%">: {{ now()->translatedFormat('l, d F Y H:i') }} WITA</td>
                <td width="15%"><strong>Total Data</strong></td>
                <td width="35%">: {{ $totalData ?? 0 }} Baris Data</td>
            </tr>

            {{-- Tambahan Khusus untuk Laporan KTA --}}
            @if (isset($sudahCetak) && isset($belumCetak))
                <tr>
                    <td><strong>Sudah Tercetak</strong></td>
                    <td>: {{ $sudahCetak }} Anggota</td>
                    <td><strong>Belum Tercetak</strong></td>
                    <td>: {{ $belumCetak }} Anggota</td>
                </tr>
            @endif

            {{-- Tambahan Khusus untuk Laporan Pinjaman --}}
            @if (isset($totalLunas))
                <tr>
                    <td><strong>Total Lunas</strong></td>
                    <td colspan="3">: {{ $totalLunas }} Pinjaman</td>
                </tr>
            @endif

            {{-- Filter Aktif --}}
            @if (isset($activeFilters) && count($activeFilters) > 0)
                @foreach ($activeFilters as $label => $value)
                    <tr>
                        <td><strong>{{ $label }}</strong></td>
                        <td colspan="3">: {{ $value }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
