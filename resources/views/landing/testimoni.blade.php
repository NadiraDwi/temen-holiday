<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Temen Holiday</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">

  <style>
    .review-card {
      background: #fff;
      padding: 18px;
      border-radius: 12px;
      border: 1px solid #eee;
      box-shadow: 0 2px 6px rgba(0,0,0,0.06);
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
    }

    .review-name {
      font-weight: 600;
      font-size: 1.1rem;
      color: #222;
    }

    .rating-row {
          display: flex;
          align-items: center;
          margin-top: 6px;
      }

      .rating-label {
          width: 90px;   /* semua label fix width → bintangnya sejajar */
          font-size: 0.85rem;
          color: #666;
      }

      .rating-stars i {
          font-size: 17px;
          margin-right: 2px;
      }

    .label-small {
      font-size: 0.85rem;
      color: #666;
      margin-bottom: 2px;
      width: 80px;
    }

    .review-text {
      color: #444;
      margin-top: 8px;
      margin-bottom: 10px;
      line-height: 1.5;
    }

    .review-images {
      display: flex;
      gap: 8px;
      flex-wrap: wrap;
      margin-top: 10px;
    }

    .review-images img {
      width: 95px;
      height: 95px;
      object-fit: cover;
      border-radius: 8px;
      border: 1px solid #ddd;
    }

    /* ========== DESKTOP ========== */
    @media (min-width: 768px) {
        .modal-body {
            max-height: 350px;
            overflow: hidden;
        }

        .modal-right-scroll {
            max-height: 350px;
            overflow-y: auto;
            padding-right: 6px;
        }

        .modal-slide-img {
            max-height: 400px;
            object-fit: cover;
        }
    }

    /* ========== MOBILE ========== */
    @media (max-width: 767px) {
        /* Modal jadi tinggi penuh layar */
        .modal-dialog {
            margin: 0;
            height: 90%;
            max-width: 100%;
        }

        .modal-content {
            height: 90%;
            border-radius: 0;
        }

        .modal-body {
            overflow-y: auto;
            padding-bottom: 40px;
        }

        /* Slider lebih kecil di mobile */
        .modal-slide-img {
            max-height: 260px;
            object-fit: cover;
            border-radius: 8px;
        }

        /* Kolom kanan tidak scroll, biar natural */
        .modal-right-scroll {
            max-height: none;
            overflow: visible;
            padding-right: 0;
        }
    }
  </style>
</head>

