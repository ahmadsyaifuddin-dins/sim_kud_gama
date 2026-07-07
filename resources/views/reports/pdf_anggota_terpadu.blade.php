@extends('reports.layout_pdf')

@section('content')
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="12%">No. Anggota</th>
                <th width="18%">Nama Lengkap</th>
                <th width="15%">Tempat, Tgl Lahir</th>
                <th width="8%">JK</th>
                <th width="12%">Dusun</th>
                <th width="12%">Tgl Bergabung</th>
                <th width="10%">Lama Gabung</th>
                <th width="8%">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $item->nomor_anggota }}</td>
                    <td>
                        <strong>{{ $item->nama_lengkap }}</strong><br>
                        <small style="color: #555;">NIK: {{ $item->nik }}</small>
                    </td>

                    <td>
                        {{ $item->tempat_lahir }}, <br>
                        {{ \Carbon\Carbon::parse($item->tanggal_lahir)->translatedFormat('d M Y') }}
                    </td>

                    <td class="text-center">{{ $item->jenis_kelamin }}</td>
                    <td class="text-center">{{ $item->dusun }}</td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_bergabung)->translatedFormat('d M Y') }}
                    </td>
                    <td class="text-center">
                        {{ \Carbon\Carbon::parse($item->tanggal_bergabung)->diffForHumans(null, true) }}
                    </td>
                    <td class="text-center">
                        @php
                            $statusRaw = strtolower($item->status);

                            // 1. Menentukan Bahasa
                            $statusLabel = match ($statusRaw) {
                                'active' => 'AKTIF',
                                'inactive' => 'NON-AKTIF',
                                'stopped' => 'BERHENTI',
                                default => strtoupper($item->status),
                            };

                            // 2. Menentukan Kode Warna (Hex Code)
                            $statusColor = match ($statusRaw) {
                                'active' => '#15803d', /* Hijau Gelap agar jelas di print putih/kertas */
                                'inactive' => '#f59e0b', /* Oranye Gelap */
                                'stopped' => '#b91c1c', /* Merah Gelap */
                                default => '#374151', /* Abu-abu (Default) */
                            };
                        @endphp

                        <strong style="color: {{ $statusColor }};">
                            {{ $statusLabel }}
                        </strong>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center" style="padding: 15px;"> <em>Tidak ada data anggota yang sesuai
                            dengan filter.</em>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
