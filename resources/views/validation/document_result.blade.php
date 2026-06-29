<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Validasi Dokumen - KUD Gajah Mada</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-gray-800 font-sans antialiased selection:bg-green-500 selection:text-white">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        
        <div class="mb-6 text-center">
            <img src="{{ asset('logo/kud-logo.jpg') }}" alt="Logo KUD Gajah Mada" class="w-20 h-auto mx-auto mb-3 rounded-full shadow-sm">
            <h1 class="text-xl font-bold text-gray-700 tracking-wide">KUD GAJAH MADA</h1>
        </div>

        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden border border-gray-100">
            
            @if($isValid)
                <div class="bg-green-500 p-6 text-center">
                    <svg class="w-16 h-16 mx-auto text-white animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h2 class="mt-4 text-2xl font-black text-white uppercase tracking-wider">Dokumen Valid</h2>
                </div>
                
                <div class="p-6">
                    <p class="text-sm text-gray-600 text-center mb-6 leading-relaxed">
                        {{ $message }}
                    </p>
                    
                    <div class="space-y-4">
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex flex-col">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Jenis Dokumen</span>
                            <span class="text-lg font-bold text-gray-800">{{ $reportName }}</span>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 flex flex-col">
                            <span class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Waktu Cetak</span>
                            <span class="text-base font-bold text-gray-800">{{ $printDate }}</span>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-red-500 p-6 text-center">
                    <svg class="w-16 h-16 mx-auto text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h2 class="mt-4 text-2xl font-black text-white uppercase tracking-wider">Tidak Valid</h2>
                </div>
                
                <div class="p-6 text-center">
                    <p class="text-base font-semibold text-gray-700 mb-4">{{ $message }}</p>
                    <div class="p-4 bg-red-50 text-red-700 text-sm rounded-xl border border-red-100">
                        Pastikan Anda melakukan scan QR Code langsung dari dokumen fisik asli yang diterbitkan oleh sistem KUD Gajah Mada.
                    </div>
                </div>
            @endif

        </div>

        <div class="mt-10 text-center text-xs font-medium text-gray-400">
            &copy; {{ date('Y') }} SIMKUD GAMA.<br>Sistem Informasi Manajemen KUD Gajah Mada.
        </div>
        
    </div>
</body>
</html>