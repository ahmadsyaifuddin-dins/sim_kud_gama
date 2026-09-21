<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIM KUD GAMA') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-roboto antialiased text-gray-900 bg-pink-50">

    {{-- Latar aurora futuristik --}}
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div
            class="absolute -top-28 -left-28 h-[26rem] w-[26rem] rounded-full bg-gradient-to-br from-pink-300 via-fuchsia-300 to-rose-300 opacity-50 blur-3xl">
        </div>
        <div
            class="absolute -bottom-32 -right-24 h-[30rem] w-[30rem] rounded-full bg-gradient-to-tl from-fuchsia-300 via-purple-300 to-pink-200 opacity-50 blur-3xl">
        </div>
        <div class="absolute top-1/4 left-1/2 h-72 w-72 -translate-x-1/2 rounded-full bg-gradient-to-tr from-rose-200 to-pink-200 opacity-40 blur-3xl">
        </div>
    </div>

    <div class="relative flex min-h-screen">

        {{-- Bagian kiri: form login --}}
        <div class="flex flex-col justify-center flex-1 px-4 py-12 sm:px-6 lg:flex-none lg:w-1/2 xl:w-5/12">
            <div class="w-full max-w-md mx-auto lg:max-w-sm xl:max-w-md">
                <div
                    class="relative overflow-hidden p-8 sm:p-10 border border-white/60 bg-white/70 rounded-[2rem] shadow-2xl shadow-rose-300/50 backdrop-blur-xl">
                    {{-- garis gradien atas --}}
                    <div
                        class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-pink-500 via-rose-400 to-fuchsia-500">
                    </div>
                    {{-- dekorasi orb kecil --}}
                    <div
                        class="absolute -top-10 -right-10 h-28 w-28 rounded-full bg-gradient-to-br from-pink-300/50 to-fuchsia-300/50 blur-2xl pointer-events-none">
                    </div>

                    {{-- Brand (mobile & semua posisi layar kecil) --}}
                    <div class="relative mb-8 text-center">
                        <div class="inline-flex p-1 mb-3 bg-white rounded-full shadow-lg shadow-pink-200/60">
                            <img src="{{ asset('logo/kud-logo.jpg') }}" alt="Logo KUD"
                                class="object-cover w-16 h-16 rounded-full">
                        </div>
                        <h1 class="text-2xl font-extrabold text-gray-900">SIM KUD GAMA</h1>
                        <p class="text-sm text-gray-500">Sistem Informasi Manajemen KUD Gajah Mada</p>
                    </div>

                    <div class="relative">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Bagian kanan: gambar lokasi KUD --}}
        <div class="relative flex-1 hidden w-0 lg:block">
            <img class="absolute inset-0 object-cover w-full h-full" src="{{ asset('Kantor-KUD.jpg') }}"
                alt="Kantor KUD Gajah Mada Desa Telagasari">
            <div
                class="absolute inset-0 bg-gradient-to-br from-pink-700/60 via-rose-600/30 to-fuchsia-700/60 mix-blend-multiply">
            </div>
            <div class="absolute inset-0 bg-gradient-to-t from-pink-900/80 via-transparent to-transparent"></div>

            {{-- teks selamat datang di atas gambar --}}
            <div class="absolute inset-0 flex items-center justify-center px-10">
                <div class="text-center text-white max-w-sm">
                    <span
                        class="inline-flex items-center gap-2 px-4 py-1.5 mb-5 text-xs font-bold tracking-[0.25em] uppercase bg-white/15 rounded-full border border-white/25 backdrop-blur">
                        <i class="fa-solid fa-heart text-pink-200"></i> Koperasi Gajah Mada
                    </span>
                    <h2 class="text-4xl font-black leading-tight drop-shadow-lg">Selamat Datang di<br>SIM KUD GAMA</h2>
                    <p class="mt-4 text-sm leading-relaxed text-pink-50/90">
                        Kelola anggota, simpanan, pinjaman, angsuran, hingga pembagian SHU dalam satu aplikasi modern.
                    </p>
                </div>
            </div>

            {{-- caption lokasi --}}
            <div class="absolute bottom-8 left-8 right-8">
                <div
                    class="flex items-center justify-between p-4 rounded-2xl bg-white/10 border border-white/20 backdrop-blur-md">
                    <div class="flex items-center gap-3 text-white">
                        <i class="fa-solid fa-location-dot text-pink-200 text-xl"></i>
                        <div>
                            <p class="text-sm font-bold">Kantor KUD Gajah Mada</p>
                            <p class="text-xs text-pink-100/80">Desa Telagasari, Kab. Kotabaru</p>
                        </div>
                    </div>
                    <i class="fa-solid fa-arrow-right text-pink-200 text-lg"></i>
                </div>
            </div>
        </div>

    </div>
</body>

</html>