<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Temen Holiday</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

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
        <div class="col-md-4">
          <div class="p-4 shadow-sm rounded bg-white h-100">
            
            <h5 class="fw-bold mb-2">{{ $t->nama_user }}</h5>

            <div class="text-warning mb-2">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $t->rating)
                        <i class="bi bi-star-fill"></i>
                    @else
                        <i class="bi bi-star"></i>
                    @endif
                @endfor
            </div>

            <p class="text-muted">{{ $t->pesan }}</p>

          </div>
        </div>
      @endforeach

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

</body>
</html>
