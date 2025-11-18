<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <title>Perpustakaan Online</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('template/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('template/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/templatemo-lugx-gaming.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('template/css/owl.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css" />

    @stack('styles')
    <style>
        body {
            padding-top: 120px; /* Sesuaikan dengan tinggi navbar */
        }

        @media (max-width: 768px) {
            body {
                padding-top: 140px;
            }
        }
    </style>
</head>

<body>

    <!-- ***** Preloader Start ***** -->
    <div id="js-preloader" class="js-preloader">
        <div class="preloader-inner">
            <span class="dot"></span>
            <div class="dots">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
    <!-- ***** Preloader End ***** -->

    <!-- ***** Header Area Start ***** -->
    @include('layouts.header')
    <!-- ***** Header Area End ***** -->

    {{-- Banner utama --}}
    @hasSection('main-banner')
    <div class="main-banner">
        @yield('main-banner')
    </div>
    @endif

    {{-- Statistik --}}
    @hasSection('statistik')
    <div class="statistik">
        @yield('statistik')
    </div>
    @endif

    {{-- Fitur tambahan --}}
    @hasSection('features')
    <div class="features">
        @yield('features')
    </div>
    @endif

    {{-- Trending section --}}
    @hasSection('section-trending')
    <div class="section trending">
        @yield('section-trending')
    </div>
    @endif

    {{-- Most Played --}}
    @hasSection('section-most-played')
    <div class="section most-played">
        @yield('section-most-played')
    </div>
    @endif

    {{-- Kategori --}}
    @hasSection('section-categoris')
    <div class="section categories">
        @yield('section-categoris')
    </div>
    @endif

    {{-- CTA (Call to Action) --}}
    @hasSection('section-cta')
    <div class="section cta">
        @yield('section-cta')
    </div>
    @endif

    {{-- Konten dinamis (default) --}}
    @hasSection('content')
    <div class="container py-5">
        @yield('content')
    </div>
    @endif

    <!-- ***** Footer Area Start ***** -->
    @include('layouts.footer')
    <!-- ***** Footer Area End ***** -->

    <!-- Scripts -->
    <script src="{{ asset('template/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('template/js/isotope.min.js') }}"></script>
    <script src="{{ asset('template/js/owl-carousel.js') }}"></script>
    <script src="{{ asset('template/js/counter.js') }}"></script>
    <script src="{{ asset('template/js/custom.js') }}"></script>

    @stack('scripts')

</body>

</html>
