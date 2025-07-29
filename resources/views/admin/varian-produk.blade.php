<div class="table-responsive mt-4">
  <h5 class="mb-3 text-dark"><i class="bi bi-list-ul me-1"></i> Daftar Varian</h5>
  <table class="table table-bordered table-hover align-middle table-variant mb-0">
    <thead class="table-light text-center">
      <tr>
        <th>Tipe</th>
        <th>Ukuran</th>
        <th>Ketebalan (mm)</th>
        <th>Densitas (kg/m³)</th>
        <th>Harga</th>
        <th>Stok</th>
      </tr>
    </thead>
    <tbody>
      @forelse($varians as $varian)
      <tr>
        <td>{{ $varian->tipe }}</td>
        <td>{{ $varian->ukuran }}</td>
        <td class="text-center">{{ $varian->ketebalan }}</td>
        <td class="text-center">{{ $varian->densitas }}</td>
        <td class="text-success fw-semibold">Rp{{ number_format($varian->harga, 0, ',', '.') }}</td>
        <td class="text-center">{{ $varian->stok }}</td>
      </tr>
      @empty
      <tr>
        <td colspan="6" class="text-center text-muted py-5">Tidak ada varian tersedia.</td>
      </tr>
      @endforelse
    </tbody>
  </table>

  <div class="d-flex justify-content-end mt-3">
    {!! $varians->withQueryString()->links() !!}
  </div>
</div>
