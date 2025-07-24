<!-- resources/views/errors/403.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>403 - Tidak Memiliki Akses</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        :root {
            --maroon-dark: #800000;
            --maroon-gradient: linear-gradient(135deg, #800000 0%, #a32638 100%);
            --maroon-light: #fbecec;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: 'Inter', Arial, sans-serif;
            background: var(--maroon-light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 4px 40px -10px #80000033;
            padding: 46px 36px 34px 36px;
            max-width: 410px;
            width: 98%;
            text-align: center;
            position: relative;
        }
        .error-emoji {
            font-size: 4.2rem;
            margin-bottom: 10px;
            filter: drop-shadow(0 2px 7px #fbecec);
            line-height: 1.1;
        }
        .error-code {
            font-size: 3.1rem;
            font-weight: bold;
            color: var(--maroon-dark);
            letter-spacing: 2px;
            margin: 0 0 4px 0;
        }
        .error-message {
            font-size: 1.19rem;
            color: #222;
            margin: 8px 0 14px 0;
            font-weight: 600;
        }
        .error-desc {
            color: #a32638;
            margin-bottom: 32px;
            font-size: 1.06rem;
        }
        .home-btn {
            display: inline-block;
            background: var(--maroon-gradient);
            color: #fff;
            padding: 12px 28px;
            font-size: 1.08rem;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            box-shadow: 0 2px 14px -2px #80000022;
            transition: background 0.15s, transform 0.12s;
        }
        .home-btn:hover, .home-btn:focus {
            background: linear-gradient(135deg, #a32638 0%, #800000 100%);
            color: #fff;
            transform: translateY(-2px) scale(1.03);
        }
        @media (max-width: 480px) {
            .error-container { padding: 22px 4vw 17px 4vw; }
            .error-emoji { font-size: 2.3rem; }
            .error-code { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-emoji">🚫</div>
        <div class="error-code">403</div>
        <div class="error-message">Akses Ditolak</div>
        <div class="error-desc">
            Anda tidak memiliki izin untuk mengakses halaman ini.<br>
            Silakan hubungi admin jika menurut Anda ini adalah kesalahan.
        </div>
        <a href="{{ url('/') }}" class="home-btn">
            &larr; Kembali ke Beranda
        </a>
    </div>
</body>
</html>
