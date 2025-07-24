<!-- resources/views/errors/404.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>404 - Halaman Tidak Ditemukan</title>
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
            border-radius: 22px;
            box-shadow: 0 6px 42px -14px #8000002a;
            padding: 46px 36px 34px 36px;
            max-width: 425px;
            width: 96%;
            text-align: center;
            position: relative;
        }
        .error-emoji {
            font-size: 4.4rem;
            margin-bottom: 9px;
            line-height: 1.1;
            filter: drop-shadow(0 2px 7px #fbecec);
        }
        .error-code {
            font-size: 3.2rem;
            font-weight: 900;
            color: var(--maroon-dark);
            letter-spacing: 2.5px;
            margin: 0 0 5px 0;
        }
        .error-message {
            font-size: 1.3rem;
            color: #111;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .error-desc {
            color: #a32638;
            margin-bottom: 32px;
            font-size: 1.08rem;
        }
        .home-btn {
            display: inline-block;
            background: var(--maroon-gradient);
            color: #fff;
            padding: 13px 28px;
            font-size: 1.09rem;
            font-weight: 700;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            box-shadow: 0 2px 14px -2px #80000022;
            transition: background 0.15s, transform 0.13s;
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
        <div class="error-emoji">🔍</div>
        <div class="error-code">404</div>
        <div class="error-message">Halaman Tidak Ditemukan</div>
        <div class="error-desc">
            Maaf, halaman yang Anda cari<br>
            <b>tidak tersedia atau telah dipindahkan.</b>
        </div>
        <a href="{{ url('/') }}" class="home-btn">
            &larr; Kembali ke Beranda
        </a>
    </div>
</body>
</html>
