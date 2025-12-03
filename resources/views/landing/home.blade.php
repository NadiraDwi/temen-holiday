<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Temen Holiday</title>
  <link rel="icon" href="{{ asset('assets/image/logo.png') }}" type="image/png">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

  <!-- Custom CSS -->
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

<!-- NAVBAR -->
@include('landing.components.header')

<div class="hero-wrapper">

  <!-- SLIDES BG ONLY -->
  <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">

      <div class="carousel-item active">
        <div class="hero-bg" style="background-image:url('assets/image/home1.jpeg');"></div>
      </div>

      <div class="carousel-item">
        <div class="hero-bg" style="background-image:url('assets/image/home2.jpeg');"></div>
      </div>

    </div>
  </div>

  <!-- FIXED CONTENT (tetap di tempat) -->
  <div class="hero-overlay">
    <h1 class="hero-title">Welcome to Temen Holiday</h1>
    <p class="hero-subtitle">"As Close As Friends, As Warm As Family"</p>

    <div class="search-container">
      <input type="text" class="form-control search-input"
             placeholder="Cari destinasi atau paket tour...">
      <i class="bi bi-search search-icon"></i>
    </div>
  </div>

</div>

  <!-- OVERLAY TEXT -->
  <div class="hero-overlay position-absolute top-50 start-50 translate-middle text-center">
    <h1 class="hero-title">Welcome to Temen Holiday</h1>
    <p class="hero-subtitle">"As Close As Friends, As Warm As Family"</p>

    <div class="search-container position-relative">
      <input type="text" class="form-control search-input" placeholder="Cari destinasi atau paket tour...">
      <i class="search-icon bi bi-search"></i>
    </div>
  </div>

</div>

  <!-- CONTROL -->
  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>


<!-- Section Why -->
<section class="why-simple py-5">
    <div class="container">
      <h2 class="text-center mb-4 fw-bold">Mengapa Memilih Kami?</h2>
        <div class="row g-4">

            <div class="col-md-3 col-6">
                <div class="why-card-simple text-center p-4">
                    <i class="fas fa-user-friends why-icon-simple"></i>
                    <h5 class="mt-3 fw-bold">Pendampingan</h5>
                    <p class="text-muted small">Kami selalu mendampingi perjalanan agar lebih aman.</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="why-card-simple text-center p-4">
                    <i class="fas fa-shield-alt why-icon-simple"></i>
                    <h5 class="mt-3 fw-bold">Keamanan</h5>
                    <p class="text-muted small">Rute aman dan dipilih oleh tim berpengalaman.</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="why-card-simple text-center p-4">
                    <i class="fas fa-car why-icon-simple"></i>
                    <h5 class="mt-3 fw-bold">Armada Nyaman</h5>
                    <p class="text-muted small">Kendaraan bersih, terbaru, dan terawat.</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="why-card-simple text-center p-4">
                    <i class="fas fa-map-marker-alt why-icon-simple"></i>
                    <h5 class="mt-3 fw-bold">Banyak Destinasi</h5>
                    <p class="text-muted small">Banyak pilihan destinasi wisata menarik.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- KENDARAAN -->
<section class="py-5 bg-light" id="kendaraan">
  <div class="container">
    <h2 class="text-center mb-4 fw-bold">Kendaraan Kami</h2>

    <div class="row g-4">

      @foreach($categories as $cat)
        @php
          $vehicle = $cat->vehicles->first();
        @endphp

        <div class="col-md-4">
          <a href="{{ url('/kendaraan?kategori=' . $cat->id_category) }}" class="text-decoration-none">
            <div class="vehicle-card"
              style="background-image: url('{{ $vehicle ? asset('storage/kendaraan/' . $vehicle->gambar) : asset('assets/image/mobil1.jpeg') }}');">
              
              <span class="vehicle-badge">{{ $cat->kategori }}</span>
              <p class="vehicle-desc">
                {{ $cat->keterangan ?? 'Kendaraan nyaman untuk berbagai kebutuhan.' }}
              </p>
            </div>
          </a>
        </div>

      @endforeach

    </div>

    <div class="text-center mt-4">
      <a href="{{ url('/kendaraan') }}" class="more-link">
        Selengkapnya <i class="bi bi-arrow-right"></i>
      </a>
    </div>

  </div>
</section>

