<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="google-site-verification" content="RWX0JoxC1qJ7luCnwj1CLxSPkaz5nAonaf3y0ULq0ZA" />
        <title>Marketplace Material Insulasi Terlengkap | Insulmart</title>

        <!-- Resource hints -->
        <link rel="dns-prefetch" href="//cdn.jsdelivr.net">
        <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
        <link rel="dns-prefetch" href="//cdnjs.cloudflare.com">
        <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>

        <!-- Bootstrap CSS (render-blocking, biarkan di atas) -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
                rel="stylesheet"
                integrity="sha384-ENjdO4Dr2bkBIFxQpeo5P0nJY7HRj6ax1VuGIPQnZjWQyYdNH+cRb1YJST8gJ3mo"
                crossorigin="anonymous">

        <!-- Ikon: PAKAI SATU (Bootstrap Icons) -->
        <link rel="stylesheet"
                href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

        <!-- CSS lokal (versi untuk cache-busting) -->
        @php $cssv = file_exists(public_path('assets/css/style.css')) ? filemtime(public_path('assets/css/style.css')) : time(); @endphp
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}?v={{ $cssv }}">

        <!-- JS lokal: jangan block render -->
        @php $jsv = file_exists(public_path('assets/js/animation.js')) ? filemtime(public_path('assets/js/animation.js')) : time(); @endphp
        <script src="{{ asset('assets/js/animation.js') }}?v={{ $jsv }}" defer></script>

        <!-- Bootstrap bundle JS (sudah defer) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-qN5FJ4AhFJ6zh8eb+ZK5mC2J3e0I5vVr8u9gRgtnXdhYVRA42jTpej25F8I+hsY6"
                crossorigin="anonymous" defer></script>

        <!-- Favicon -->
        <link rel="icon" href="{{ asset('assets/img/insulmart_new1.png') }}" type="image/png">
        <link rel="preload" as="image" href="{{ asset('assets/img/landing/7.png') }}">
    </head>
<body>
    @include('components.navbar')

    @yield('content')

    @include('components.footer', ['produks' => $produks])

    <!-- ✅ SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.min.js" integrity="sha384-7qAoOXltbVP82dhxHAUje59V5r2YsVfBafyUDxEdApLPmcdhBPg1DKg1ERo0BZlK" crossorigin="anonymous"></script>
    @stack('scripts')
</body>
</html>
