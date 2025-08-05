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
                                            <img src="{{ asset($img->path) }}" alt="Produk" class="img-thumbnail" style="width:56px; height:56px; object-fit:cover;">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold text-maroon text-truncate">{{ $item->varianProduk->tipe }}</td>
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
                            <div class="alert alert-success p-2 mb-2 d-inline-block w-100" style="font-size:0.97em; border-radius: 6px;">
                                <i class="bi bi-truck"></i>
                                <b>Jarak kurang dari 25 km &mdash; Gratis Ongkir!</b>
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
                            <!-- ✅ Tambahkan hidden input di sini -->
                            <input type="hidden" name="total_harga_produk" id="total_harga_produk" value="0">
                            <input type="hidden" name="total_pack" id="total_pack" value="0">
                            <input type="hidden" name="biaya_ongkir" id="biaya_ongkir" value="0">
                            <input type="hidden" name="jarak_km" id="jarak_km" value="{{ $jarakKoreksi ?? 0 }}">

                            <!-- Ini akan di-inject lewat JS -->
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
        const armadas = @json($armadas);
        const jarakKoreksi = {{ $jarakKoreksi ?? 'null' }};

        // Format dan parsing Rupiah
        function parseRp(txt) {
            return parseInt((txt || '').replace(/[^0-9]/g, '')) || 0;
        }

        function updateGrandTotalFromDom() {
            const ongkir = parseRp(document.getElementById('ongkir-display').textContent);
            const totalProduk = parseRp(document.getElementById('cart-total').textContent);
            const grandTotal = ongkir + totalProduk;
            document.getElementById('grand-total').textContent = 'Rp' + grandTotal.toLocaleString('id-ID');
        }

        // Generate semua kombinasi yang mungkin untuk mencukupi total bal
        function generateAllValidCombos(armadas, totalBal, maxUnit = 6) {
            let results = [];

            function backtrack(index, currentCombo) {
                if (index === armadas.length) {
                    const totalMuatan = currentCombo.reduce((sum, a, i) => sum + (a * armadas[i].kapasitas_pack), 0);
                    if (totalMuatan >= totalBal) {
                        const combo = currentCombo.map((jumlah, i) => ({
                            ...armadas[i],
                            jumlah
                        })).filter(a => a.jumlah > 0);
                        results.push(combo);
                    }
                    return;
                }

                for (let j = 0; j <= maxUnit; j++) {
                    currentCombo.push(j);
                    backtrack(index + 1, currentCombo);
                    currentCombo.pop();
                }
            }

            backtrack(0, []);
            return results;
        }

        // Dapatkan kombinasi ongkir termurah
        function getTermurahCombo(totalBal) {
            const allCombos = generateAllValidCombos(armadas, totalBal, 5);
            let minHarga = Infinity;
            let bestCombo = null;

            for (const combo of allCombos) {
                const ongkir = combo.reduce((sum, a) =>
                    sum + (a.tarif_per_km * a.jumlah * jarakKoreksi), 0);

                if (ongkir < minHarga) {
                    minHarga = ongkir;
                    bestCombo = combo;
                }
            }

            return bestCombo;
        }

        // Hitung pengiriman
        function calculateShipping() {
            const checkboxes = document.querySelectorAll('.select-item:checked');
            let totalBal = 0;
            checkboxes.forEach(cb => {
                const row = cb.closest('tr');
                const qty = parseInt(row.querySelector('.quantity-input').value || 0);
                totalBal += qty;
            });

            const ongkirDisplay = document.getElementById('ongkir-display');
            const ongkirDetail = document.getElementById('ongkir-detail');
            const inputOngkir = document.getElementById('input-ongkir');
            const inputArmada = document.getElementById('input-armada');

            let armadaUsed = [];

            if (jarakKoreksi !== null && totalBal > 0) {
                armadaUsed = getTermurahCombo(totalBal) || [];
            }

            const tidakCukup = (armadaUsed.length === 0);

            if (tidakCukup || totalBal === 0) {
                ongkirDisplay.textContent = 'Rp0';
                ongkirDetail.innerHTML = totalBal === 0
                    ? ''
                    : `<span class="text-danger">Tidak ada armada yang mampu mengangkut <strong>${totalBal} bal</strong></span>`;
                if (inputOngkir && inputArmada) {
                    inputOngkir.value = 0;
                    inputArmada.value = '';
                }
            } else {
                if (jarakKoreksi <= 25) {
                    ongkirDisplay.textContent = 'Rp0';
                    ongkirDetail.innerHTML = `
                        <span class="text-success fw-semibold">Gratis Ongkir</span>
                        <div class="small text-muted mb-2">(Jarak ${jarakKoreksi.toFixed(2)} km ≤ 25 km)</div>
                        <div><strong>Armada:</strong></div>
                        <ul style="padding-left:18px; margin-bottom:4px">
                            ${armadaUsed.map(a => `<li>${a.jumlah} × ${a.nama} <span class="text-muted">(kapasitas ${a.kapasitas_pack} bal)</span></li>`).join('')}
                        </ul>
                        <div class="mt-1">Estimasi muatan: <strong>${totalBal} bal</strong></div>
                    `;
                    if (inputOngkir && inputArmada) {
                        inputOngkir.value = 0;
                        inputArmada.value = armadaUsed.map(a => `${a.jumlah}×${a.nama}`).join(', ');
                    }
                } else {
                    const ongkir = Math.ceil(armadaUsed.reduce((sum, a) =>
                        sum + (a.tarif_per_km * jarakKoreksi * a.jumlah), 0));

                    const armadaTableRows = armadaUsed.map(a =>
                        `<tr>
                            <td>${a.jumlah} × ${a.nama} <span class="text-muted">(kapasitas ${a.kapasitas_pack} bal)</span></td>
                            <td>Rp${a.tarif_per_km.toLocaleString('id-ID')}/km</td>
                            <td>Subtotal: <strong>Rp${Math.ceil(a.tarif_per_km * jarakKoreksi * a.jumlah).toLocaleString('id-ID')}</strong></td>
                        </tr>`
                    ).join('');

                    ongkirDisplay.textContent = 'Rp' + ongkir.toLocaleString('id-ID');
                    ongkirDetail.innerHTML = `
                        <div><strong>Armada:</strong></div>
                        <table style="width:100%; font-size:0.96em; margin-bottom:4px;">
                            <tbody>${armadaTableRows}</tbody>
                        </table>
                        <div class="mt-1">Total muatan: <strong>${totalBal} bal</strong></div>
                        <div class="mt-1">Total ongkir: <strong>Rp${ongkir.toLocaleString('id-ID')}</strong> <span class="text-muted">±(${jarakKoreksi.toFixed(2)} km)</span></div>
                    `;
                    if (inputOngkir && inputArmada) {
                        inputOngkir.value = ongkir;
                        inputArmada.value = armadaUsed.map(a => `${a.jumlah}×${a.nama}`).join(', ');
                    }
                }
            }

            const estMuatan = document.getElementById('est-muatan');
            if (estMuatan) {
                estMuatan.textContent = `${totalBal} bal`;
            }

            if (document.getElementById('armada_list')) {
                const arr = armadaUsed.map(a => ({
                    armada_id: a.id,
                    nama: a.nama,
                    kapasitas: a.kapasitas_pack,
                    jumlah: a.jumlah,
                    tarif: a.tarif_per_km,
                    subtotal: Math.ceil(a.tarif_per_km * jarakKoreksi * a.jumlah)
                }));
                document.getElementById('armada_list').value = JSON.stringify(arr);
            }

            updateGrandTotalFromDom();
        }

        // Event listeners
        document.getElementById('select-all')?.addEventListener('change', function () {
            document.querySelectorAll('.select-item').forEach(cb => {
                cb.checked = this.checked;
            });
            calculateShipping();
        });

        document.querySelectorAll('.select-item, .quantity-input').forEach(el => {
            el.addEventListener('change', calculateShipping);
        });

        window.addEventListener('DOMContentLoaded', () => {
            calculateShipping();
            updateGrandTotalFromDom();
        });
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
