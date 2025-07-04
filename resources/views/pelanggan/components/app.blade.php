<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Pelanggan - Insulmart</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="{{ asset('assets/img/insulmart_new1.png') }}" type="image/png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

    @include('pelanggan.components.navbar')



    @yield('content')

    @include('pelanggan.components.footer')

<!-- Script untuk Toggle -->
<script>
  document.getElementById('navbar-toggle').addEventListener('click', function () {
    document.getElementById('navbar-menu').classList.toggle('show');
  });
</script>
</body>
</html>
