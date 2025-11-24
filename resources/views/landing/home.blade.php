<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Temen Holiday</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">
</head>
<body>

<!-- NAVBAR -->
@include('landing.components.header')

<!-- HERO CAROUSEL -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">

    <!-- SLIDE 1 -->
    <div class="carousel-item active">
      <div class="hero d-flex align-items-center justify-content-center" style="background-image:url('assets/image/home1.jpeg');">
        <div class="hero-content text-center">
          <h1 class="hero-title">Welcome to Temen Holiday</h1>
          <p class="hero-subtitle">"As Close As Friends, As Warm As Family"</p>

          <div class="hero-search">
            <input type="text" class="form-control search-input" placeholder="Cari destinasi atau paket tour...">
            <i class="search-icon bi bi-search"></i>
          </div>
        </div>
      </div>
    </div>

    <!-- SLIDE 2 -->
    <div class="carousel-item">
      <div class="hero d-flex align-items-center justify-content-center" style="background-image:url('assets/image/home2.jpeg');">
        <div class="hero-content text-center">
          <h1 class="hero-title">Welcome to Temen Holiday</h1>
          <p class="hero-subtitle">"As Close As Friends, As Warm As Family"</p>

          <div class="hero-search">
            <input type="text" class="form-control search-input" placeholder="Cari destinasi atau paket tour...">
            <i class="search-icon bi bi-search"></i>
          </div>
        </div>
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

      <!-- ULASAN 1 -->
      <div class="col-md-4">
        <div class="p-4 shadow-sm rounded bg-white h-100">
          <div class="d-flex align-items-center mb-3">
            <img src="{{ asset('assets/image/avatar.jpg') }}" class="rounded-circle me-3" width="50" height="50">
            <div>
              <h6 class="fw-bold mb-0">Rizky Saputra</h6>
              <div class="text-warning">
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-half"></i>
              </div>
            </div>
          </div>
          <p class="text-muted">
            Pelayanannya ramah dan kendaraan nyaman banget. Perjalanan jadi lebih menyenangkan!
          </p>
        </div>
      </div>

      <!-- ULASAN 2 -->
      <div class="col-md-4">
        <div class="p-4 shadow-sm rounded bg-white h-100">
          <div class="d-flex align-items-center mb-3">
            <img src="{{ asset('assets/image/avatar.jpg') }}" class="rounded-circle me-3" width="50" height="50">
            <div>
              <h6 class="fw-bold mb-0">Dewi Lestari</h6>
              <div class="text-warning">
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
              </div>
            </div>
          </div>
          <p class="text-muted">
            Driver profesional dan tepat waktu. Sangat rekomendasi untuk perjalanan keluarga!
          </p>
        </div>
      </div>

      <!-- ULASAN 3 -->
      <div class="col-md-4">
        <div class="p-4 shadow-sm rounded bg-white h-100">
          <div class="d-flex align-items-center mb-3">
            <img src="{{ asset('assets/image/avatar.jpg') }}" class="rounded-circle me-3" width="50" height="50">
            <div>
              <h6 class="fw-bold mb-0">Andi Pratama</h6>
              <div class="text-warning">
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star-fill"></i>
                <i class="bi bi-star"></i>
              </div>
            </div>
          </div>
          <p class="text-muted">
            Harga terjangkau dengan kualitas terbaik. Next time pasti order lagi!
          </p>
        </div>
      </div>

    </div>

  </div>
</section>

<!-- FOOTER -->
<footer class="footer mt-5 pt-5 pb-4">
  <div class="container">
    <div class="row">

      <!-- Contact -->
      <div class="col-md-4 mb-4">
        <h4 class="footer-brand">Temen Holiday</h4>

        <p class="mb-1 fw-bold">CALL US</p>
        <p class="text-light">(021) 23509999</p>

        <p class="mb-1 fw-bold">MAIL US</p>
        <p class="text-light">hello@temenholiday.com</p>

        <p class="mb-2 fw-bold">FOLLOW US</p>
        <div class="d-flex gap-3">
          <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
          <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
          <a href="#" class="social-icon"><i class="bi bi-tiktok"></i></a>
        </div>
      </div>

      <!-- Links -->
      <div class="col-md-4 mb-4">
        <ul class="footer-links">
          <li><a href="#">Passport & Visa</a></li>
          <li><a href="#">Travel Tips</a></li>
          <li><a href="#">Terms & Conditions</a></li>
          <li><a href="#">Career</a></li>
        </ul>
      </div>

      <!-- Newsletter -->
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold mb-3 text-light">SUBSCRIBE OUR NEWSLETTER</h5>

        <form>
          <input type="email" class="form-control mb-3 newsletter-input" placeholder="Your Email Address" />
          <button class="btn btn-primary w-100 fw-bold">SUBSCRIBE →</button>
        </form>

        <small class="text-light d-block mt-2">
          By subscribing, I confirm that I have read and accept the Privacy Policy.
        </small>
      </div>

    </div>
    <hr class="footer-line">
    <p class="text-center text-light mt-3 mb-0">
      © 2025 Temen Holiday. All Rights Reserved.
    </p>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Navbar scroll effect
  const navbar = document.getElementById("mainNavbar");
  window.addEventListener("scroll", () => {
    navbar.classList.toggle("scrolled", window.scrollY > 50);
  });
</script>

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

</body>
</html>
