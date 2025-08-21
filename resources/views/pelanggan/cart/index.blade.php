@extends('components.layout-bootstrap')

    <head>
        <title>@yield('title', 'Keranjang Produk Insulasi | Insulmart')</title>
        <!-- Tag lain seperti meta, link CSS, dll -->
    </head>

    @section('content')
        <style>
            :root {
                --maroon-dark: #800000;
                --maroon-hover: #660000;
                --maroon-light: #f8e5e5;
                --border-radius: 12px;
            }
            body {
                background: var(--maroon-light);
                padding-top: 5rem; /* <-- tambahkan ini sesuai tinggi navbar */
            }
            .text-maroon { color: var(--maroon-dark) !important; }
            .btn-maroon {
                background: var(--maroon-dark);
                color: #fff;
                border-radius: var(--border-radius);
                font-weight: 600;
                transition: background 0.15s;
                padding: 8px 20px;
                font-size: 1rem;
                letter-spacing: .01em;
            }
            .btn-maroon:hover { background: var(--maroon-hover); }
            .card-cart {
                background: #fff;
                border-radius: var(--border-radius);
                padding: 1.7rem 1.3rem;
                margin: 0 auto 2rem;
            }
            .table {
                border-radius: var(--border-radius);
                background: #fff;
                border: none;
                font-size: 1rem;
                margin-bottom: 0;
            }
            .table th,
            .table td {
                padding: .75rem 2.5rem;
                vertical-align: middle !important;
                border: none;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
            .table thead th {
                background: var(--maroon-dark);
                color: #fff;
                border: none;
                font-weight: 700;
            }
            .quantity-input {
                width: 50px;
                padding: 3px;
                border-radius: 7px;
                border: 1px solid #ddd;
                text-align: center;
                background: #fafafa;
                font-weight: 500;
            }
            .quantity-input:focus { border-color: var(--maroon-dark); background: #fff; }
            .subtotal-cell { font-weight: 600; }
            .form-check-input:checked {
                background-color: var(--maroon-dark);
                border-color: var(--maroon-dark);
            }
            .alert-success,
            .alert-danger,
            .alert-warning {
                background-color: var(--maroon-dark) !important;
                color: #fff !important;
                border-color: var(--maroon-dark) !important;
            }
            .alert .bi { color: #fff !important; }
            .btn-remove-icon {
                background: none;
                border: none;
                color: var(--maroon-dark);
                font-size: 1.2rem;
                padding: 0;
                transition: color 0.15s;
            }
            .btn-remove-icon:hover { color: var(--maroon-hover); }
            @media (max-width: 576px) {
                .card-cart { padding: 1rem; }
                .btn-maroon { padding: 8px 12px; font-size: .95rem; }
                .table th,
                .table td { padding: .5rem 1rem; }
            }
            .navbar {
                padding: 0px 24px;
            }

            .btn-outline-maroon {
                border: 1px solid #800000;
                color: #800000;
                background-color: transparent;
                transition: background-color 0.2s ease, color 0.2s ease;
                }

                .btn-outline-maroon:hover {
                    background-color: #800000;
                    color: white;
                }

                /* Optional padding tuning if terlalu tinggi */
                .btn-outline-maroon.btn-sm {
                    padding: 3px 16px;
                    font-size: 0.85rem;
                    line-height: 1.2;
                    border-radius: 999px;
                    display: inline-flex;
                    align-items: center;
                    gap: 4px;
                }

            @media (max-width: 991px) {
                .cart-summary-responsive {
                    flex-direction: column !important;
                    align-items: stretch !important;
                    gap: 1.5rem !important;
                }
                .cart-summary-block {
                    width: 100% !important;
                    min-width: unset !important;
                    margin-bottom: 0.5rem;
                    text-align: left;
                }
                .cart-summary-block .alert {
                    width: 100%;
                    min-width: 0;
                    text-align: left;
                }
            }
            @media (max-width: 576px) {
                .cart-summary-block {
                    padding-left: 0 !important;
                    padding-right: 0 !important;
                    font-size: 1em;
                }
                .cart-summary-responsive {
                    gap: 1rem !important;
                }
            }
        </style>
        <div class="container-fluid px-3 px-md-5 py-5 fade-up">
            <div class="address-section mb-4 fade-up">
                <h5 class="text-maroon fw-bold mb-3">Alamat Pengiriman</h5>

                <div class="row gx-3 mb-4">
                    {{-- KIRI: Alamat --}}
                    <div class="col-md-6">
                        @if($defaultAddress)
                            <div class="card address-card h-100 shadow-sm">
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-geo-alt-fill fs-2 text-maroon me-3"></i>
                                        <div>
                                            <h6 class="mb-1">{{ $defaultAddress->label ?? 'Default' }}</h6>
                                            <p class="small text-muted mb-0">
                                                {{ $defaultAddress->alamat_lengkap }}, {{ $defaultAddress->district }},<br>
                                                {{ $defaultAddress->regency }}, {{ $defaultAddress->province }}<br>
                                                {{ $defaultAddress->kode_pos }}, <br> {{ $defaultAddress->koordinat }}
                                            </p>
                                            @php
                                                $jarakLurus = $defaultAddress->jarakDariGudang();

                                                if ($jarakLurus) {
                                                    if ($jarakLurus < 25) {
                                                        $koreksi = 1.405;
                                                    } elseif ($jarakLurus <= 65) {
                                                        $koreksi = 1.7;
                                                    } else {
                                                        $koreksi = 1.25; // Atur nilai koreksi untuk >65 km
                                                    }

                                                    $jarakKoreksi = $jarakLurus * $koreksi;
                                                } else {
                                                    $jarakKoreksi = null;
                                                }
                                            @endphp
                                            @if($jarakKoreksi)
                                                <p class="small text-muted mt-1">
                                                    Perkiraan jarak ke gudang: <strong>± {{ number_format($jarakKoreksi, 2) }} km</strong>
                                                </p>
                                            @endif

                                        </div>
                                    </div>
                                    <div class="mt-3 text-end">
                                        <a href="{{ route('alamat.index') }}" class="btn btn-outline-maroon btn-sm me-2">
                                            <i class="bi bi-pencil-fill me-1"></i>Ubah Default
                                        </a>
                                        <a href="{{ route('alamat.create') }}" class="btn btn-maroon btn-sm">
                                            <i class="bi bi-plus-lg me-1"></i>Tambah Baru
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-info d-flex align-items-center justify-content-between">
                                <i class="bi bi-info-circle-fill me-2"></i>
                                <span>Anda belum mengatur alamat default.</span>
                                <a href="{{ route('alamat.create') }}" class="btn btn-maroon btn-sm">
                                    <i class="bi bi-plus-lg me-1"></i>Tambah Alamat
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- KANAN: Form metode pembayaran dan catatan --}}
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h6 class="text-maroon fw-bold mb-3">
                                    <i class="bi bi-credit-card-2-back me-1"></i>Metode Pembayaran
                                </h6>

                                <div class="mb-3">
                                    <label for="metode_pembayaran" class="form-label">Pilih Metode Pembayaran</label>
                                    <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" form="checkout-form" required>
                                        <option value="">-- Pilih --</option>
                                        <option value="termin_1x_lunas">Lunas Sekali Bayar</option>
                                        <option value="termin_2x">Termin 2x</option>
                                        <option value="termin_3x">Termin 3x</option>
                                    </select>
                                </div>

                                <div class="mb-0">
                                    <label for="catatan" class="form-label">Catatan untuk Admin</label>
                                    <textarea name="catatan" id="catatan" class="form-control" rows="3" placeholder="Contoh: Kirim cepat, tanpa palet, dsb." form="checkout-form"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-cart">
                <h2 class="mb-4 text-maroon d-flex align-items-center justify-content-center fade-up">
                    <i class="bi bi-cart4 me-2"></i>Keranjang Saya
                </h2>

                {{-- Notifications --}}
                @if(session('success'))
                    <div class="alert alert-success d-flex align-items-center alert-dismissible fade show shadow-sm">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div>{{ session('success') }}</div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
                    </div>
                @endif

                @if($cart->items->isEmpty())
                    <div class="alert alert-warning text-center fade-up">
                        <i class="bi bi-emoji-frown fs-3"></i> Keranjang Anda kosong.
                    </div>
                @else
                    <div class="table-responsive fade-up">
                        <table class="table align-middle mb-0">
                            <thead>
                                <tr class="text-center">
                                    <th style="width:36px;"><input type="checkbox" id="select-all" class="form-check-input" /></th>
                                    <th>Gambar</th>
                                    <th>Produk</th>
                                    <th>Jumlah</th>
                                    <th>Harga</th>
                                    <th>Subtotal</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart->items as $item)
                                <tr data-item-id="{{ $item->id }}">
                                    <td class="text-center">
                                        <input type="checkbox" class="form-check-input select-item" data-item-id="{{ $item->id }}" />
                                    </td>
                                    <td class="text-center" style="width:80px;">
                                        @php $img = $item->varianProduk->produk->gambars->first(); @endphp
                                        @if($img)
                                            <img src="{{ asset('storage/' . $img->path) }}" alt="Produk" class="img-thumbnail" style="width:56px; height:56px; object-fit:cover;">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold text-maroon text-truncate">
                                        {{ $item->varianProduk->tipe }}
                                        <span class="text-secondary text-lowercase small ms-1">
                                            {{ strtolower($item->varianProduk->status_ketersediaan) }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <button type="button" class="btn btn-light btn-sm btn-qty"
                                                data-item-id="{{ $item->id }}" data-action="decrease"
                                                data-stok="{{ $item->varianProduk->stok }}">–</button>
                                            <input type="number" min="1" max="{{ $item->varianProduk->stok }}"
                                                value="{{ $item->quantity }}" class="quantity-input"
                                                data-item-id="{{ $item->id }}" data-stok="{{ $item->varianProduk->stok }}">
                                            <button type="button" class="btn btn-light btn-sm btn-qty"
                                                data-item-id="{{ $item->id }}" data-action="increase"
                                                data-stok="{{ $item->varianProduk->stok }}">+</button>
                                        </div>
                                    </td>
                                    <td class="text-end">Rp{{ number_format($item->price, 0, ',', '.') }}</td>
                                    <td class="text-end subtotal-cell">Rp{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="form-remove-item">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn-remove-icon" title="Hapus">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap flex-md-nowrap cart-summary-responsive">
                    <div class="mt-4 cart-summary-block">
                        <div id="free-ship-banner" class="alert p-2 mb-2 d-inline-block w-100" style="font-size:0.97em; border-radius: 6px;">
                        <!-- akan diisi JS sesuai kondisi -->
                        </div>

                        <span class="fw-semibold text-maroon">Ongkos Kirim:</span>
                        <span id="ongkir-display" class="fw-bold">Rp0</span>
                        <div class="text-muted small" id="ongkir-detail" style="margin-top: 2px;"></div>
                        <br>
                        <small class="text-muted" id="armada-nama"></small>
                    </div>

                    <div class="cart-summary-block">
                        <span class="fw-semibold text-maroon">Total Harga Produk Dipilih:</span>
                        <span id="cart-total" class="fw-bold">Rp0</span>
                        <small class="text-success d-block">*Harga sudah termasuk PPN 11%</small>
                    </div>

                    <div class="mt-2 cart-summary-block">
                        <span class="fw-semibold text-maroon">Total Keseluruhan:</span>
                        <span id="grand-total" class="fw-bold text-dark">Rp0</span>
                    </div>

                    <form id="checkout-form" action="{{ route('keranjang.checkout') }}" method="POST" class="cart-summary-block" style="min-width:140px;">
                        @csrf
                        <div id="selected-inputs"></div>

                        <!-- Hidden inputs yang dipakai saat submit -->
                        <input type="hidden" name="total_harga_produk" id="total_harga_produk" value="0">
                        <input type="hidden" name="total_pack" id="total_pack" value="0">
                        <input type="hidden" name="biaya_ongkir" id="biaya_ongkir" value="0">
                        <input type="hidden" name="jarak_km" id="jarak_km" value="{{ $jarakKoreksi ?? 0 }}">
                        <input type="hidden" name="armada_list" id="armada_list" value="[]">

                        <button type="submit" class="btn btn-maroon btn-lg w-100" id="btn-checkout" disabled>
                        <i class="bi bi-bag-check-fill me-2"></i> Checkout
                        </button>
                    </form>
                    </div>

                @endif
            </div>
        </div>
        @include('components.back-to-top')
    @endsection

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Util Rupiah
            const parseRp = text => parseInt(text.replace(/[Rp\.]/g, '')) || 0;
            const formatRp = num => num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Helper ambil semua checkbox .select-item
            const getItemCheckboxes = () => document.querySelectorAll('.select-item');
            const selectAllBox = document.getElementById('select-all');

            // Load/save checkbox state ke localStorage
            const loadSelections = () => {
                const stored = JSON.parse(localStorage.getItem('cart_selected'));
                const checks = Array.from(getItemCheckboxes());
                if (!stored || stored.length === 0) {
                    checks.forEach(c => c.checked = true);
                } else {
                    checks.forEach(c => c.checked = stored.includes(c.dataset.itemId));
                }
                // select-all juga ikut
                selectAllBox.checked = checks.length && checks.every(c => c.checked);
            };
            const saveSelections = () => {
                const sel = Array.from(getItemCheckboxes())
                    .filter(c => c.checked)
                    .map(c => c.dataset.itemId);
                localStorage.setItem('cart_selected', JSON.stringify(sel));
            };

            // Update total dan hidden input
            const recalcTotal = () => {
                let total = 0;
                const selected = [];
                getItemCheckboxes().forEach(chk => {
                    if (chk.checked) {
                        const row = document.querySelector(`tr[data-item-id="${chk.dataset.itemId}"]`);
                        total += parseRp(row.querySelector('.subtotal-cell').textContent);
                        selected.push(chk.dataset.itemId);
                    }
                });
                document.getElementById('cart-total').textContent = `Rp${formatRp(total)}`;
                const container = document.getElementById('selected-inputs');
                container.innerHTML = '';
                selected.forEach(id => {
                    const inp = document.createElement('input');
                    inp.type = 'hidden'; inp.name = 'selected_items[]'; inp.value = id;
                    container.appendChild(inp);
                });
                document.getElementById('btn-checkout').disabled = selected.length === 0;
                saveSelections();
                // update select-all state juga!
                const all = getItemCheckboxes();
                selectAllBox.checked = all.length && Array.from(all).every(cb => cb.checked);
            };

            // Update cart via AJAX + update subtotal/total
            const updateCart = async (id, qty, input) => {
                try {
                    input.disabled = true;
                    const { data } = await axios.put(`/cart/update/${id}`, { quantity: qty });
                    if (data.success) {
                        const row = document.querySelector(`tr[data-item-id="${id}"]`);
                        row.querySelector('.subtotal-cell').textContent = `Rp${data.newSubtotal}`;
                        recalcTotal();
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: data.message || 'Gagal update quantity',
                            icon: 'error',
                            confirmButtonColor: '#800000'
                        });
                    }
                } catch (err) {
                    Swal.fire({
                        title: 'Error',
                        text: err.message || 'Gagal update quantity',
                        icon: 'error',
                        confirmButtonColor: '#800000'
                    });
                } finally {
                    input.disabled = false;
                }
            };

            // Disable tombol minus jika qty <= 1, plus jika qty >= stok
            const setMinusState = (id, qty, stok) => {
                const btnMin = document.querySelector(`.btn-qty[data-item-id="${id}"][data-action="decrease"]`);
                const btnPlus = document.querySelector(`.btn-qty[data-item-id="${id}"][data-action="increase"]`);
                if (btnMin) btnMin.disabled = qty <= 1;
                if (btnPlus) btnPlus.disabled = qty >= stok;
            };

            // BTN QTY click (plus/minus)
            document.querySelectorAll('.btn-qty').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.itemId;
                    const action = btn.dataset.action;
                    const input = document.querySelector(`.quantity-input[data-item-id="${id}"]`);
                    const stok = parseInt(input.dataset.stok);
                    let qty = parseInt(input.value) || 1;

                    if (action === 'increase') {
                        if (qty < stok) {
                            qty += 1;
                        } else {
                            qty = stok;
                            Swal.fire({
                                title: 'Maksimum Stok!',
                                text: 'Jumlah tidak boleh melebihi stok tersedia (' + stok + ' pcs).',
                                icon: 'warning',
                                confirmButtonColor: '#800000'
                            });
                        }
                    } else {
                        qty = Math.max(1, qty - 1);
                    }

                    input.value = qty;
                    input.dispatchEvent(new Event('change', { bubbles: true }));
                    setMinusState(id, qty, stok);
                    updateCart(id, qty, input);
                });
            });

            // INPUT QTY manual
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', () => {
                    const id = input.dataset.itemId;
                    const stok = parseInt(input.dataset.stok);
                    let qty = parseInt(input.value) || 1;

                    if (qty > stok) {
                        qty = stok;
                        input.value = qty;
                        Swal.fire({
                            title: 'Maksimum Stok!',
                            text: 'Jumlah tidak boleh melebihi stok tersedia (' + stok + ' pcs).',
                            icon: 'warning',
                            confirmButtonColor: '#800000'
                        });
                    } else if (qty < 1) {
                        qty = 1;
                        input.value = qty;
                    }

                    setMinusState(id, qty, stok);
                    updateCart(id, qty, input);
                });
                setMinusState(input.dataset.itemId, parseInt(input.value), parseInt(input.dataset.stok));
            });

            // SELECT ALL
            selectAllBox.addEventListener('change', function() {
                getItemCheckboxes().forEach(cb => cb.checked = this.checked);
                recalcTotal();
            });

            // Per item select/unselect
            getItemCheckboxes().forEach(cb => cb.addEventListener('change', function() {
                recalcTotal();
            }));

            // Konfirmasi hapus item
            document.querySelectorAll('.form-remove-item').forEach(form => {
                form.addEventListener('submit', e => {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Konfirmasi Hapus',
                        text: 'Apakah Anda yakin ingin menghapus item ini?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#800000',
                        cancelButtonColor: '#6c757d'
                    }).then(res => res.isConfirmed && form.submit());
                });
            });

            // INIT on page load
            loadSelections();
            recalcTotal();
        });
    </script>

    <script>
        (() => {
        // ====== STATE & KONFIG ======
        const armadas = Array.isArray(@json($armadas)) ? @json($armadas) : [];
        const jarakKoreksiRaw = {{ $jarakKoreksi ?? 'null' }};
        const jarakKoreksi = (jarakKoreksiRaw === null ? null : Number(jarakKoreksiRaw));

        const FREE_MIN_SUBTOTAL = 5_000_000; // Rp5jt
        const FREE_MAX_KM = 25;

        // ====== UTIL ======
        const $ = (sel, ctx = document) => ctx.querySelector(sel);
        const $$ = (sel, ctx = document) => Array.from(ctx.querySelectorAll(sel));
        const toNum = (v) => {
            if (v == null) return 0;
            if (typeof v === 'number') return isFinite(v) ? v : 0;
            const s = String(v).replace(/[^0-9\-.,]/g, '').replace(/\./g, '').replace(',', '.');
            const n = parseFloat(s);
            return isFinite(n) ? n : 0;
        };
        const parseRp = (txt) => {
            if (!txt) return 0;
            return parseInt(String(txt).replace(/[^0-9]/g, ''), 10) || 0;
        };
        const fmtRp = (n) => 'Rp' + (toNum(n) || 0).toLocaleString('id-ID');

        // Debounce + raf
        const rafDebounce = (fn, delay = 60) => {
            let t = 0, raf = 0;
            return (...args) => {
            if (t) clearTimeout(t);
            t = setTimeout(() => {
                if (raf) cancelAnimationFrame(raf);
                raf = requestAnimationFrame(() => fn(...args));
            }, delay);
            };
        };

        // ====== DOM TARGETS (safe) ======
        const elOngkirDisplay = $('#ongkir-display');
        const elOngkirDetail  = $('#ongkir-detail');
        const elArmadaNama    = $('#armada-nama');
        const elCartTotal     = $('#cart-total');
        const elGrandTotal    = $('#grand-total');
        const elBtnCheckout   = $('#btn-checkout');
        const elBanner        = $('#free-ship-banner');

        const setHidden = (id, val) => { const el = $('#'+id); if (el) el.value = val; };

        const setBanner = (status, html) => {
            if (!elBanner) return;
            elBanner.className = 'alert p-2 mb-2 d-inline-block w-100 alert-' + status;
            elBanner.innerHTML = html;
        };

        const updateGrandTotalFromDom = () => {
            const ongkir = parseRp(elOngkirDisplay?.textContent || '0');
            const totalProduk = parseRp(elCartTotal?.textContent || '0');
            if (elGrandTotal) elGrandTotal.textContent = fmtRp(ongkir + totalProduk);
        };

        const toggleCheckoutButton = () => {
            if (!elBtnCheckout) return;
            const totalProduk = parseRp(elCartTotal?.textContent || '0');
            const anySelected = $$('.select-item:checked').length > 0;
            elBtnCheckout.disabled = !(anySelected && totalProduk > 0);
        };

        // ====== ARMADA KOMBINASI ======
        function generateAllValidCombos(armadas, totalBal, maxUnit = 6) {
            const results = [];
            const n = armadas.length;
            const backtrack = (i, cur) => {
            if (i === n) {
                const muatan = cur.reduce((sum, j, idx) => sum + j * (armadas[idx].kapasitas_pack || 0), 0);
                if (muatan >= totalBal) {
                const combo = cur.map((j, idx) => ({...armadas[idx], jumlah: j})).filter(a => a.jumlah > 0);
                results.push(combo);
                }
                return;
            }
            for (let j = 0; j <= maxUnit; j++) {
                cur.push(j);
                backtrack(i+1, cur);
                cur.pop();
            }
            };
            backtrack(0, []);
            return results;
        }

        function getTermurahCombo(totalBal) {
            if (!Array.isArray(armadas) || armadas.length === 0) return null;
            const combos = generateAllValidCombos(armadas, totalBal, 5);
            let best = null, minHarga = Infinity;
            const km = (jarakKoreksi || 0);
            for (const combo of combos) {
            const ongkir = combo.reduce((s, a) => s + (toNum(a.tarif_per_km) * km * toNum(a.jumlah)), 0);
            if (ongkir < minHarga) {
                minHarga = ongkir; best = combo;
            }
            }
            return best;
        }

        // ====== HITUNG TOTAL BAL DARI BARIS TERPILIH (REAL-TIME) ======
        const getSelectedTotalBal = () => {
            let totalBal = 0;
            $$('.select-item:checked').forEach(cb => {
            const row = cb.closest('tr');
            if (!row) return;
            const qtyInput = row.querySelector('.quantity-input');
            const qty = toNum(qtyInput?.value || qtyInput?.dataset?.value || 0);
            totalBal += qty;
            });
            return Math.max(0, Math.floor(totalBal));
        };

        // (opsional) kalau mau total harga produk dihitung ulang langsung dari baris:
        // const getSelectedSubtotal = () => {
        //   let subtotal = 0;
        //   $$('.select-item:checked').forEach(cb => {
        //     const row = cb.closest('tr');
        //     const qty = toNum(row?.querySelector('.quantity-input')?.value);
        //     const harga = parseRp(row?.querySelector('.harga-satuan')?.textContent || '0');
        //     subtotal += qty * harga;
        //   });
        //   return subtotal;
        // };

        // ====== INTI PERHITUNGAN ======
        const recalc = () => {
            try {
            const totalBal = getSelectedTotalBal();
            const totalProduk = parseRp(elCartTotal?.textContent || '0'); // pakai DOM existing

            // Update hidden dasar
            setHidden('total_pack', totalBal);
            setHidden('total_harga_produk', totalProduk);

            // Guard awal
            if (!elOngkirDisplay || !elOngkirDetail) return;

            // Kondisi awal / tidak cukup data
            if (jarakKoreksi === null || isNaN(jarakKoreksi)) {
                elOngkirDisplay.textContent = fmtRp(0);
                elOngkirDetail.innerHTML = totalBal === 0 ? '' : '<span class="text-danger">Jarak belum tersedia.</span>';
                if (elArmadaNama) elArmadaNama.textContent = '';
                setHidden('biaya_ongkir', 0);
                setHidden('armada_list', '[]');
                setBanner('info', '<i class="bi bi-info-circle"></i> Masukkan item & pastikan lokasi agar ongkir bisa dihitung.');
                updateGrandTotalFromDom(); toggleCheckoutButton(); return;
            }

            if (totalBal === 0) {
                elOngkirDisplay.textContent = fmtRp(0);
                elOngkirDetail.innerHTML = '';
                if (elArmadaNama) elArmadaNama.textContent = '';
                setHidden('biaya_ongkir', 0);
                setHidden('armada_list', '[]');
                setBanner('info', '<i class="bi bi-info-circle"></i> Pilih produk untuk menghitung ongkir.');
                updateGrandTotalFromDom(); toggleCheckoutButton(); return;
            }

            // Cari combo termurah
            const combo = getTermurahCombo(totalBal);
            if (!combo || combo.length === 0) {
                elOngkirDisplay.textContent = fmtRp(0);
                elOngkirDetail.innerHTML = `<span class="text-danger">Tidak ada armada yang mampu mengangkut <strong>${totalBal} ball/pack</strong>.</span>`;
                if (elArmadaNama) elArmadaNama.textContent = '';
                setHidden('biaya_ongkir', 0);
                setHidden('armada_list', '[]');
                setBanner('danger', '<i class="bi bi-exclamation-triangle"></i> Armada tidak mencukupi. Kurangi jumlah atau hubungi admin.');
                updateGrandTotalFromDom(); toggleCheckoutButton(); return;
            }

            // Hitung ongkir full (tanpa free km)
            const km = Number(jarakKoreksi) || 0;
            let ongkir = Math.ceil(combo.reduce((sum, a) => sum + (toNum(a.tarif_per_km) * km * toNum(a.jumlah)), 0));

            // Syarat free ongkir (DUA syarat)
            const eligibleDistance = km <= FREE_MAX_KM;
            const eligibleSubtotal = totalProduk >= FREE_MIN_SUBTOTAL;
            const eligibleFree    = eligibleDistance && eligibleSubtotal;

            if (eligibleFree) {
                // Gratis ongkir
                ongkir = 0;
                elOngkirDisplay.textContent = fmtRp(0);
                elOngkirDetail.innerHTML = `
                <span class="text-success fw-semibold">Gratis Ongkir</span>
                <div class="small text-muted mb-2">(Jarak ${km.toFixed(2)} km ≤ ${FREE_MAX_KM} km &amp; Subtotal ≥ ${fmtRp(FREE_MIN_SUBTOTAL)})</div>
                <div><strong>Armada:</strong></div>
                <ul style="padding-left:18px; margin-bottom:4px">
                    ${combo.map(a => `<li>${a.jumlah} × ${a.nama} <span class="text-muted">(kapasitas ${a.kapasitas_pack} ball/pack)</span></li>`).join('')}
                </ul>
                <div class="mt-1">Estimasi muatan: <strong>${totalBal} ball/pack</strong></div>
                `;
                if (elArmadaNama) elArmadaNama.textContent = combo.map(a => `${a.jumlah}×${a.nama}`).join(', ');
                setHidden('biaya_ongkir', 0);
                setHidden('armada_list', JSON.stringify(combo.map(a => ({
                armada_id: a.id, nama: a.nama, kapasitas: a.kapasitas_pack, jumlah: a.jumlah,
                tarif: a.tarif_per_km, subtotal: 0
                }))));
                setBanner('success', `<i class="bi bi-truck"></i> <b>Gratis Ongkir!</b> (Jarak ≤ ${FREE_MAX_KM} km &amp; Subtotal ≥ ${fmtRp(FREE_MIN_SUBTOTAL)})`);
            } else {
                // Bayar penuh
                const rows = combo.map(a => `
                <tr>
                    <td>${a.jumlah} × ${a.nama} <span class="text-muted">(kapasitas ${a.kapasitas_pack} ball/pack)</span></td>
                    <td>Rp${toNum(a.tarif_per_km).toLocaleString('id-ID')}/km</td>
                    <td>Subtotal: <strong>${fmtRp(Math.ceil(toNum(a.tarif_per_km) * km * toNum(a.jumlah)))}</strong></td>
                </tr>
                `).join('');

                elOngkirDisplay.textContent = fmtRp(ongkir);
                elOngkirDetail.innerHTML = `
                <div><strong>Armada:</strong></div>
                <table style="width:100%; font-size:0.96em; margin-bottom:4px;"><tbody>${rows}</tbody></table>
                <div class="mt-1">Total muatan: <strong>${totalBal} ball/pack</strong></div>
                <div class="mt-1">Total ongkir: <strong>${fmtRp(ongkir)}</strong> <span class="text-muted">±(${km.toFixed(2)} km)</span></div>
                `;
                if (elArmadaNama) elArmadaNama.textContent = combo.map(a => `${a.jumlah}×${a.nama}`).join(', ');
                setHidden('biaya_ongkir', ongkir);
                setHidden('armada_list', JSON.stringify(combo.map(a => ({
                armada_id: a.id, nama: a.nama, kapasitas: a.kapasitas_pack, jumlah: a.jumlah,
                tarif: a.tarif_per_km, subtotal: Math.ceil(toNum(a.tarif_per_km) * km * toNum(a.jumlah))
                }))));

                const reason = [];
                if (!eligibleDistance) reason.push(`Jarak &gt; ${FREE_MAX_KM} km`);
                if (!eligibleSubtotal) reason.push(`Subtotal &lt; ${fmtRp(FREE_MIN_SUBTOTAL)}`);
                setBanner('warning', `<i class="bi bi-info-circle"></i> Tidak memenuhi gratis ongkir: ${reason.join(' &nbsp;•&nbsp; ')}`);
            }

            updateGrandTotalFromDom();
            toggleCheckoutButton();
            } catch (err) {
            // jangan bikin UX mati kalau ada error kecil
            console.error('calculateShipping error:', err);
            setBanner('danger', '<i class="bi bi-exclamation-triangle"></i> Gagal menghitung ongkir. Coba periksa kembali item yang dipilih.');
            }
        };

        const scheduleRecalc = rafDebounce(recalc, 40);

        // ====== EVENTS REAL-TIME ======
        // 1) Perubahan checkbox & qty (delegated)
        const cartContainer = document; // ganti ke wrapper tabel kalau mau lebih spesifik
        cartContainer.addEventListener('input', (e) => {
            if (e.target.matches('.quantity-input')) scheduleRecalc();
        });
        cartContainer.addEventListener('change', (e) => {
            if (e.target.matches('.quantity-input, .select-item, #select-all')) scheduleRecalc();
        });
        cartContainer.addEventListener('click', (e) => {
            if (e.target.matches('.select-item, #select-all')) scheduleRecalc();
        });
        cartContainer.addEventListener('keyup', (e) => {
            if (e.target.matches('.quantity-input')) scheduleRecalc();
        });

        // 2) Jika script lain mengubah #cart-total (live), pantau via MutationObserver
        if (elCartTotal) {
            const mo = new MutationObserver(scheduleRecalc);
            mo.observe(elCartTotal, { childList: true, characterData: true, subtree: true });
        }

        // 3) Jika baris tabel diganti/dimuat ulang dinamis, pantau kontainer tabel
        const tableWrapper = document.querySelector('.cart-table, table') || document.body;
        const moTable = new MutationObserver(rafDebounce(() => {
            // re-attach tidak perlu karena kita pakai event delegation, cukup hitung ulang
            scheduleRecalc();
        }, 80));
        moTable.observe(tableWrapper, { childList: true, subtree: true });

        // 4) Init pertama
        window.addEventListener('DOMContentLoaded', () => {
            scheduleRecalc();
            // sinkronkan grand total jika ada sisa latency update cart-total
            setTimeout(scheduleRecalc, 150);
            setTimeout(scheduleRecalc, 400);
        });
        })();
    </script>

    <script>
        function parseRp(txt) {
            return parseInt((txt || '').replace(/[^0-9]/g, '')) || 0;
        }
        function updateGrandTotalFromDom() {
            // Pastikan elemen ada (biar nggak error)
            var ongkirEl = document.getElementById('ongkir-display');
            var produkEl = document.getElementById('cart-total');
            var grandEl  = document.getElementById('grand-total');
            if (!ongkirEl || !produkEl || !grandEl) return;

            var ongkir = parseRp(ongkirEl.textContent);
            var totalProduk = parseRp(produkEl.textContent);
            var grandTotal = ongkir + totalProduk;
            grandEl.textContent = 'Rp' + grandTotal.toLocaleString('id-ID');
        }

        // --- AUTO JALAN SETIAP BERUBAH --- 
        window.addEventListener('DOMContentLoaded', function() {
            // Observe perubahan di ongkir dan cart-total
            ['ongkir-display', 'cart-total'].forEach(function(id) {
                var target = document.getElementById(id);
                if (!target) return;
                new MutationObserver(updateGrandTotalFromDom)
                    .observe(target, { childList: true, characterData: true, subtree: true });
            });
            // Jalankan sekali di awal
            updateGrandTotalFromDom();
        });
    </script>
@endpush
