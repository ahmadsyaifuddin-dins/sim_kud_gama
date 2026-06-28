@extends('reports.layout_pdf')

@section('content')
<table class="data-table">
    <thead>
        <tr>
            <th width="5%">No</th>
            <th width="15%">No. Anggota</th>
            <th width="20%">Nama Lengkap</th>
            <th width="10%">Jenis Kelamin</th>
            <th width="15%">Dusun</th>
            <th width="15%">Tgl Bergabung</th>
            <th width="10%">Lama Gabung</th> 
            <th width="10%">Status</th>
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
                <td class="text-center">{{ $item->jenis_kelamin }}</td>
                <td class="text-center">{{ $item->dusun }}</td>
                <td class="text-center">
                    {{ \Carbon\Carbon::parse($item->tanggal_bergabung)->translatedFormat('d M Y') }}
                </td>
                <td class="text-center">
                    {{ \Carbon\Carbon::parse($item->tanggal_bergabung)->diffForHumans(null, true) }}
                </td>
                <td class="text-center">
                    <strong>{{ strtoupper($item->status) }}</strong>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center" style="padding: 15px;">
                    <em>Tidak ada data anggota yang sesuai dengan filter.</em>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
@endsection