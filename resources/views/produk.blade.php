@extends('components.layout-bootstrap')

  <head>
      <title>@yield('title', 'Produk Insulasi | Insulmart')</title>
      <!-- Tag lain seperti meta, link CSS, dll -->
  </head>

@section('content')
  <style>
    :root {
      --color-merah-tua: #8B0000;
      --grad-merah-1: #8B0000;
      --grad-merah-2: #C21D1D;
      --grad-merah-3: #FF4D4D;
      --abu-1: #f6f7f9;
    }

    .text-merah { color: var(--color-merah-tua); }

    /* HERO: rame gradient merah */
    .bg-grad-merah{
      background:
        radial-gradient(1200px 600px at 80% -10%, rgba(255,77,77,.25), transparent 40%),
        radial-gradient(800px 400px at -10% 10%, rgba(194,29,29,.25), transparent 50%),
        linear-gradient(135deg, rgba(139,0,0,.85), rgba(194,29,29,.85));
    }

    .card { transition: all 0.3s ease-in-out; }
    .card:hover {
      transform: translateY(-5px) scale(1.01);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.12);
    }

    .produk-img-wrapper {
      height: 220px;
      background-color: #fff;
      overflow: hidden;
      border-bottom: 1px solid #eee;
      position: relative;
    }

    .carousel-inner, .carousel-item { height: 100%; width: 100%; }

    .produk-img {
      max-height: 100%;
      max-width: 100%;
      object-fit: contain;
      display: block;
      margin: auto;
    }

    @media (max-width: 576px) { .produk-img-wrapper { height: 180px; } }

    .navbar { padding: 0px 24px; }

    .out-of-stock { opacity: .8; pointer-events: none; }
    .out-of-stock .produk-img { filter: grayscale(100%); }

    /* Search UI */
    .search-wrap{
      background: linear-gradient(90deg, rgba(139,0,0,.1), rgba(255,77,77,.08));
      border: 1px solid rgba(139,0,0,.15);
      border-radius: 16px;
      padding: 12px;
    }

    .btn-grad-danger{
      border: 0;
      background-image: linear-gradient(135deg, var(--grad-merah-2), var(--grad-merah-3));
      color:#fff;
    }

    .btn-grad-danger:hover{ opacity:.95; }
    .chip{
      display:inline-flex; align-items:center; gap:.35rem;
      padding:.35rem .6rem; border-radius:999px; background:#fff; border:1px solid #eee; font-size:.8rem;
    }

    .chip .x{ text-decoration:none; color:#999; }
    .chip .x:hover{ color:#333; }

    /* === SEARCH UI PRO === */
    .search-wrap{
      background: linear-gradient(90deg, rgba(139,0,0,.06), rgba(255,77,77,.05));
      border: 1px solid rgba(139,0,0,.15);
      border-radius: 18px;
      padding: 16px;
      box-shadow: 0 10px 30px rgba(139,0,0,.06);
    }

    .search-pill{
      position: relative;
      border-radius: 999px;
      padding: 4px;
      background:
        radial-gradient(80% 180% at 0% 0%, rgba(255,77,77,.35), transparent 40%),
        radial-gradient(60% 160% at 100% 100%, rgba(194,29,29,.25), transparent 40%),
        linear-gradient(135deg, rgba(139,0,0,.55), rgba(194,29,29,.55));
    }

    .search-inner{
      display: flex; align-items: center; gap: 10px;
      background: #fff; border-radius: 999px; padding: 10px 12px 10px 14px;
    }

    .search-icon{
      width: 28px; height: 28px; display: grid; place-items: center;
      border-radius: 999px; background: rgba(139,0,0,.08);
    }

    .search-input{
      border: 0; outline: none; flex: 1; font-size: 1.05rem; padding: 8px 6px;
    }
    .search-input::placeholder{ color:#a8a8a8; }
    .search-btn{
      border:0; padding:10px 18px; border-radius:999px; font-weight:600; color:#fff;
      background-image: linear-gradient(135deg, #C21D1D, #FF4D4D);
    }
    .search-btn:hover{ opacity:.95; }

    .search-clear{
      display:none; border:0; background:#f3f3f4; color:#555; border-radius:999px;
      width:36px; height:36px; line-height:36px; text-align:center;
    }

    .search-clear:hover{ background:#ececee; }

    .quick-tags{ display:flex; flex-wrap:wrap; gap:8px; margin-top:10px; }

    .quick-tags a{
      text-decoration:none; font-size:.85rem; color:#8B0000; background:#fff;
      border:1px solid rgba(139,0,0,.18); padding:.35rem .7rem; border-radius:999px;
    }

    .quick-tags a:hover{ background:rgba(139,0,0,.06); }

    .kbd{
      font: 500 11px/1 ui-monospace, SFMono-Regular, Menlo, monospace;
      color:#666; background:#f2f2f3; border:1px solid #e6e6e7;
      border-bottom-width:2px; padding:2px 6px; border-radius:6px;
    }

  </style>

  {{-- Hero Banner Produk --}}
  <section class="position-relative text-center text-white fade-up" style="
    height: 260px;
    background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.6)),
                url('{{ asset('assets/img/landing/7.jpg') }}') center center / cover no-repeat;">   <div class="position-relative h-100 d-flex flex-column justify-content-center align-items-center">
      <h2 class="fw-bold mb-1">Produk Insulasi Kami</h2>
      <p class="text-white-50 small mb-0">Insulasi cerdas untuk kenyamanan rumah & industri</p>
    </div>
  </section>

  <section class="py-5" style="background: var(--abu-1);">
    <div class="container">
      <div class="text-center mb-4 fade-up">
        <h2 class="fw-bold text-merah">Produk Pilihan Kami</h2>
        <p class="text-muted">Eksplorasi koleksi produk unggulan terbaik kami dengan kualitas terjamin</p>
      </div>

      {{-- 🔎 Search form (GET) – drop-in upgrade --}}
      <form method="GET" action="" class="search-wrap mb-4 fade-up" role="search" id="produkSearchForm">
        <div class="search-pill">
          <div class="search-inner">
            <div class="search-icon" aria-hidden="true">
              <svg width="16" height="16" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                <path d="M11.742 10.344a6.5 6.5 0 10-1.397 1.398h-.001l3.85 3.85a1 1 0 001.415-1.414l-3.867-3.834zM12 6.5a5.5 5.5 0 11-11 0 5.5 5.5 0 0111 0z" fill="currentColor"/>
              </svg>
            </div>

            <input
              type="search"
              id="q"
              name="q"
              value="{{ request('q') }}"
              class="search-input"
              placeholder="Cari cepat: &quot;glasswool&quot;, &quot;rockwool&quot;, &quot;aluminium foil&quot;…"
              aria-label="Cari produk">

            <button type="button" class="search-clear" id="btnClearQ" aria-label="Hapus kata kunci">✕</button>
            <button class="search-btn" type="submit">Cari</button>
          </div>
        </div>

        {{-- info jumlah + shortcut (responsif hanya di blok ini) --}}
        @php
          $jumlah = $produks instanceof \Illuminate\Pagination\LengthAwarePaginator
              ? $produks->total()
              : (is_countable($produks) ? count($produks) : 0);
        @endphp

        <div class="row align-items-center mt-2 g-2">
          <div class="col-12 col-md-6">
            <div class="small text-muted text-center text-md-start">
              @if(request('q'))
                Menemukan <strong>{{ $jumlah }}</strong> produk untuk <strong>“{{ request('q') }}”</strong>.
              @else
                Menampilkan <strong>{{ $jumlah }}</strong> produk.
              @endif
            </div>
          </div>

          <div class="col-12 col-md-6">
            <div class="small text-muted text-center text-md-end">
              {{-- Tip disembunyikan di layar kecil, tampil di md+ --}}
              <span class="d-none d-md-inline">Tip: tekan <span class="kbd">/</span> untuk fokus ke pencarian</span>

              @if(request('q'))
                <span class="d-none d-md-inline"> • </span>
                {{-- Reset selalu tampil (termasuk mobile) --}}
                <a href="{{ url()->current() }}" class="link-secondary">Reset</a>
              @endif
            </div>
          </div>
        </div>

        {{-- quick tags (kolom jenis_produk) --}}
        @php
          // suggestions dari controller berbentuk Collection<string>
          $showSuggestions = collect($suggestions ?? [])->take(10);
        @endphp

        @if($showSuggestions->isNotEmpty())
          <div class="quick-tags" aria-label="Sugesti cepat">
            @foreach($showSuggestions as $s)
              @php
                // klik tag → set q = jenis_produk
                $qs = array_merge(request()->except('page'), ['q' => $s]);
              @endphp
              <a href="{{ url()->current() . '?' . http_build_query($qs) }}">{{ $s }}</a>
            @endforeach
          </div>
        @else
          {{-- fallback kalau belum ada jenis di DB --}}
          <div class="quick-tags" aria-label="Sugesti cepat">
            @foreach(['Glasswool','Rockwool','Pipa Insulasi','Aluminium Foil','Bubble Foil','Ducting'] as $s)
              @php $qs = array_merge(request()->except('page'), ['q' => $s]); @endphp
              <a href="{{ url()->current() . '?' . http_build_query($qs) }}">{{ $s }}</a>
            @endforeach
          </div>
        @endif
      </form>

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        @forelse ($produks as $product)
          @php
            $totalStok = $product->varians->sum('stok');
            $habis     = $totalStok <= 0;
            $hargaMin  = $product->varians->min('harga');
            $hargaMax  = $product->varians->max('harga');
          @endphp

          <div class="col fade-up">
            @if ($habis)
              {{-- Kartu non-klik + badge Stok Habis --}}
              <div class="card h-100 shadow-sm rounded-4 overflow-hidden position-relative out-of-stock" aria-disabled="true" role="group">
                <span class="badge bg-danger position-absolute top-0 start-0 m-2 z-1">Stok Habis</span>

                {{-- Carousel/Gambar: non-ride saat habis --}}
                @if ($product->gambars->count() > 0)
                  <div id="carouselProduk{{ $product->id }}" class="carousel slide produk-img-wrapper" data-bs-ride="false">
                    <div class="carousel-inner h-100 w-100">
                      @foreach ($product->gambars as $index => $gambar)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }} h-100">
                          <div class="d-flex justify-content-center align-items-center h-100">
                            <img src="{{ asset('storage/' . $gambar->path) }}" class="produk-img" alt="Gambar {{ $index + 1 }}">
                          </div>
                        </div>
                      @endforeach
                    </div>
                  </div>
                @else
                  <div class="produk-img-wrapper d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/no-img-ava.jpg') }}" class="produk-img" alt="{{ $product->nama_produk }}">
                  </div>
                @endif

                {{-- Konten --}}
                <div class="card-body d-flex flex-column">
                  <h5 class="card-title text-merah mb-2">{{ $product->nama_produk }}</h5>
                  <p class="card-text text-muted small flex-grow-1">
                    {!! \Illuminate\Support\Str::limit(strip_tags($product->deskripsi), 80) !!}
                  </p>

                  <div class="mt-auto">
                    <p class="text-dark fw-semibold mb-1">Harga:</p>
                    <p class="fw-bold text-danger fs-5 mb-0">
                      @if ($hargaMin === $hargaMax)
                        Rp{{ number_format($hargaMin, 0, ',', '.') }}
                      @else
                        Rp{{ number_format($hargaMin, 0, ',', '.') }} <span class="text-muted">–</span>
                        Rp{{ number_format($hargaMax, 0, ',', '.') }}
                      @endif
                    </p>
                  </div>
                </div>
              </div>
            @else
              {{-- Kartu normal: bisa diklik ke detail --}}
              <a href="{{ route('produk.detail', $product->slugified_nama) }}" class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm rounded-4 overflow-hidden position-relative">
                  @if ($product->gambars->count() > 0)
                    <div id="carouselProduk{{ $product->id }}" class="carousel slide produk-img-wrapper" data-bs-ride="carousel" data-bs-interval="3000">
                      <div class="carousel-inner h-100 w-100">
                        @foreach ($product->gambars as $index => $gambar)
                          <div class="carousel-item {{ $index == 0 ? 'active' : '' }} h-100">
                            <div class="d-flex justify-content-center align-items-center h-100">
                              <img src="{{ asset('storage/' . $gambar->path) }}" class="produk-img" alt="Gambar {{ $index + 1 }}">
                            </div>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  @else
                    <div class="produk-img-wrapper d-flex justify-content-center align-items-center">
                      <img src="{{ asset('assets/img/no-img-ava.jpg') }}" class="produk-img" alt="{{ $product->nama_produk }}">
                    </div>
                  @endif

                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title text-merah mb-2">{{ $product->nama_produk }}</h5>
                    <p class="card-text text-muted small flex-grow-1">
                      {!! \Illuminate\Support\Str::limit(strip_tags($product->deskripsi), 80) !!}
                    </p>

                    <div class="mt-auto">
                      <p class="text-dark fw-semibold mb-1">Harga:</p>
                      <p class="fw-bold text-danger fs-5 mb-0">
                        @if ($hargaMin === $hargaMax)
                          Rp{{ number_format($hargaMin, 0, ',', '.') }}
                        @else
                          Rp{{ number_format($hargaMin, 0, ',', '.') }} <span class="text-muted">–</span>
                          Rp{{ number_format($hargaMax, 0, ',', '.') }}
                        @endif
                      </p>
                    </div>
                  </div>
                </div>
              </a>
            @endif
          </div>
        @empty
          <div class="col-12 text-center">
            @if(request('q'))
              <h5 class="text-muted">Tidak ada produk untuk kata kunci “{{ request('q') }}”.</h5>
              <a href="{{ url()->current() }}" class="btn btn-outline-secondary btn-sm mt-2">Lihat semua produk</a>
            @else
              <h5 class="text-muted">Tidak ada produk tersedia.</h5>
            @endif
          </div>
        @endforelse

      </div>
    </div>
  </section>

  {{-- Bootstrap JS Carousel --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  @include('components.back-to-top')
  <script>
    (function(){
      const input = document.getElementById('q');
      const clearBtn = document.getElementById('btnClearQ');

      function syncClear(){
        if(!clearBtn) return;
        clearBtn.style.display = (input && input.value.trim().length) ? 'inline-block' : 'none';
      }
      if (input) {
        input.addEventListener('input', syncClear);
        syncClear();

        // shortcut "/" untuk fokus
        window.addEventListener('keydown', function(e){
          if (e.key === '/' && document.activeElement !== input) {
            e.preventDefault();
            input.focus();
            input.select();
          }
        });
      }
      if (clearBtn && input) {
        clearBtn.addEventListener('click', function(){
          input.value = '';
          syncClear();
          input.focus();
        });
      }
    })();
  </script>

  <script>
    (function(){
      const input = document.getElementById('q');
      const clearBtn = document.getElementById('btnClearQ');
      function syncClear(){ if(!clearBtn) return; clearBtn.style.display = (input && input.value.trim().length) ? 'inline-block' : 'none'; }
      if (input) {
        input.addEventListener('input', syncClear);
        syncClear();
        window.addEventListener('keydown', function(e){
          if (e.key === '/' && document.activeElement !== input) { e.preventDefault(); input.focus(); input.select(); }
        });
      }
      if (clearBtn && input) { clearBtn.addEventListener('click', function(){ input.value = ''; syncClear(); input.focus(); }); }
    })();
  </script>
@endsection
