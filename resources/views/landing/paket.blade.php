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
    <h1>Paket Wisata</h1>
  </div>
</section>

<!-- CARD KENDARAAN -->
<div class="container py-5">

  <div class="row g-4">

    <!-- Card 1 -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <img src="{{ asset('assets/image/wisata1.jpeg') }}" class="card-img-top card-img-fixed" alt="Mobil">
        <div class="card-body">
          <h5 class="card-title fw-bold">Coban Rondo</h5>
          <p class="text-muted">Harga: Rp 450.000 / Hari</p>
          <a href="javascript:void(0)" 
            class="more-link paket-trigger"
            data-gambar="{{ asset('assets/image/wisata1.jpeg') }}"
            data-nama="Coban Rondo"
            data-kategori="Wisata"
            data-deskripsi="Paket wisata alam ke Coban Rondo..."
            data-fasilitas='["Transportasi", "Tiket Masuk", "Air Mineral"]'
            data-destinasi='["Air Terjun Coban Rondo", "Taman Labirin"]'
            data-kapasitas="6"
            data-harga="450000">
            Detail
          </a>
        </div>
      </div>
    </div>

    <!-- Card 2 -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <img src="{{ asset('assets/image/wisata2.jpeg') }}" class="card-img-top card-img-fixed" alt="Mobil">
        <div class="card-body">
          <h5 class="card-title fw-bold">Santerra</h5>
          <p class="text-muted">Harga: Rp 450.000 / Hari</p>

          <a href="javascript:void(0)" 
            class="more-link paket-trigger"
            data-gambar="{{ asset('assets/image/wisata2.jpeg') }}"
            data-nama="Santerra"
            data-kategori="Wisata"
            data-deskripsi="Paket wisata Santerra..."
            data-fasilitas='["Transportasi", "Tiket Masuk", "Air Mineral"]'
            data-destinasi='["Santerra Flower Garden"]'
            data-kapasitas="6"
            data-harga="450000">
            Detail
          </a>
        </div>
      </div>
    </div>

    <!-- Card 3 -->
    <div class="col-md-4">
      <div class="card shadow-sm">
        <img src="{{ asset('assets/image/wisata3.jpeg') }}" class="card-img-top card-img-fixed" alt="Mobil">
        <div class="card-body">
          <h5 class="card-title fw-bold">Kampung Warna Warni</h5>
          <p class="text-muted">Harga: Rp 450.000 / Hari</p>

          <a href="javascript:void(0)" 
            class="more-link paket-trigger"
            data-gambar="{{ asset('assets/image/wisata3.jpeg') }}"
            data-nama="Kampung Warna Warni"
            data-kategori="Wisata"
            data-deskripsi="Wisata kampung warna warni..."
            data-fasilitas='["Transportasi", "Tiket Masuk"]'
            data-destinasi='["Jembatan Kaca", "Kampung Warna Warni"]'
            data-kapasitas="6"
            data-harga="450000">
            Detail
          </a>
        </div>
      </div>
    </div>

    <!-- Lanjutkan card ke-4,5,6 persis seperti punyamu... -->
    <!-- TIDAK SAYA UBAH -->

  </div>
</div>

{{-- FOOTER --}}
@include('landing.components.footer')

<!-- MODAL DETAIL -->
<div class="modal fade" id="detailModal" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold" id="modalNama"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body pt-0">
        <div class="row g-4">

          <!-- Gambar kiri -->
          <div class="col-md-5">
            <img id="modalGambar" class="img-fluid rounded shadow-sm"
                 style="height: 300px; width: 100%; object-fit: cover;">
          </div>

          <!-- Kanan -->
          <div class="col-md-7">
            <h3 id="modalNama2" class="fw-bold mb-1"></h3>
            <div class="d-flex align-items-center mb-3">
              <span class="me-3 d-flex align-items-center">
                <i class="bi bi-cash-stack text-success me-2"></i>
                <span id="modalHarga" class="fw-bold"></span>
              </span>
              <span class="d-flex align-items-center">
                <i class="bi bi-people text-primary me-2"></i>
                <span id="modalKapasitas" class="fw-bold"></span>
              </span>
            </div>

            <div class="row g-4">
              <div class="col-md-6 border-end">
                <h5 class="fw-semibold mb-2">
                  <i class="bi bi-tools me-2"></i>Fasilitas
                </h5>
                <ul id="modalFasilitas" class="list-unstyled ps-3"></ul>
              </div>

              <div class="col-md-6">
                <h5 class="fw-semibold mb-2">
                  <i class="bi bi-geo-alt me-2"></i>Destinasi
                </h5>
                <ul id="modalDestinasi" class="list-unstyled ps-3"></ul>
              </div>
            </div>

            <button class="btn btn-primary w-100 mt-4">Sewa Sekarang</button>

          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

{{-- SCRIPT ASLIMU — TIDAK diubah --}}
<script>
// NAVBAR SCROLL
const navbar = document.getElementById("mainNavbar");
window.addEventListener("scroll", () => {
  if (window.scrollY > 50) navbar.classList.add("scrolled");
  else navbar.classList.remove("scrolled");
});

// MODAL DETAIL
function showDetail(data) {
  document.getElementById("modalGambar").src = data.gambar;
  document.getElementById("modalNama").textContent = data.nama;
  document.getElementById("modalNama2").textContent = data.nama;
  document.getElementById("modalHarga").textContent = "Rp " + data.harga;
  document.getElementById("modalKapasitas").textContent = data.kapasitas + " orang";

  let fasilitasList = document.getElementById("modalFasilitas");
  fasilitasList.innerHTML = "";
  data.fasilitas.forEach(f => fasilitasList.innerHTML += `<li>${f}</li>`);

  let destinasiList = document.getElementById("modalDestinasi");
  destinasiList.innerHTML = "";
  data.destinasi.forEach(d => destinasiList.innerHTML += `<li>${d}</li>`);

  new bootstrap.Modal(document.getElementById("detailModal")).show();
}

document.querySelectorAll(".paket-trigger").forEach(item => {
    item.addEventListener("click", function () {
        const data = {
            gambar: this.dataset.gambar,
            nama: this.dataset.nama,
            kategori: this.dataset.kategori,
            deskripsi: this.dataset.deskripsi,
            kapasitas: this.dataset.kapasitas,
            harga: this.dataset.harga,
            fasilitas: JSON.parse(this.dataset.fasilitas),
            destinasi: JSON.parse(this.dataset.destinasi)
        };
        showDetail(data);
    });
});
</script>

</body>
</html>
