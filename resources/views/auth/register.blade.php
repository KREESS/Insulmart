<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Akun</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- ✅ Favicon (Logo Tab Browser) -->
    <link rel="icon" href="assets/img/insulmart_new1.png" type="image/png">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #8B0000, #a60000);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wrapper {
            display: flex;
            width: 100%;
            max-width: 1200px;
            min-height: 80vh;
            background-color: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.25);
            position: relative;
        }

        .image-side {
            flex: 1;
            background: url('{{ asset("assets/img/kiri.png") }}') no-repeat center center;
            background-size: cover;
        }

        .form-side {
            flex: 1;
            padding: 50px 40px;
            background-color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .register-card {
            width: 100%;
        }

        .register-title {
            color: #8B0000;
            font-weight: bold;
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-register {
            background-color: #8B0000;
            border: none;
        }

        .btn-register:hover {
            background-color: #a60000;
        }

        .form-control:focus {
            border-color: #8B0000;
            box-shadow: 0 0 0 0.15rem rgba(139, 0, 0, 0.25);
        }

        .btn-back {
            position: absolute;
            top: 20px;
            left: 20px;
            display: inline-flex;
            align-items: center;
            padding: 6px 12px;
            font-size: 14px;
            color: #8B0000;
            background-color: #f8f9fa;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            transition: all 0.2s ease-in-out;
        }

        .btn-back:hover {
            background-color: #e2e6ea;
            color: #a60000;
        }

        @media (max-width: 768px) {
            .wrapper {
                flex-direction: column;
                border-radius: 0;
            }

            .image-side {
                display: none;
            }

            .form-side {
                padding: 40px 20px;
            }

            .btn-back {
                position: static;
                display: block;
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <!-- Gambar Kiri -->
    <div class="image-side"></div>

    <!-- Form Register -->
    <div class="form-side">
        <div class="register-card">
            <a href="{{ url('/') }}" class="btn-back">← Kembali ke Beranda</a>

            <h3 class="register-title">Buat Akun Baru</h3>

            <form method="POST" action="{{ url('/register') }}">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Alamat Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-register text-white">Daftar Sekarang</button>
                </div>

                <div class="text-center">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-decoration-none text-danger fw-bold">Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
