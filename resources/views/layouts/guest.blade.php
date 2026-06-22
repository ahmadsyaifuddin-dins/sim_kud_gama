<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIM KUD GAMA') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-roboto antialiased text-gray-900 bg-white">
    <div class="flex min-h-screen">

        <div class="flex flex-col justify-center flex-1 px-4 py-12 sm:px-6 lg:flex-none lg:w-1/2 xl:w-5/12 bg-white">
            <div class="w-full max-w-sm mx-auto lg:w-96">
                {{ $slot }}
            </div>
        </div>

        <div class="relative flex-1 hidden w-0 lg:block">
            <img class="absolute inset-0 object-cover w-full h-full" src="{{ asset('Kantor-KUD.jpg') }}"
                alt="Kantor KUD Gajah Mada Desa Telagasari">
            <div class="absolute inset-0 bg-gray-900/20 mix-blend-multiply"></div>
        </div>

    </div>
</body>

</html>
