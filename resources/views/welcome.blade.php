<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'KUD Gajah Mada') }} — Sistem Informasi Manajemen</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Poppins:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Poppins', sans-serif;
        }

        html {
            scroll-behavior: smooth;
        }

        .reveal {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .7s ease, transform .7s ease;
        }

        .reveal.in-view {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-white font-sans text-gray-800 antialiased">

    @include('partials.public._navbar')

    <main>
        @include('partials.public._hero')
        @include('partials.public._stats')
        @include('partials.public._features')
        @include('partials._visi_misi')
        @include('partials.public._cta')
    </main>

    @include('partials.public._footer')

    <script>
        // Navbar transparan di atas, solid setelah scroll
        const navbar = document.getElementById('navbar');
        const setNavbar = () => {
            if (window.scrollY > 24) {
                navbar.classList.add('bg-white/90', 'shadow-lg', 'shadow-pink-100', 'backdrop-blur-md', 'border-b',
                    'border-pink-100');
                navbar.classList.remove('bg-transparent');
            } else {
                navbar.classList.remove('bg-white/90', 'shadow-lg', 'shadow-pink-100', 'backdrop-blur-md', 'border-b',
                    'border-pink-100');
                navbar.classList.add('bg-transparent');
            }
        };
        setNavbar();
        window.addEventListener('scroll', setNavbar, { passive: true });

        // Animasi muncul saat elemen terlihat
        const io = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('in-view');
                    io.unobserve(entry.target);
                }
            });
        }, { threshold: 0.12 });
        document.querySelectorAll('.reveal').forEach((el) => io.observe(el));
    </script>

</body>

</html>