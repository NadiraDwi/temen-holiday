<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Temen Holiday</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">
</head>
<body>

<!-- NAVBAR -->
@include('landing.components.header')

<!-- HERO CAROUSEL -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <div class="hero d-flex align-items-center" style="background-image:url('https://picsum.photos/1200/600?travel1');">
        <div class="hero-text">
          <h1>Welcome to Temen Holiday</h1>
          <p>As Warm As Family</p>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <div class="hero d-flex align-items-center" style="background-image:url('https://picsum.photos/1200/600?travel2');">
        <div class="hero-text">
          <h1>Welcome to Temen Holiday</h1>
          <p>As Warm As Family</p>
        </div>
      </div>
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<!-- ABOUT SECTION -->
<section class="py-5 container" id="about">
  <div class="row align-items-center">
    <div class="col-md-6">
      <h2 class="mb-4 fw-bold">About Temen Holiday</h2>
      <p class="text-muted">
        Temen Holiday adalah layanan travel terpercaya dengan pelayanan berkualitas dan rasa kekeluargaan. 
        Kami menyediakan berbagai pilihan kendaraan, paket wisata, serta layanan terbaik untuk perjalanan Anda.
      </p>
    </div>

    <div class="col-md-6">
      <div class="ratio ratio-16x9 shadow rounded overflow-hidden">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.9732430914682!2d112.67068467405147!3d-7.897864078579777!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd62b271546bb3d%3A0xcbf3f116ff701fb3!2sCV%20TIGA%20PUTRA%20SINGHASARI%20(Temen%20Holiday)!5e0!3m2!1sid!2sid!4v1763436949363!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>
  </div>
</section>

<!-- KENDARAAN -->
<section class="py-5 bg-light" id="kendaraan">
  <div class="container">
    <h2 class="text-center mb-4 fw-bold">Kendaraan Kami</h2>

    <div class="row g-4">

      <div class="col-md-4">
        <a href="{{ url('/kendaraan') }}" class="text-decoration-none">
          <div class="card h-100 shadow-sm card-hover">
            <div class="img-wrapper">
              <img src="{{ asset('assets/image/mobil1.jpeg') }}" class="card-img-top card-img-fixed">
            </div>
            <div class="card-body">
              <h5 class="fw-bold text-dark">Avanza</h5>
              <p class="text-muted">Rp 450.000 / Hari</p>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="{{ url('/kendaraan') }}" class="text-decoration-none">
          <div class="card h-100 shadow-sm card-hover">
            <div class="img-wrapper">
              <img src="{{ asset('assets/image/mobil2.jpeg') }}" class="card-img-top card-img-fixed">
            </div>
            <div class="card-body">
              <h5 class="fw-bold text-dark">Innova</h5>
              <p class="text-muted">Rp 650.000 / Hari</p>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-4">
        <a href="{{ url('/kendaraan') }}" class="text-decoration-none">
          <div class="card h-100 shadow-sm card-hover">
            <div class="img-wrapper">
              <img src="{{ asset('assets/image/mobil3.jpeg') }}" class="card-img-top card-img-fixed">
            </div>
            <div class="card-body">
              <h5 class="fw-bold text-dark">Hiace</h5>
              <p class="text-muted">Rp 1.200.000 / Hari</p>
            </div>
          </div>
        </a>
      </div>

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

</body>
</html>
