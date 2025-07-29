<div>
    {{-- Statistik ringkas di atas tabel --}}
    <div class="row mb-3 gy-2">
        <div class="col-auto">
            <span class="badge bg-gradient fw-bold" style="background:linear-gradient(90deg,#8B0000,#a41515);font-size:1rem">
                <i class="bi bi-boxes me-1"></i> Total Varian: {{ $varians->total() }}
            </span>
        </div>
        <div class="col-auto">
            <span class="badge bg-success-subtle text-success">
                <i class="bi bi-check-circle me-1"></i> Stok Ready: {{ $varians->filter(fn($v)=>$v->stok > 10)->count() }}
            </span>
        </div>
        <div class="col-auto">
            <span class="badge bg-warning-subtle text-warning">
                <i class="bi bi-exclamation-triangle me-1"></i> Hampir Habis: {{ $varians->filter(fn($v)=>$v->stok > 0 && $v->stok <= 10)->count() }}
            </span>
        </div>
        <div class="col-auto">
            <span class="badge bg-danger-subtle text-danger">
                <i class="bi bi-x-circle me-1"></i> Habis: {{ $varians->filter(fn($v)=>$v->stok == 0)->count() }}
            </span>
        </div>
    </div>

    {{-- Pencarian --}}
    {{-- <div class="row mb-3">
        <div class="col-sm-6">
            <input wire:model.debounce.500ms="search" type="text" class="form-control rounded-pill"
                placeholder="🔍 Cari tipe, ukuran, atau ketebalan varian...">
        </div>
    </div> --}}

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle shadow-sm" style="border-radius:14px;overflow:hidden">
            <thead class="table-light text-center">
                <tr>
                    <th>No</th>
                    <th><i class="bi bi-archive"></i> Tipe</th>
                    <th><i class="bi bi-arrows-angle-expand"></i> Ukuran</th>
                    <th><i class="bi bi-layers"></i> Ketebalan (mm)</th>
                    <th><i class="bi bi-grid"></i> Densitas (kg/m³)</th>
                    <th><i class="bi bi-cash-stack"></i> Harga</th>
                    <th><i class="bi bi-clipboard-check"></i> Stok</th>
                </tr>
            </thead>
            <tbody>
                @forelse($varians as $idx => $varian)
                <tr style="transition:.2s" class="align-middle">
                    <td class="text-center text-muted small">{{ $varians->firstItem() + $idx }}</td>
                    <td>{{ $varian->tipe }}</td>
                    <td>{{ $varian->ukuran }}</td>
                    <td class="text-center">{{ $varian->ketebalan }}</td>
                    <td class="text-center">{{ $varian->densitas }}</td>
                    <td class="text-success fw-semibold">Rp{{ number_format($varian->harga, 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if($varian->stok > 10)
                            <span class="badge bg-success"><i class="bi bi-check2-circle"></i> Ready</span>
                        @elseif($varian->stok > 0)
                            <span class="badge bg-warning text-dark"><i class="bi bi-exclamation-triangle"></i> Hampir Habis</span>
                        @else
                            <span class="badge bg-danger"><i class="bi bi-x-circle"></i> Habis</span>
                        @endif
                        <div class="small text-muted">{{ $varian->stok }} pcs</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">Tidak ada varian sesuai pencarian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-3 gap-2 flex-wrap">
        @if ($varians->onFirstPage())
            <button class="btn btn-secondary rounded-pill px-4" disabled>
                <i class="bi bi-arrow-left"></i> Prev
            </button>
        @else
            <button wire:click="previousPage" class="btn btn-maroon rounded-pill px-4">
                <i class="bi bi-arrow-left"></i> Prev
            </button>
        @endif

        <span class="small text-muted">
            Halaman {{ $varians->currentPage() }} dari {{ $varians->lastPage() }}<br>
            Menampilkan {{ $varians->firstItem() }}-{{ $varians->lastItem() }} dari {{ $varians->total() }} varian
        </span>

        @if ($varians->hasMorePages())
            <button wire:click="nextPage" class="btn btn-maroon rounded-pill px-4">
                Next <i class="bi bi-arrow-right"></i>
            </button>
        @else
            <button class="btn btn-secondary rounded-pill px-4" disabled>
                Next <i class="bi bi-arrow-right"></i>
            </button>
        @endif
    </div>

    <style>
        .btn-maroon {
            background: linear-gradient(90deg, #8B0000, #a41515 90%);
            color: #fff;
            border: none;
            transition: background 0.2s;
        }
        .btn-maroon:hover, .btn-maroon:focus {
            background: linear-gradient(90deg, #a41515, #8B0000 90%);
            color: #fff;
        }
        .table-hover > tbody > tr:hover {
            background-color: #fbeaec !important;
            transition: .2s;
        }
    </style>
</div>
