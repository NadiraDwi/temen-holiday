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
<section class="hero hero-small" style="background-image: url('https://picsum.photos/1200/600?travel1');">
  <div class="hero-text">
    <h1>Kendaraan</h1>
  </div>
</section>

<!-- CARD KENDARAAN -->
<div class="container py-5">
  <h2 class="text-center fw-bold mb-4">Pilihan Kendaraan</h2>

  <div class="row g-4">

    <!-- CARD: Toyota Avanza -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <img src="{{ asset('assets/image/mobil4.jpeg') }}" class="card-img-top card-img-fixed" alt="Toyota Avanza">
        <div class="card-body">
          <h5 class="card-title fw-bold">Toyota Avanza</h5>
          <p class="text-muted">Harga: Rp 450.000 / Hari</p>
          <a href="#" class="more-link detail-trigger"
            data-nama="Toyota Avanza"
            data-harga="450000"
            data-kapasitas="7"
            data-fasilitas='["AC","Audio","Bagasi Sedang"]'
            data-gambar="{{ asset('assets/image/mobil4.jpeg') }}">
            Detail
          </a>
        </div>
      </div>
    </div>

    <!-- CARD: Toyota Hiace -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <img src="{{ asset('assets/image/mobil5.jpeg') }}" class="card-img-top card-img-fixed" alt="Toyota Hiace">
        <div class="card-body">
          <h5 class="card-title fw-bold">Toyota Hiace</h5>
          <p class="text-muted">Harga: Rp 450.000 / Hari</p>
          <a href="#" class="more-link detail-trigger"
            data-nama="Toyota Hiace"
            data-harga="450000"
            data-kapasitas="12"
            data-fasilitas='["AC","Audio","Reclining Seat","Bagasi Luas"]'
            data-gambar="{{ asset('assets/image/mobil5.jpeg') }}">
            Detail
          </a>
        </div>
      </div>
    </div>

    <!-- CARD: Elf Long -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <img src="{{ asset('assets/image/mobil6.jpeg') }}" class="card-img-top card-img-fixed" alt="Elf Long">
        <div class="card-body">
          <h5 class="card-title fw-bold">Elf Long</h5>
          <p class="text-muted">Harga: Rp 450.000 / Hari</p>
          <a href="#" class="more-link detail-trigger"
            data-nama="Elf Long"
            data-harga="450000"
            data-kapasitas="16"
            data-fasilitas='["AC","Audio","Reclining Seat","Bagasi Besar"]'
            data-gambar="{{ asset('assets/image/mobil6.jpeg') }}">
            Detail
          </a>
        </div>
      </div>
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

</body>
</html>
