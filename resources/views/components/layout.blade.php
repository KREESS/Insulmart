<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Toko Online Material Insulasi Terlengkap | Insulmart</title>

        <!-- ✅ Bootstrap CSS 5.3.0 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-ENjdO4Dr2bkBIFxQpeo5P0nJY7HRj6ax1VuGIPQnZjWQyYdNH+cRb1YJST8gJ3mo" crossorigin="anonymous">

        <!-- ✅ Font Awesome 6 (CDN cepat & stabil) -->
        <link rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.5.1/css/all.min.css"
            integrity="sha384-0evHe/X+R7YkSU7A9Kw7P4OPDHyw+3Ulwp8dw55zDZ81D9g3PC5lMZ9jdb4BQ+fX" crossorigin="anonymous">

        <!-- ✅ File CSS Custom -->
        @vite(['resources/css/style.css'])

        <!-- ✅ Animasi JS -->
        @vite(['resources/js/app.js'])

        <!-- ✅ Bootstrap JS (Popper & Bundle) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-qN5FJ4AhFJ6zh8eb+ZK5mC2J3e0I5vVr8u9gRgtnXdhYVRA42jTpej25F8I+hsY6" crossorigin="anonymous"
            defer></script>

        <!-- ✅ Favicon (Logo Tab Browser) -->
        <link rel="icon" href="assets/img/insulmart_new1.png" type="image/png">

        <!-- ✅ Font Awesome 6 -->
        <!-- Font Awesome 6 -->
        <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-C2n+EK3KBP3DMBuRZVnX0f5V63rEzP5g+Hqf2zBQ9U2BzStCH3t2e6RvnEZBP2QOqfF3fO0U7Hqg8QsU+nRAdg=="
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    </head>
<body>
    @include('components.navbar')

    @yield('content')

    @include('components.footer')



</body>
</html>
