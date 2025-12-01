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
          <div class="vehicle-2-card">

              <div class="vehicle-2-img-wrapper">
                  <img src="{{ asset('storage/kendaraan/' . $v->gambar) }}" alt="{{ $v->nama_kendaraan }}">
              </div>

              <div class="vehicle-2-body">
                  <h5 class="vehicle-2-title">{{ $v->nama_kendaraan }}</h5>

                  <p class="vehicle-2-capacity">
                      <i class="bi bi-people-fill text-primary me-1"></i>
                      Kapasitas: {{ $v->kapasitas }} orang
                  </p>

                  <button 
                      class="btn btn-primary vehicle-2-btn detail-trigger"
                      data-nama="{{ $v->nama_kendaraan }}"
                      data-id="{{ $v->id_vehicle }}"
                      data-harga="{{ $v->harga }}"
                      data-kapasitas="{{ $v->kapasitas }}"
                      data-fasilitas='@json(explode(",", $v->fasilitas))'
                      data-gambar="{{ asset('storage/kendaraan/' . $v->gambar) }}"
                  >
                      Detail
                  </button>

              </div>
          </div>
      </div>
      @endforeach

  </div> <!-- row -->

  </div>
</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="detailModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Detail Kendaraan</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">

        <div class="row">
          <div class="col-md-5">
            <img id="detailGambar" class="img-fluid rounded" alt="">
          </div>

          <div class="col-md-7">

            <h4 id="detailNama"></h4>

            <p class="mt-2">
              <i class="bi bi-people-fill text-primary"></i>
              <span id="detailKapasitas"></span> orang
            </p>

            <p class="mt-2 fw-semibold">Fasilitas:</p>
            <ul id="detailFasilitas"></ul>

            <p class="mt-3 h5 text-success fw-bold">
              Harga: <span id="detailHarga"></span>
            </p>

          </div>
        </div>

      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <a id="btnPesanSekarang" href="#" class="btn btn-primary">Pesan Sekarang</a>
      </div>

    </div>
  </div>
</div>

<!-- FOOTER -->
@include('landing.components.footer')

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

<script>
document.querySelectorAll(".detail-trigger").forEach(btn => {
    btn.addEventListener("click", function () {

        let nama = this.dataset.nama;
        let gambar = this.dataset.gambar;
        let harga = this.dataset.harga;
        let kapasitas = this.dataset.kapasitas;
        let fasilitas = JSON.parse(this.dataset.fasilitas);
        let id = this.dataset.id;

        document.getElementById("detailNama").textContent = nama;
        document.getElementById("detailGambar").src = gambar;

        document.getElementById("detailHarga").textContent =
            "Rp " + Number(harga).toLocaleString("id-ID") + " / Hari";

        document.getElementById("detailKapasitas").textContent = kapasitas;

        let ul = document.getElementById("detailFasilitas");
        ul.innerHTML = "";
        fasilitas.forEach(f => {
            ul.innerHTML += `<li>${f}</li>`;
        });

        document.getElementById("btnPesanSekarang").href = "{{ url('/pesan') }}/" + id;

        new bootstrap.Modal(document.getElementById("detailModal")).show();
    });
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
