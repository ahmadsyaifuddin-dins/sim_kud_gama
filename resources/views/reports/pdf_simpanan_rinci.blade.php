@extends('reports.layout_pdf')

@section('content')
    <style>
        /* Pertahankan warna biru khas laporan simpanan */
        .data-table th {
            background-color: #dbeafe !important;
        }

        /* Style khusus untuk tabel rekap agar tidak terlalu lebar */
        .rekap-table {
            width: 60%;
            margin-top: 30px;
        }

        .rekap-table th {
            background-color: #bfdbfe !important;
        }
    </style>

    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">Tanggal Setor</th>
                <th width="25%">Nama Anggota</th>
                <th width="15%">Jenis Simpanan</th>
                <th width="20%">Keterangan</th>
                <th width="20%">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @php $totalNominal = 0; @endphp

            {{-- Menggunakan $data sesuai arsitektur Trait kita --}}
            @forelse($data as $index => $item)
                @php $totalNominal += $item->jumlah; @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">
                        {{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->translatedFormat('d M Y') : '-' }}
                    </td>
                    <td>
                        {{ $item->member->nama_lengkap ?? 'Anggota Dihapus' }} <br>
                        <small style="color: #666;">{{ $item->member->nomor_anggota ?? '-' }}</small>
                    </td>
                    <td class="text-center" style="text-transform: capitalize;">{{ $item->jenis_simpanan }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td class="text-right">{{ number_format($item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 10px;">
                        <em>Tidak ada transaksi simpanan pada periode ini.</em>
                    </td>
                </tr>
            @endforelse
        </tbody>

        {{-- Sembunyikan tfoot jika data kosong --}}
        @if ($data->count() > 0)
            <tfoot>
                <tr style="background-color: #f3f4f6; font-weight: bold;">
                    <td colspan="5" class="text-right" style="padding-right: 10px;">TOTAL SETORAN :</td>
                    <td class="text-right">Rp {{ number_format($totalNominal, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        @endif
    </table>

    {{-- TABEL REKAPITULASI MUNCUL JIKA ADA DATA --}}
    @if ($data->count() > 0 && isset($rekapSimpanan))
        <h4 style="margin-top: 30px; margin-bottom: 10px; color: #374151;">Rekapitulasi Berdasarkan Jenis Simpanan</h4>
        <table class="data-table rekap-table">
            <thead>
                <tr>
                    <th width="40%">Jenis Simpanan</th>
                    <th width="25%">Jumlah Transaksi</th>
                    <th width="35%">Total (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($rekapSimpanan as $rekap)
                    <tr>
                        <td style="text-transform: capitalize;">{{ $rekap->jenis_simpanan }}</td>
                        <td class="text-center">{{ $rekap->total_transaksi }}x Setoran</td>
                        <td class="text-right">{{ number_format($rekap->total_uang, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
