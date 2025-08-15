@extends('admin.components.app')

<head>
    <title>@yield('title', 'Edit Pembelian Produk | Insulmart')</title>
</head>

@section('content')
<style>
    :root {
        --color-merah-tua: #8B0000;
        --color-merah-hover: #a41515;
        --color-gradient: linear-gradient(90deg, #8B0000 0%, #a41515 100%);
        --color-gradient-hover: linear-gradient(90deg, #a41515 0%, #8B0000 100%);
        --color-maroon-light: #fbeaec;
    }
    .text-merah { color: var(--color-merah-tua) !important; }
    .btn-maroon { background: var(--color-gradient); color:#fff; border:none; border-radius:2em; padding:.6rem 1.5rem; font-weight:500; transition:all .3s }
    .btn-maroon:hover { background:var(--color-gradient-hover); color:#fff; transform:translateY(-2px); box-shadow:0 4px 12px rgba(139,0,0,.2) }
    .btn-outline-maroon { color:var(--color-merah-tua); border:2px solid var(--color-merah-tua); border-radius:2em; padding:.5rem 1.2rem; font-weight:500; transition:all .3s }
    .btn-outline-maroon:hover { background:var(--color-gradient); color:#fff; border-color:transparent; transform:translateY(-2px) }
    .card-custom { border-radius:1rem; border:none; box-shadow:0 4px 18px rgba(139,0,0,.08) }
    .form-control,.form-select { border-radius:.8rem; padding:.6rem 1rem; border-color:#dee2e6 }
    .form-control:focus,.form-select:focus { border-color:var(--color-merah-tua); box-shadow:0 0 0 .2rem rgba(139,0,0,.1) }
    .input-group .form-control { border-radius:0 .8rem .8rem 0 }
    .input-group-text { border-radius:.8rem 0 0 .8rem; background:var(--color-maroon-light); border-color:#dee2e6; color:var(--color-merah-tua) }
    .form-label { color:var(--color-merah-tua); font-weight:500; margin-bottom:.5rem }
    .info-icon { color:var(--color-merah-tua); font-size:2.5rem; margin-bottom:1rem }
    .disabled-note { font-size:.85rem; color:#6c757d }
</style>

@php
    $terminalStatuses = ['selesai','dibatalkan','dikembalikan_ke_supplier'];
    $progressStatuses = ['dipesan','dikirim','diterima_sebagian'];

    $currentStatus = old('status', $pembelian->status);
    $isTerminal = in_array($currentStatus, $terminalStatuses, true);
    $isProgress = in_array($currentStatus, $progressStatuses, true);
    $isDraft    = $currentStatus === 'draft';

    // Helper flags untuk field
    $lockAll     = $isTerminal;            // semua terkunci
    $lockExceptStatus = $isProgress;       // hanya status yang boleh
    $freeEdit    = $isDraft;
@endphp

<main class="main-content p-4 bg-light" id="mainContent">
    <div class="mb-4 border-bottom pb-3 d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold text-merah mb-1" style="font-size:2rem;letter-spacing:.5px">
                <i class="bi bi-pencil-square me-2"></i> Edit Pembelian
            </h3>
            <p class="text-muted mb-0">Edit data pembelian varian produk</p>
        </div>
        <a href="{{ route('pembelian.index') }}" class="btn btn-outline-maroon">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card card-custom">
                <div class="card-body">
                    <form action="{{ route('pembelian.update', $pembelian->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- VARIAN --}}
                        <div class="mb-4">
                            <label for="varian_id" class="form-label">Pilih Varian Produk</label>
                            <select id="varian_id" class="form-select @error('varian_id') is-invalid @enderror"
                                    {{ ($lockAll || $lockExceptStatus) ? 'disabled' : '' }}>
                                <option value="">Pilih Varian</option>
                                @foreach($varians as $varian)
                                    <option value="{{ $varian->id }}"
                                        {{ old('varian_id', $pembelian->varian_id) == $varian->id ? 'selected' : '' }}>
                                        {{ $varian->produk->nama_produk }} - {{ $varian->tipe }}
                                    </option>
                                @endforeach
                            </select>
                            {{-- hidden agar nilai tetap terkirim jika select di-disable --}}
                            <input type="hidden" name="varian_id" value="{{ old('varian_id', $pembelian->varian_id) }}">
                            @error('varian_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        {{-- DISTRIBUTOR --}}
                        <div class="mb-4">
                            <label for="distributor_id" class="form-label">Pilih Distributor</label>
                            <select id="distributor_id" class="form-select @error('distributor_id') is-invalid @enderror"
                                    {{ ($lockAll || $lockExceptStatus) ? 'disabled' : '' }}>
                                <option value="">Pilih Distributor</option>
                                @foreach($distributors as $dist)
                                    <option value="{{ $dist->id }}"
                                        {{ old('distributor_id', $pembelian->distributor_id) == $dist->id ? 'selected' : '' }}>
                                        {{ $dist->name_pt }}@if($dist->contact_person) — {{ $dist->contact_person }} ⮕ {{ $dist->notes }} @endif
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="distributor_id" value="{{ old('distributor_id', $pembelian->distributor_id) }}">
                            @error('distributor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="qty" class="form-label">Jumlah</label>
                                <input type="number" name="qty" id="qty"
                                       class="form-control @error('qty') is-invalid @enderror"
                                       value="{{ old('qty', $pembelian->qty) }}" min="1" step="1"
                                       {{ ($lockAll || $lockExceptStatus) ? 'readonly' : '' }}>
                                <small class="text-muted">Masukkan jumlah dalam angka bulat</small>
                                @error('qty') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="harga_satuan" class="form-label">Harga Satuan</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" name="harga_satuan" id="harga_satuan"
                                           class="form-control @error('harga_satuan') is-invalid @enderror"
                                           value="{{ old('harga_satuan', $pembelian->harga_satuan) }}" min="0"
                                           {{ ($lockAll || $lockExceptStatus) ? 'readonly' : '' }}>
                                </div>
                                @error('harga_satuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="tanggal_beli" class="form-label">Tanggal Pembelian</label>
                                <input type="date" name="tanggal_beli" id="tanggal_beli"
                                       class="form-control @error('tanggal_beli') is-invalid @enderror"
                                       value="{{ old('tanggal_beli', optional($pembelian->tanggal_beli)->format('Y-m-d')) }}"
                                       {{ ($lockAll || $lockExceptStatus) ? 'readonly' : '' }}>
                                @error('tanggal_beli') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="status" class="form-label">Status</label>

                                {{-- Terminal: kunci select --}}
                                @if($isTerminal)
                                    <select id="status" class="form-select text-muted" disabled>
                                        <option value="{{ $currentStatus }}" selected>
                                            {{ str_replace('_',' ', ucfirst($currentStatus)) }} (terkunci)
                                        </option>
                                    </select>
                                    <input type="hidden" name="status" value="{{ $currentStatus }}">
                                    <small class="disabled-note d-block mt-1">
                                        Status sudah final, tidak dapat diubah (Selesai/Dibatalkan/Dikembalikan ke Supplier).
                                    </small>
                                @else
                                    {{-- Progress: hanya status boleh diedit --}}
                                    <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                        <option value="draft"                     {{ $currentStatus==='draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="dipesan"                   {{ $currentStatus==='dipesan' ? 'selected' : '' }}>Dipesan</option>
                                        <option value="dikirim"                   {{ $currentStatus==='dikirim' ? 'selected' : '' }}>Dikirim</option>
                                        <option value="diterima_sebagian"         {{ $currentStatus==='diterima_sebagian' ? 'selected' : '' }}>Diterima Sebagian</option>
                                        <option value="selesai"                   {{ $currentStatus==='selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="dibatalkan"                {{ $currentStatus==='dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                        <option value="dikembalikan_ke_supplier"  {{ $currentStatus==='dikembalikan_ke_supplier' ? 'selected' : '' }}>Dikembalikan ke Supplier</option>
                                    </select>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                    @if($isProgress)
                                        <small class="disabled-note d-block mt-1">
                                            Transaksi sedang berjalan. Hanya <b>status</b> yang dapat diubah.
                                        </small>
                                    @endif
                                @endif
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="catatan" class="form-label">Catatan</label>
                            <textarea name="catatan" id="catatan" rows="3"
                                      class="form-control @error('catatan') is-invalid @enderror"
                                      {{ ($lockAll || $lockExceptStatus) ? 'readonly' : '' }}>{{ old('catatan', $pembelian->catatan) }}</textarea>
                            @error('catatan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Total Harga</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="text" id="total_harga" class="form-control" readonly
                                       value="{{ number_format($pembelian->total_harga, 0, ',', '.') }}">
                            </div>
                            <small class="text-muted">Total harga akan dihitung otomatis</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('pembelian.index') }}" class="btn btn-outline-maroon">
                                <i class="bi bi-x-circle me-2"></i>Batal
                            </a>

                            <button type="submit" class="btn btn-maroon"
                                    {{ $isTerminal ? 'disabled' : '' }}>
                                <i class="bi bi-check-circle me-2"></i>Update Pembelian
                            </button>
                        </div>

                        @if($isTerminal)
                            <div class="mt-2 disabled-note">
                                Semua field dikunci karena status final.
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-custom">
                <div class="card-body p-4 text-center">
                    <i class="bi bi-info-circle-fill info-icon"></i>
                    <h5 class="card-title text-merah">Informasi Pembaruan</h5>
                    <ul class="list-unstyled mb-0 text-start">
                        <li class="mb-2">
                            <i class="bi bi-check2-circle text-success me-2"></i>
                            <b>Draft</b>: semua field bisa diedit.
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check2-circle text-success me-2"></i>
                            <b>Dipesan/Dikirim/Diterima Sebagian</b>: hanya <b>status</b> yang bisa diubah.
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check2-circle text-success me-2"></i>
                            <b>Selesai/Dibatalkan/Dikembalikan ke Supplier</b>: semua field terkunci.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
@if($isDraft)
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const qtyInput   = document.getElementById('qty');
        const hargaInput = document.getElementById('harga_satuan');
        const totalInput = document.getElementById('total_harga');

        function hitungTotal() {
            const qty   = parseInt(qtyInput.value)   || 0;
            const harga = parseInt(hargaInput.value) || 0;
            const total = qty * harga;
            totalInput.value = total.toLocaleString('id-ID');
        }

        qtyInput.addEventListener('input', hitungTotal);
        hargaInput.addEventListener('input', hitungTotal);
    });
</script>
@endif
@endpush
