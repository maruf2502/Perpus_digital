<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <title>Perpustakaan Online</title>

    <!-- Bootstrap core CSS -->
    <link href={{ asset('template/vendor/bootstrap/css/bootstrap.min.css') }} rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href={{ asset("template/css/fontawesome.css") }}>
    <link rel="stylesheet" href={{ asset("template/css/templatemo-lugx-gaming.css") }}>
    <link rel="stylesheet" href={{ asset("template/css/animate.css") }}>
    <link rel="stylesheet" href={{ asset("template/css/owl.css") }}>
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    <!-- Custom CSS untuk fix navbar -->
    <style>
        /* Fix navbar overlay issue */
        body {
            margin: 0;
            padding: 0;
            padding-top: 140px;
            /* Sesuaikan dengan tinggi navbar */
        }

        @media (max-width: 768px) {
            body {
                padding-top: 120px;
                /* Untuk mobile */
            }
        }

        /* Pastikan navbar selalu di atas */
        .navbar {
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            z-index: 9999 !important;
            background-color: #007bff !important;
        }

        /* Styling untuk main content */
        .main-content {
            position: relative;
            z-index: 1;
            min-height: calc(100vh - 140px);
        }

        @media (max-width: 768px) {
            .main-content {
                min-height: calc(100vh - 120px);
            }
        }

        /* Pastikan container tidak overlap */
        .container {
            position: relative;
            z-index: 1;
        }

        /* Fix untuk elemen yang mungkin overlap */
        .book-card,
        .trending-book,
        .card,
        .row {
            position: relative;
            z-index: 1;
        }

        /* Debugging - hapus jika sudah fix */
        .navbar {
            border-bottom: 3px solid #0056b3;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

        {{-- Include header/navigation --}}
        @include('layouts.header')

        {{-- Main Content dengan class khusus --}}
        <main class="main-content">
            <div class="container">
                @yield('content')
            </div>
        </main>

        {{-- Include footer --}}
        @include('layouts.footer')

    </div>
</body>

</html>
