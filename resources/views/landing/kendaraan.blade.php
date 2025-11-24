<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Temen Holiday</title>

  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">
</head>
<body>

<!-- NAVBAR -->
@include('landing.components.header')

<!-- HERO -->
<section class="hero hero-small" style="background-image: url('assets/image/home2.jpeg');">
  <div class="hero-text">
    <h1>Kendaraan</h1>
  </div>
</section>

  <!-- CARD KENDARAAN -->
  <div class="container py-5">

    <div class="text-center mb-4">
    <button class="filter-chip active" data-filter="all">
        Semua
    </button>

    @foreach($categories as $cat)
    <button class="filter-chip" data-filter="{{ $cat->id_category }}">
        {{ $cat->kategori }}
    </button>
    @endforeach
  </div>

  <div class="row g-4" id="vehicleContainer">

    @foreach($vehicles as $v)
    <div class="col-md-4 vehicle-item" data-category="{{ $v->id_kategori }}">
      <div class="card shadow-sm">

        <img src="{{ asset('storage/kendaraan/' . $v->gambar) }}"
            class="card-img-top card-img-fixed"
            alt="{{ $v->nama_kendaraan }}">

        <div class="card-body">
          <h5 class="card-title fw-bold">{{ $v->nama_kendaraan }}</h5>

          @if($v->tampilkan_harga)
            <p class="text-muted">Harga: Rp {{ number_format($v->harga,0,',','.') }} / Hari</p>
          @endif

          <a href="#" class="more-link detail-trigger"
            data-nama="{{ $v->nama_kendaraan }}"
            data-harga="{{ $v->harga }}"
            data-kapasitas="{{ $v->kapasitas }}"
            data-fasilitas='@json(explode(",", $v->fasilitas))'
            data-gambar="{{ asset('storage/kendaraan/' . $v->gambar) }}">
            Detail
          </a>
        </div>
      </div>
    </div>
    @endforeach

  </div>
  </div>
</div>

<!-- FOOTER -->
<footer class="footer mt-5 pt-5 pb-4">
  <div class="container">

    <div class="row">

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

      <div class="col-md-4 mb-4">
        <ul class="footer-links">
          <li><a href="#">Passport & Visa</a></li>
          <li><a href="#">Travel Tips</a></li>
          <li><a href="#">World Priority</a></li>
          <li><a href="#">Terms & Conditions</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Career</a></li>
          <li><a href="#">Sitemap</a></li>
        </ul>
      </div>

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

<!-- MODAL DETAIL -->
<div class="modal fade" id="detailModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="modalNama">Detail Kendaraan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="row">

          <div class="col-md-6">
            <img id="modalGambar" src="" class="img-fluid rounded">
          </div>

          <div class="col-md-6">
            <h4 id="modalNama2" class="fw-bold"></h4>

            <p class="mt-2">
              <i class="bi bi-cash-stack text-success me-2"></i>
              <span id="modalHarga" class="fw-semibold"></span>
            </p>

            <p class="mt-3">
              <i class="bi bi-people-fill text-primary me-2"></i>
              Kapasitas:
              <span id="modalKapasitas" class="fw-semibold"></span>
            </p>

            <p class="mt-3">
              <i class="bi bi-card-checklist text-warning me-2"></i>
              Fasilitas:
            </p>
            <ul id="modalFasilitas" class="mb-3"></ul>

            <button class="btn btn-primary w-100 mt-3">Sewa Sekarang</button>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
  // Navbar scroll effect
  const navbar = document.getElementById("mainNavbar");
  window.addEventListener("scroll", () => {
    navbar.classList.toggle("scrolled", window.scrollY > 50);
  });
</script>

<script>
document.querySelectorAll(".detail-trigger").forEach(item => {
    item.addEventListener("click", function(e) {
        e.preventDefault();

        document.getElementById("modalNama").textContent = this.dataset.nama;
        document.getElementById("modalNama2").textContent = this.dataset.nama;
        document.getElementById("modalGambar").src = this.dataset.gambar;

        let harga = parseInt(this.dataset.harga).toLocaleString("id-ID");
        document.getElementById("modalHarga").textContent = "Rp " + harga + " / hari";

        document.getElementById("modalKapasitas").textContent = this.dataset.kapasitas + " orang";

        let fasilitas = JSON.parse(this.dataset.fasilitas);
        let list = document.getElementById("modalFasilitas");
        list.innerHTML = "";
        fasilitas.forEach(f => list.innerHTML += `<li>${f}</li>`);

        new bootstrap.Modal(document.getElementById("detailModal")).show();
    });
});
</script>

<script>
document.querySelectorAll(".filter-chip").forEach(btn => {
    btn.addEventListener("click", function() {

        document.querySelectorAll(".filter-chip").forEach(b => b.classList.remove("active"));
        this.classList.add("active");

        let filter = this.dataset.filter;

        document.querySelectorAll(".vehicle-item").forEach(item => {
            if(filter === "all" || item.dataset.category === filter){
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });

    });
});
</script>

</body>
</html>
