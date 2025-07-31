@extends('admin.components.app')

@section('title', 'Edit Armada Pengiriman')

@section('content')
<style>
    :root {
        --maroon: #800000;
        --maroon-light: #a94442;
        --gradient-maroon: linear-gradient(135deg, #800000, #a94442);
        --gray-light: #f9f9f9;
        --shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
        --hover-input: #fff1f1;
    }

    .main-content {
        background: var(--gray-light);
        min-height: 100vh;
        padding: 3rem 1.5rem;
    }

    .form-container {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
    }

    .form-card {
        background: #fff;
        padding: 48px 36px 36px 36px;
        border-radius: 24px;
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
        animation: fadeInUp 0.5s ease;
        z-index: 1;
    }

    .form-card::before {
        content: '';
        position: absolute;
        top: -40px;
        right: -40px;
        width: 120px;
        height: 120px;
        background: var(--gradient-maroon);
        opacity: 0.08;
        transform: rotate(45deg);
        border-radius: 12px;
        z-index: 0;
    }

    .form-header {
        display: flex;
        align-items: center;
        margin-bottom: 28px;
        z-index: 2;
        position: relative;
    }

    .form-header i {
        font-size: 1.6rem;
        color: var(--maroon);
        margin-right: 10px;
    }

    .form-header h5 {
        font-weight: 700;
        margin: 0;
        color: var(--maroon);
    }

    label {
        font-weight: 600;
        margin-bottom: 6px;
        color: #444;
    }

    .form-control {
        background: #fff;
        transition: all 0.3s ease;
    }

    .form-control:hover {
        background: var(--hover-input);
    }

    .form-control:focus {
        border-color: var(--maroon-light);
        box-shadow: 0 0 0 0.2rem rgba(128, 0, 0, 0.15);
    }

    .input-group-text {
        background: var(--maroon);
        color: #fff;
        font-weight: 600;
        border: none;
    }

    .btn-submit {
        background: var(--gradient-maroon);
        border: none;
        color: white;
        font-weight: 600;
        padding: 10px 24px;
        border-radius: 12px;
        transition: all 0.3s ease;
        box-shadow: 0 6px 18px rgba(128, 0, 0, 0.2);
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        opacity: 0.95;
    }

    .btn-back {
        background: #f2f2f2;
        border: 2px solid #ccc;
        padding: 10px 20px;
        border-radius: 12px;
        color: #555;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-back:hover {
        background: #eaeaea;
    }

    .badge-top {
        position: absolute;
        top: -14px;
        left: 30px;
        background: var(--maroon);
        color: white;
        padding: 6px 20px;
        border-radius: 0 0 16px 16px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        z-index: 10;
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<main id="mainContent" class="main-content">
    <div class="form-container">
        <div class="badge-top">
            <i class="bi bi-pencil-fill me-1"></i>Edit Armada
        </div>

        <div class="form-card">
            <div class="form-header">
                <i class="bi bi-pencil-square"></i>
                <h5>Edit Data Armada Pengiriman</h5>
            </div>

            <form action="{{ route('admin.armada-update', $armada->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Armada</label>
                    <input type="text" name="nama" id="nama" class="form-control" required value="{{ $armada->nama }}">
                </div>

                <div class="mb-3">
                    <label for="kapasitas_pack" class="form-label">Kapasitas Pack <small class="text-muted">(dalam bal)</small></label>
                    <input type="number" name="kapasitas_pack" id="kapasitas_pack" class="form-control" required min="1" value="{{ $armada->kapasitas_pack }}">
                </div>

                <div class="mb-4">
                    <label for="tarif_per_km" class="form-label">Tarif per KM</label>
                    <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" name="tarif_per_km" id="tarif_per_km" class="form-control" required min="0" value="{{ $armada->tarif_per_km }}">
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-4">
                    <a href="{{ route('admin.armada-pengiriman') }}" class="btn-back">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="bi bi-save-fill me-1"></i> Perbarui Armada
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
