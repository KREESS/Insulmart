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
                                                {{ $defaultAddress->kode_pos }}
                                            </p>
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
                                            <img src="{{ asset('storage/'.$img->path) }}" alt="Produk" class="img-thumbnail" style="width:56px; height:56px; object-fit:cover;">
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="fw-semibold text-maroon text-truncate">{{ $item->varianProduk->tipe }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center align-items-center gap-1">
                                            <button type="button" class="btn btn-light btn-sm btn-qty" data-item-id="{{ $item->id }}" data-action="decrease">–</button>
                                            <input type="number" min="1" value="{{ $item->quantity }}" class="quantity-input" data-item-id="{{ $item->id }}">
                                            <button type="button" class="btn btn-light btn-sm btn-qty" data-item-id="{{ $item->id }}" data-action="increase">+</button>
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

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <span class="fw-semibold text-maroon">Total Harga Terpilih:</span>
                            <span id="cart-total" class="fw-bold">Rp0</span>
                            <small class="text-muted d-block mt-1">*Belum termasuk ongkos kirim</small>
                        </div>
                        <form id="checkout-form" action="{{ route('keranjang.checkout') }}" method="POST">
                            @csrf
                            <div id="selected-inputs"></div>
                            <button type="submit" class="btn btn-maroon btn-lg" id="btn-checkout" disabled>
                                <i class="bi bi-bag-check-fill me-2"></i> Checkout
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    @endsection

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Semua script di-wrap ke DOMContentLoaded
        document.addEventListener('DOMContentLoaded', () => {
            axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Utility untuk parse dan format Rupiah
            const parseRp = text => parseInt(text.replace(/[Rp\.]/g, '')) || 0;
            const formatRp = num => num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            // Load/save checkbox state ke localStorage
            const loadSelections = () => {
                const stored = JSON.parse(localStorage.getItem('cart_selected'));
                const checks = Array.from(document.querySelectorAll('.select-item'));
                if (!stored || stored.length === 0) {
                    checks.forEach(c => c.checked = true);
                } else {
                    checks.forEach(c => c.checked = stored.includes(c.dataset.itemId));
                }
                document.getElementById('select-all').checked = checks.every(c => c.checked);
            };
            const saveSelections = () => {
                const sel = Array.from(document.querySelectorAll('.select-item'))
                    .filter(c => c.checked)
                    .map(c => c.dataset.itemId);
                localStorage.setItem('cart_selected', JSON.stringify(sel));
            };

            // Update total dan input tersembunyi
            const recalcTotal = () => {
                let total = 0;
                const selected = [];
                document.querySelectorAll('.select-item').forEach(chk => {
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
            };

            // Update cart via AJAX
            const updateCart = async (id, qty, input) => {
                try {
                    input.disabled = true;
                    const { data } = await axios.put(`/cart/update/${id}`, { quantity: qty });
                    if (data.success) {
                        const row = document.querySelector(`tr[data-item-id="${id}"]`);
                        row.querySelector('.subtotal-cell').textContent = `Rp${data.newSubtotal}`;
                        recalcTotal();
                    } else throw new Error('Update gagal');
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

            // Disable tombol minus jika qty <= 1
            const setMinusState = (id, qty) => {
                const btn = document.querySelector(`.btn-qty[data-item-id="${id}"][data-action="decrease"]`);
                if (btn) btn.disabled = qty <= 1;
            };

            // Event quantity
            document.querySelectorAll('.btn-qty').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.itemId;
                    const action = btn.dataset.action;
                    const input = document.querySelector(`.quantity-input[data-item-id="${id}"]`);
                    let qty = parseInt(input.value) || 1;
                    qty = action === 'increase' ? qty + 1 : Math.max(1, qty - 1);
                    input.value = qty;
                    setMinusState(id, qty);
                    updateCart(id, qty, input);
                });
            });
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', () => {
                    const id = input.dataset.itemId;
                    let qty = parseInt(input.value) || 1;
                    input.value = qty;
                    setMinusState(id, qty);
                    updateCart(id, qty, input);
                });
                setMinusState(input.dataset.itemId, parseInt(input.value));
            });

            // Select all
            document.getElementById('select-all').addEventListener('change', e => {
                document.querySelectorAll('.select-item').forEach(c => c.checked = e.target.checked);
                recalcTotal();
            });
            document.querySelectorAll('.select-item').forEach(c => c.addEventListener('change', recalcTotal));

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

            // Inisialisasi
            loadSelections();
            recalcTotal();
        });
    </script>
@endpush