<!-- PAKET WISATA -->
<section class="py-5" id="paket">
  <div class="container">
    <h2 class="text-center mb-4 fw-bold">Paket Wisata</h2>

    <div class="row g-4">
      <div class="col-md-4">
        <a href="{{ url('/paket') }}" class="text-decoration-none">
          <div class="card h-100 shadow-sm card-hover">
            <img src="{{ asset('assets/image/wisata1.jpeg') }}" class="card-img-top card-img-fixed">
            <div class="card-body">
              <h5 class="fw-bold text-dark">Paket 1 - Bandung</h5>
              <p class="text-muted">Rp 1.500.000</p>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="{{ url('/paket') }}" class="text-decoration-none">
          <div class="card h-100 shadow-sm card-hover">
            <img src="{{ asset('assets/image/wisata2.jpeg') }}" class="card-img-top card-img-fixed">
            <div class="card-body">
              <h5 class="fw-bold text-dark">Paket 2 - Bali</h5>
              <p class="text-muted">Rp 3.200.000</p>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="{{ url('/paket') }}" class="text-decoration-none">
          <div class="card h-100 shadow-sm card-hover">
            <img src="{{ asset('assets/image/wisata3.jpeg') }}" class="card-img-top card-img-fixed">
            <div class="card-body">
              <h5 class="fw-bold text-dark">Paket 3 - Lombok</h5>
              <p class="text-muted">Rp 2.800.000</p>
            </div>
          </div>
        </a>
      </div>
    </div>

    <div class="text-center mt-4">
      <a href="{{ url('/paket') }}" class="more-link">
        Selengkapnya <i class="bi bi-arrow-right"></i>
      </a>
    </div>

  </div>
</section>

<!-- GALERI -->
<section class="py-5 bg-light" id="galeri">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold mb-0">Galeri</h2>
      <a href="{{ url('/galeri') }}" class="more-link">Lihat Semua <i class="bi bi-arrow-right"></i></a>
    </div>

    <!-- SWIPER WRAP -->
    <div class="position-relative">

      <!-- LEFT BUTTON -->
      <div class="swiper-button-prev gallery-prev"></div>

      <!-- RIGHT BUTTON -->
      <div class="swiper-button-next gallery-next"></div>

      <!-- SLIDER -->
      <div class="swiper gallerySwiper">
        <div class="swiper-wrapper">
          @foreach($galeri as $g)
            <div class="swiper-slide">
              <img src="{{ asset('storage/galeri/' . $g->gambar) }}" class="gallery-img-home">
            </div>
          @endforeach
        </div>
      </div>

    </div>

  </div>
</section>

<!-- ✅ SECTION ULASAN -->
<section class="py-5" id="ulasan">
  <div class="container">

    <!-- TITLE + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold mb-0">Ulasan</h2>
    </div>

    <!-- LIST ULASAN -->
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
</section>

<!-- =============== SECTION: PARTNER / KOLABORASI =============== -->
<section class="py-5 bg-light">
  <div class="container text-center">
    <h2 class="fw-bold section-title-center mb-4">Pernah Berkolaborasi Dengan</h2>
    <p class="text-muted mb-5">
      Kami dipercaya oleh berbagai perusahaan dan instansi dalam menyediakan layanan perjalanan terbaik.
    </p>

    <div class="row g-4 justify-content-center">
      
      <!-- 6 Partner Loop -->
      <div class="col-6 col-md-4 col-lg-2">
        <div class="partner-box shadow-sm p-3 bg-white rounded-3">
          <img src="assets/partner/partner1.jpg" class="img-fluid partner-logo" alt="Partner">
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <div class="partner-box shadow-sm p-3 bg-white rounded-3">
          <img src="assets/partner/partner2.jpg" class="img-fluid partner-logo" alt="Partner">
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <div class="partner-box shadow-sm p-3 bg-white rounded-3">
          <img src="assets/partner/partner3.jpg" class="img-fluid partner-logo" alt="Partner">
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <div class="partner-box shadow-sm p-3 bg-white rounded-3">
          <img src="assets/partner/partner4.jpg" class="img-fluid partner-logo" alt="Partner">
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <div class="partner-box shadow-sm p-3 bg-white rounded-3">
          <img src="assets/partner/partner5.jpg" class="img-fluid partner-logo" alt="Partner">
        </div>
      </div>

      <div class="col-6 col-md-4 col-lg-2">
        <div class="partner-box shadow-sm p-3 bg-white rounded-3">
          <img src="assets/partner/partner6.jpg" class="img-fluid partner-logo" alt="Partner">
        </div>
      </div>

    </div>
  </div>
</section>

<!-- FOOTER -->
@include('landing.components.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Navbar scroll effect
  const navbar = document.getElementById("mainNavbar");
  window.addEventListener("scroll", () => {
    navbar.classList.toggle("scrolled", window.scrollY > 50);
  });
</script>

<!-- Wa -->
<!-- SWIPER JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
  var swiper = new Swiper(".gallerySwiper", {
    slidesPerView: 3,
    spaceBetween: 20,
    loop: true,
    navigation: {
      nextEl: ".gallery-next",
      prevEl: ".gallery-prev",
    },
    breakpoints: {
      0: { slidesPerView: 1 },
      576: { slidesPerView: 2 },
      992: { slidesPerView: 3 }
    }
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
document.addEventListener("scroll", function () {
    const navbar = document.getElementById("mainNavbar");

    if (window.scrollY > 50) {
        navbar.classList.add("scrolled");
    } else {
        navbar.classList.remove("scrolled");
    }
});
</script>


</body>
</html>
