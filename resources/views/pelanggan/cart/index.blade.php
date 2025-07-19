@extends('components.layout-bootstrap')

@section('title', 'Keranjang Produk Insulasi | Insulmart')

@section('content')
<style>
    :root {
        --maroon-dark: #8B0000;
        --maroon-hover: #a40000;
        --maroon-light: #fcf5f5;
        --border-radius: 12px;
    }
    .text-maroon { color: var(--maroon-dark) !important; }
    .btn-maroon {
        background: var(--maroon-dark);
        color: #fff; border: none; border-radius: var(--border-radius);
        font-weight: 600; transition: background 0.15s;
        padding: 8px 20px; font-size: 1rem; letter-spacing: .01em;
    }
    .btn-maroon:hover, .btn-maroon:focus {
        background: var(--maroon-hover); color: #fff;
    }
    .card-cart {
        background: #fff; border-radius: var(--border-radius);
        border: 1px solid #ececec; padding: 1.7rem 1.3rem;
        margin-bottom: 2rem; max-width: 850px;
        margin-left: auto; margin-right: auto;
    }
    .table { border-radius: var(--border-radius); overflow: hidden; margin-bottom: 0;
        background: #fff; border: 1px solid #ececec; font-size: 1rem; }
    .table thead th { background: var(--maroon-dark); color: #fff; border: none; font-weight: 700;}
    .table td, .table th { vertical-align: middle !important; border-top: 1px solid #ececec;}
    .quantity-input {
        border-radius: 7px; border: 1px solid #ddd; text-align: center; width: 70px;
        margin: 0 auto; font-weight: 500; font-size: 1rem; background: #fafafa;
    }
    .quantity-input:focus { border-color: var(--maroon-dark); outline: none; background: #fff; }
    .alert { border-radius: var(--border-radius); padding: 10px 14px; margin-bottom: 1.3rem; font-size: 1rem; }
    .btn-danger { border-radius: 7px !important; font-size: .98rem; padding: 4px 14px; }
    .subtotal-cell, .fw-semibold { font-weight: 600 !important; }
    h2, h4 { font-weight: 700 !important; letter-spacing: .01em; }
    @media (max-width: 576px) {
        .card-cart { padding: 1rem 0.4rem; }
        .table-responsive { font-size: 0.96rem; }
        .btn-maroon { font-size: .97rem; padding: 8px 12px; }
    }
    .navbar { padding: 0px 24px; }
</style>
<br><br>
<div class="container py-5">
    <div class="card-cart">
        <h2 class="mb-4 text-maroon d-flex align-items-center" style="font-size:1.3rem;">
            <i class="bi bi-cart4 me-2" style="font-size:1.6rem;"></i>Keranjang Saya
        </h2>

        {{-- Notifikasi Sukses --}}
        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                <div>{{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        {{-- Notifikasi Error --}}
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                    <strong>Terjadi kesalahan saat menginput data:</strong>
                </div>
                <ul class="mb-0 ps-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
            </div>
        @endif

        @if ($cart->items->isEmpty())
            <div class="alert alert-warning text-center py-3 mb-0">
                <i class="bi bi-emoji-frown fs-3 me-1"></i> Keranjang Anda kosong.
            </div>
        @else
            <div class="table-responsive mb-0">
                <table class="table table-bordered align-middle mb-0">
                    <thead>
                        <tr class="text-center">
                            <th>Gambar</th>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cart->items as $item)
                            <tr>
                                <td class="text-center" style="width:80px;">
                                    @php
                                        $gambar = $item->varianProduk->produk->gambars->first();
                                    @endphp
                                    @if($gambar)
                                        <img src="{{ asset('storage/' . $gambar->path) }}" alt="Gambar Produk" style="width:56px; height:56px; object-fit:cover; border-radius:9px; border:1px solid #eee;">
                                    @else
                                        <span style="font-size:1.5rem; color:#ccc;">—</span>
                                    @endif
                                </td>
                                <td class="fw-semibold text-maroon">{{ $item->varianProduk->tipe }}</td>
<td class="text-center">
    <div class="d-inline-flex align-items-center justify-content-center" style="gap:6px;">
        <button type="button"
            class="btn btn-light btn-sm btn-qty"
            data-action="decrease"
            data-item-id="{{ $item->id }}"
            style="min-width:28px;font-weight:700;color:#8B0000;border:1px solid #eee;"
            {{ $item->quantity <= 1 ? 'disabled' : '' }}>–</button>
        <input type="number"
            min="1"
            class="form-control quantity-input text-center"
            value="{{ $item->quantity }}"
            data-item-id="{{ $item->id }}"
            style="width:44px;padding:3px 0;border-radius:7px;border:1px solid #ddd;background:#fafafa;">
        <button type="button"
            class="btn btn-light btn-sm btn-qty"
            data-action="increase"
            data-item-id="{{ $item->id }}"
            style="min-width:28px;font-weight:700;color:#8B0000;border:1px solid #eee;">+</button>
    </div>
</td>

                                <td class="text-end fw-semibold">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                <td class="text-end subtotal-cell">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                <td class="text-center">
                                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Hapus item ini dari keranjang?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="text-end mt-4">
                <h4 class="fw-bold text-maroon mb-3" style="font-size:1.2rem;">
                    Total: <span id="cart-total">Rp{{ number_format($cart->items->sum('subtotal'), 0, ',', '.') }}</span>
                </h4>
                <a href="{{ route('keranjang.checkout') }}" class="btn btn-maroon btn-lg" id="checkout-btn">
                    <i class="bi bi-bag-check-fill me-2"></i> Checkout
                </a>
            </div>
        @endif
    </div>
</div>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    function setMinusState(itemId, qty) {
        const minusBtn = document.querySelector(".btn-qty[data-action='decrease'][data-item-id='" + itemId + "']");
        if (minusBtn) minusBtn.disabled = (qty <= 1);
    }

    function updateCart(itemId, qty, inputEl) {
        // Disable input sementara
        inputEl.disabled = true;
        axios.put('/cart/update/' + itemId, {quantity: qty})
            .then(function(resp) {
                if (resp.data.success) {
                    let subtotalCell = inputEl.closest('tr').querySelector('.subtotal-cell');
                    subtotalCell.textContent = 'Rp' + resp.data.newSubtotal;
                    document.getElementById('cart-total').textContent = 'Rp' + resp.data.total;
                } else {
                    inputEl.value = 1;
                    alert('Update gagal.');
                }
            })
            .catch(function() {
                inputEl.value = 1;
                alert('Gagal update quantity!');
            })
            .finally(function() {
                inputEl.disabled = false;
            });
    }

    document.querySelectorAll('.btn-qty').forEach(function(btn) {
        btn.addEventListener('click', function() {
            const itemId = this.dataset.itemId;
            const action = this.dataset.action;
            const input = document.querySelector(".quantity-input[data-item-id='" + itemId + "']");
            let qty = parseInt(input.value) || 1;

            if (action === 'increase') qty++;
            if (action === 'decrease') qty = Math.max(1, qty - 1);

            input.value = qty;
            setMinusState(itemId, qty);
            updateCart(itemId, qty, input);
        });
    });

    document.querySelectorAll('.quantity-input').forEach(function(input) {
        input.addEventListener('input', function() {
            let qty = parseInt(this.value);
            if (isNaN(qty) || qty < 1) qty = 1;
            this.value = qty;

            const itemId = this.dataset.itemId;
            setMinusState(itemId, qty);
            updateCart(itemId, qty, this);
        });
        setMinusState(input.dataset.itemId, parseInt(input.value));
    });
});
</script>
@endpush

@endsection
