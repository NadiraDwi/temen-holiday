<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Temen Holiday</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  {{-- CSS LANDING --}}
  <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">
</head>
<body>

{{-- HEADER / NAVBAR --}}
@include('landing.components.header')

<!-- HERO KECIL -->
<section class="hero hero-small" style="background-image: url('assets/image/home1.jpeg');">
  <div class="hero-text">
    <h1>Testimoni</h1>
  </div>
</section>

<!-- TESTIMONI SECTION -->
<div class="container py-5">

  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
      <h2 class="section-title-left mb-0">Apa Kata Mereka?</h2>

      <a href="#" class="btn btn-primary px-4">
        Berikan Ulasanmu
      </a>
    </div>

  <div class="row g-4">

    <!-- CARD 1 -->
    <div class="col-md-4">
      <div class="p-4 shadow-sm rounded bg-white h-100">
        <h5 class="fw-bold mb-2">Rizky Saputra</h5>
        <div class="text-warning mb-2">
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-half"></i>
        </div>
        <p class="text-muted">
          Pelayanannya ramah dan kendaraan nyaman banget. Perjalanan jadi lebih menyenangkan!
        </p>
      </div>
    </div>

    <!-- CARD 2 -->
    <div class="col-md-4">
      <div class="p-4 shadow-sm rounded bg-white h-100">
        <h5 class="fw-bold mb-2">Dewi Lestari</h5>
        <div class="text-warning mb-2">
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
        </div>
        <p class="text-muted">
          Driver profesional dan tepat waktu. Sangat rekomendasi untuk perjalanan keluarga!
        </p>
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="col-md-4">
      <div class="p-4 shadow-sm rounded bg-white h-100">
        <h5 class="fw-bold mb-2">Andi Pratama</h5>
        <div class="text-warning mb-2">
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star"></i>
        </div>
        <p class="text-muted">
          Harga terjangkau dengan kualitas terbaik. Next time pasti order lagi!
        </p>
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="col-md-4">
      <div class="p-4 shadow-sm rounded bg-white h-100">
        <h5 class="fw-bold mb-2">Nanad</h5>
        <div class="text-warning mb-2">
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star-fill"></i>
          <i class="bi bi-star"></i>
        </div>
        <p class="text-muted">
          Harga terjangkau dengan kualitas terbaik. Next time pasti order lagi!
        </p>
      </div>
    </div>

  </div>

</div>

{{-- FOOTER --}}
@include('landing.components.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- SCRIPT ASLI --}}
<script>
const navbar = document.getElementById("mainNavbar");
window.addEventListener("scroll", () => {
  if (window.scrollY > 50) navbar.classList.add("scrolled");
  else navbar.classList.remove("scrolled");
});
</script>

</body>
</html>