<body>

  @include('landing.components.header')

  {{-- HERO --}}
  <section class="hero hero-small" style="background-image: url('{{ asset('assets/image/home1.jpeg') }}');">
    <div class="hero-text">
      <h1>Testimoni</h1>
    </div>
  </section>

  <div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
      <h2 class="section-title-left mb-0">Apa Kata Mereka?</h2>

      <a href="{{ route('testimoni.create') }}" class="btn btn-primary px-4">
        Berikan Ulasanmu
      </a>
    </div>

    <div class="row g-4">

      @foreach ($testimoni as $t)
        @php
          $images = is_array($t->images)
              ? $t->images
              : (json_decode($t->images, true) ?: []);

          $uid = $t->id_testimoni ?? $t->getKey();
        @endphp

        <div class="col-md-6 col-lg-4">
          <div class="review-card">

            <div>
              {{-- NAMA --}}
              <div class="review-name">{{ $t->nama_user }}</div>

              <div class="rating-row">
                  <div class="rating-label">Fasilitas</div>
                  <div class="rating-stars text-warning">
                      @for ($i = 1; $i <= 5; $i++)
                          <i class="bi {{ $i <= $t->rating_fasilitas ? 'bi-star-fill' : 'bi-star' }}"></i>
                      @endfor
                  </div>
              </div>

              <div class="rating-row">
                  <div class="rating-label">Harga</div>
                  <div class="rating-stars text-warning">
                      @for ($i = 1; $i <= 5; $i++)
                          <i class="bi {{ $i <= $t->rating_harga ? 'bi-star-fill' : 'bi-star' }}"></i>
                      @endfor
                  </div>
              </div>

              {{-- ULASAN --}}
              <p class="review-text mt-2">{{ Str::limit($t->pesan, 120) }}</p>

              {{-- GAMBAR --}}
              @if (!empty($images))
                <div class="review-images">
                  @foreach ($images as $img)
                    <img src="{{ asset('storage/' . $img) }}" alt="Foto testimoni">
                  @endforeach
                </div>
              @endif
            </div>

            {{-- TOMBOL --}}
            <div class="mt-3">
              <button class="btn btn-sm btn-outline-primary w-100"
                      data-bs-toggle="modal"
                      data-bs-target="#detailTesti{{ $uid }}">
                Detail
              </button>
            </div>

          </div>
        </div>

        {{-- ================= MODAL ================= --}}
        <div class="modal fade" id="detailTesti{{ $uid }}" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title">Detail Testimoni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <div class="row g-4">

                  {{-- LEFT (SLIDER) --}}
                  <div class="col-md-5">
                    @if (!empty($images))
                      <div id="carousel{{ $uid }}" class="carousel slide">
                        <div class="carousel-inner">
                          @foreach ($images as $index => $img)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                              <img src="{{ asset('storage/' . $img) }}" class="d-block w-100 modal-slide-img">
                            </div>
                          @endforeach
                        </div>

                        @if (count($images) > 1)
                          <button class="carousel-control-prev" type="button" data-bs-target="#carousel{{ $uid }}" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                          </button>
                          <button class="carousel-control-next" type="button" data-bs-target="#carousel{{ $uid }}" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                          </button>
                        @endif
                      </div>
                    @else
                      <div class="text-muted text-center">Tidak ada foto.</div>
                    @endif
                  </div>

                  {{-- RIGHT (DETAIL) --}}
                  <div class="col-md-7 modal-right-scroll">
                    <h5 class="fw-bold mb-1">{{ $t->nama_user }}</h5>

                    <div class="rating-row">
                        <div class="rating-label">Fasilitas</div>
                        <div class="rating-stars text-warning">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= $t->rating_fasilitas ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </div>
                    </div>

                    <div class="rating-row">
                        <div class="rating-label">Harga</div>
                        <div class="rating-stars text-warning">
                            @for ($i = 1; $i <= 5; $i++)
                                <i class="bi {{ $i <= $t->rating_harga ? 'bi-star-fill' : 'bi-star' }}"></i>
                            @endfor
                        </div>
                    </div>

                    <p class="mt-3 text-dark">{{ $t->pesan }}</p>

                    @if (!empty($t->reply_admin))
                      <div class="bg-light p-3 rounded border">
                        <strong>Balasan Admin:</strong>
                        <p class="mb-0">{{ $t->reply_admin }}</p>
                      </div>
                    @endif
                  </div>

                </div>
              </div>

              <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
              </div>

            </div>
          </div>
        </div>
        {{-- =============== END MODAL =============== --}}

      @endforeach

    </div>
  </div>

  @include('landing.components.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.querySelectorAll('.modal').forEach(modalEl => {
      modalEl.addEventListener('shown.bs.modal', function () {
        const carousel = modalEl.querySelector('.carousel');
        if (carousel) {
          const bsCarousel = bootstrap.Carousel.getInstance(carousel)
            || new bootstrap.Carousel(carousel, { ride: false });
          bsCarousel.to(0);
        }
      });
    });
  </script>

  <script>
function checkForm() {
  const nama = document.getElementById("nama").value.trim();
  const pilihan = document.getElementById("pilihan").value;
  const telp = document.getElementById("telp").value.trim();

  const btn = document.getElementById("submitBtn");

  // Cek semua harus terisi
  if (nama !== "" && pilihan !== "" && telp !== "") {
    btn.disabled = false;
  } else {
    btn.disabled = true;
  }
}

// Jalankan cek tiap input berubah
document.getElementById("nama").addEventListener("input", checkForm);
document.getElementById("pilihan").addEventListener("change", checkForm);
document.getElementById("telp").addEventListener("input", checkForm);

document.getElementById("waForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const nama = document.getElementById("nama").value;
  const pilihan = document.getElementById("pilihan").value;
  const telp = document.getElementById("telp").value;

  const nomorTujuan = "6281234567890"; // GANTI nomor WA mitra

  const pesan =
`Halo kak, saya ingin ${pilihan}.

*Nama:* ${nama}
*Nomor:* ${telp}

Mohon info lebih lanjut ya kak.`;

  const url = "https://wa.me/" + nomorTujuan + "?text=" + encodeURIComponent(pesan);

  window.open(url, "_blank");
});
</script>

</body>
</html>
