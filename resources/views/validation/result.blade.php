<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Anggota KUD</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen p-4">

    @if ($member->status === 'active')
        <div class="bg-white p-8 rounded-2xl shadow-xl max-w-sm w-full text-center border-t-8 border-green-600">
            <div class="mx-auto w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-1">DATA VALID</h2>
            <p class="text-sm text-gray-500 mb-6">Anggota Resmi KUD Gajah Mada</p>

            <div class="bg-gray-50 p-4 rounded-lg text-left text-sm space-y-2 border border-gray-200">
                <div class="flex justify-between">
                    <span class="text-gray-500">Nama:</span>
                    <span class="font-bold text-gray-800 text-right">{{ strtoupper($member->nama_lengkap) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">No. Anggota:</span>
                    <span class="font-bold text-gray-800">{{ $member->nomor_anggota }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Dusun:</span>
                    <span class="font-bold text-gray-800">{{ $member->dusun }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Bergabung:</span>
                    <span
                        class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($member->tanggal_bergabung)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="flex justify-between pt-2 mt-2 border-t border-gray-200">
                    <span class="text-gray-500">Status Lahan:</span>
                    <span class="font-bold text-green-600">{{ $member->luasan_lahan }} Ha (Terverifikasi)</span>
                </div>
            </div>

            <p class="mt-6 text-xs text-gray-400">
                Data ditarik secara real-time pada <br> {{ now()->translatedFormat('d M Y, H:i') }}
            </p>
        </div>
    @else
        <div class="bg-white p-8 rounded-2xl shadow-xl max-w-sm w-full text-center border-t-8 border-red-600">
            <div class="mx-auto w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mb-4">
                <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-red-700 mb-1">TIDAK AKTIF</h2>
            <p class="text-sm text-gray-500 mb-6">Status Keanggotaan Dibekukan/Berhenti</p>

            <div class="bg-gray-50 p-4 rounded-lg text-left text-sm space-y-2 border border-gray-200">
                <div class="flex justify-between">
                    <span class="text-gray-500">Nama:</span>
                    <span class="font-bold text-gray-800 text-right">{{ strtoupper($member->nama_lengkap) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">No. Anggota:</span>
                    <span class="font-bold text-gray-800">{{ $member->nomor_anggota }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Bergabung:</span>
                    <span
                        class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($member->tanggal_bergabung)->translatedFormat('d F Y') }}</span>
                </div>
                <div class="flex justify-between mt-2 pt-2 border-t border-gray-200">
                    <span class="text-gray-500">Status Saat Ini:</span>
                    <span class="font-bold text-red-600 uppercase">{{ $member->status }}</span>
                </div>
            </div>

            <p class="mt-6 text-xs text-gray-400">
                Harap hubungi pengurus KUD Gajah Mada untuk info lebih lanjut.
            </p>
        </div>
    @endif

</body>

</html>
