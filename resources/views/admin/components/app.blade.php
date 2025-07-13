<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - E-Commerce</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- ✅ File CSS Custom -->
    @vite(['resources/css/style-admin.css'])
    <!-- ✅ Animasi JS -->
    @vite(['resources/js/animation-admin.js'])

    <!-- ✅ Favicon (Logo Tab Browser) -->
    <link rel="icon" href="{{ asset('assets/img/insulmart_new1.png') }}" type="image/png">
</head>
<body>

@include('admin.components.navbar')

@include('admin.components.sidebar')

    @yield('content')

@include('admin.components.footer')
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>
</html>
