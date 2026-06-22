<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>KUD Gajah Mada</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50">

    <nav class="bg-white shadow-md fixed w-full z-10 top-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo/kud-logo.jpg') }}" class="h-10 w-10 rounded-full border border-pink-500">
                    <span class="font-bold text-xl text-pink-700">KUD GAMA</span>
                </div>

                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="text-sm font-semibold text-white bg-pink-600 px-4 py-2 rounded-full hover:bg-pink-700 transition">
                                Dashboard Admin
                            </a>
                        @else
                            <a href="{{ route('public.register') }}"
                                class="text-sm font-semibold text-pink-600 hover:text-pink-800">
                                Daftar Anggota
                            </a>
                            <a href="{{ route('login') }}"
                                class="text-sm font-semibold text-white bg-pink-600 px-4 py-2 rounded-full hover:bg-pink-700 transition">
                                Masuk (Admin)
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="pt-24 pb-12 bg-gradient-to-br from-pink-50 to-white text-center px-4">
        <div class="max-w-3xl mx-auto">
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6 leading-tight">
                Selamat Datang di <br> <span class="text-pink-600">KUD Gajah Mada</span>
            </h1>
            <p class="text-lg text-gray-600 mb-8">
                Desa Telaga Sari, Kec. Kelumpang Hilir, Kab. Kotabaru. <br>
                Mewujudkan kesejahteraan anggota melalui pengelolaan lahan sawit yang transparan dan profesional.
            </p>

            <div class="flex justify-center gap-4">
                <a href="{{ route('public.register') }}"
                    class="px-8 py-3 bg-pink-600 text-white font-bold rounded-lg shadow-lg hover:bg-pink-700 hover:-translate-y-1 transition transform">
                    Daftar Jadi Anggota Sekarang
                </a>
                <a href="#fitur"
                    class="px-8 py-3 bg-white text-pink-600 border border-pink-600 font-bold rounded-lg hover:bg-pink-50 transition">
                    Cek Status
                </a>
            </div>
        </div>
    </div>

    <div id="fitur" class="py-16 bg-white">
        <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-3 gap-8 text-center">
            <div
                class="p-6 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 group hover:border-pink-200">
                <div
                    class="bg-pink-100 w-14 h-14 mx-auto rounded-full flex items-center justify-center mb-4 text-pink-600 group-hover:bg-pink-600 group-hover:text-white transition">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2 text-gray-800">Pendaftaran Mudah</h3>
                <p class="text-sm text-gray-500">Isi formulir secara online dan upload berkas dari rumah tanpa antri.
                </p>
            </div>

            <div
                class="p-6 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 group hover:border-green-200">
                <div
                    class="bg-green-100 w-14 h-14 mx-auto rounded-full flex items-center justify-center mb-4 text-green-600 group-hover:bg-green-600 group-hover:text-white transition">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2 text-gray-800">Kartu Anggota Digital</h3>
                <p class="text-sm text-gray-500">Dilengkapi QR Code validasi untuk menjamin keaslian data anggota.</p>
            </div>

            <div
                class="p-6 rounded-xl shadow-sm hover:shadow-md transition border border-gray-100 group hover:border-blue-200">
                <div
                    class="bg-blue-100 w-14 h-14 mx-auto rounded-full flex items-center justify-center mb-4 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <h3 class="font-bold text-lg mb-2 text-gray-800">Transparan</h3>
                <p class="text-sm text-gray-500">Pengelolaan data lahan dan administrasi yang terbuka dan akuntabel.</p>
            </div>
        </div>
    </div>

    <!-- Memanggil file partial _visi_misi.blade.php -->
    @include('partials._visi_misi')

    <footer class="bg-pink-900 text-white py-8 text-center">
        <p>&copy; {{ date('Y') }} KUD Gajah Mada. All rights reserved.</p>
        <p class="text-xs text-pink-200 mt-2">Dibuat dengan ❤️ untuk Desa Telaga Sari</p>
    </footer>

</body>

</html>
