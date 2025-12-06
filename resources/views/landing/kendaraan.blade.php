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
<style>
  #detailCarousel .carousel-item img {
    height: 300px;            /* fixed height */
    width: 100%;
    object-fit: cover;        /* biar rapi tidak gepeng */
    border-radius: 10px;
}

  /* Agar collapse filter lebih smooth */
#filterSidebar.collapsing {
  transition: height 0.25s ease;
}

/* Jarak lebih lega untuk mobile */
@media (max-width: 767px) {
  .vehicle-item {
    margin-bottom: 20px;
  }

  .filter-icon-mobile {
      padding: 6px 8px;
      border-radius: 10px;
      background: #f5f5f5;
      transition: 0.2s;
  }

  .filter-icon-mobile:active {
      opacity: 0.6;
  }

  .filter-icon-mobile:hover {
      background: #e9e9e9;
  }

}

</style>
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

  <div class="row">

  <!-- ICON FILTER MOBILE (KANAN ATAS) -->
  <div class="d-md-none mb-2 d-flex justify-content-end">
    <i class="bi bi-funnel filter-icon-mobile" 
      data-bs-toggle="collapse" 
      data-bs-target="#filterSidebar"
      style="font-size: 26px; color: #8c8c8c; cursor: pointer;">
    </i>
  </div>

  <!-- FILTER SIDEBAR -->
  <div class="col-md-3 mb-4">

    <!-- WRAP DALAM COLLAPSE (MOBILE) -->
    <div id="filterSidebar" class="collapse d-md-block">

      <div class="card p-3 shadow-sm">

        <h5 class="mb-3">Filter</h5>

        <!-- FILTER KATEGORI -->
        <p class="fw-semibold">Kategori</p>
        @foreach($categories as $cat)
        <div class="form-check mb-1">
          <input class="form-check-input filter-kategori" type="checkbox" value="{{ $cat->id_category }}">
          <label class="form-check-label">{{ $cat->kategori }}</label>
        </div>
        @endforeach

        <hr>

        <!-- FILTER KAPASITAS -->
        <p class="fw-semibold">Kapasitas</p>

        <div class="form-check">
          <input type="radio" name="kapasitas" class="form-check-input filter-kapasitas" value="4">
          <label class="form-check-label">≤ 4 orang</label>
        </div>

        <div class="form-check">
          <input type="radio" name="kapasitas" class="form-check-input filter-kapasitas" value="14">
          <label class="form-check-label">≤ 14 orang</label>
        </div>

        <div class="form-check">
          <input type="radio" name="kapasitas" class="form-check-input filter-kapasitas" value="15">
          <label class="form-check-label">> 14 orang</label>
        </div>

        <button id="resetFilter" class="btn btn-secondary btn-sm mt-3">Reset Filter</button>

      </div>

    </div> <!-- END COLLAPSE -->
  </div> <!-- END COL-MD-3 -->

  <!-- DAFTAR KENDARAAN -->
  <div class="col-md-9">
    <div class="row g-4" id="vehicleContainer">

      @foreach($vehicles as $v)
      <div class="col-md-4 vehicle-item" 
           data-category="{{ $v->id_kategori }}"
           data-kapasitas="{{ $v->kapasitas }}">

        <div class="vehicle-2-card">
          <div class="vehicle-2-img-wrapper">
            <img 
              src="{{ asset('storage/' . $v->images[0]) }}" 
              class="card-img-top card-img-fixed"
              alt="Gambar Kendaraan">
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
                data-gambar='@json(array_map(fn($img) => asset("storage/" . $img), $v->images))'>
                Detail
            </button>

          </div>
        </div>
      </div>
      @endforeach

    </div>
  </div>

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

            <!-- CAROUSEL -->
            <div id="detailCarousel" class="carousel slide" data-bs-ride="carousel">

              <div class="carousel-indicators" id="detailIndicators"></div>

              <div class="carousel-inner shadow rounded" id="detailCarouselInner"></div>

              <button class="carousel-control-prev" type="button"
                      data-bs-target="#detailCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
              </button>

              <button class="carousel-control-next" type="button"
                      data-bs-target="#detailCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
              </button>

            </div>

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
        let images = JSON.parse(this.dataset.gambar); // ← ARRAY GAMBAR
        let harga = this.dataset.harga;
        let kapasitas = this.dataset.kapasitas;
        let fasilitas = JSON.parse(this.dataset.fasilitas);
        let id = this.dataset.id;

        document.getElementById("detailNama").textContent = nama;

        document.getElementById("detailHarga").textContent =
            "Rp " + Number(harga).toLocaleString("id-ID") + " / Hari";

        document.getElementById("detailKapasitas").textContent = kapasitas;

        // =========================
        // CAROUSEL DINAMIS
        // =========================
        let indicators = document.getElementById("detailIndicators");
        let carouselInner = document.getElementById("detailCarouselInner");

        indicators.innerHTML = "";
        carouselInner.innerHTML = "";

        images.forEach((img, i) => {

            // Indicators
            indicators.innerHTML += `
                <button type="button"
                        data-bs-target="#detailCarousel"
                        data-bs-slide-to="${i}"
                        class="${i === 0 ? 'active' : ''}">
                </button>
            `;

            // Carousel item
            carouselInner.innerHTML += `
                <div class="carousel-item ${i === 0 ? 'active' : ''}">
                    <img src="${img}" class="d-block w-100 trip-image-fixed">
                </div>
            `;
        });

        // =========================
        // FASILITAS
        // =========================
        let ul = document.getElementById("detailFasilitas");
        ul.innerHTML = "";
        fasilitas.forEach(f => {
            ul.innerHTML += `<li>${f}</li>`;
        });

        // =========================
        // LINK PESAN
        // =========================
        document.getElementById("btnPesanSekarang").href =
            "{{ url('/pesan') }}/" + id;

        // =========================
        // BUKA MODAL
        // =========================
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
function applyFilter() {
    let checkedCategories = Array.from(document.querySelectorAll(".filter-kategori:checked"))
        .map(el => el.value);

    let kapasitasFilter = document.querySelector(".filter-kapasitas:checked")
        ? document.querySelector(".filter-kapasitas:checked").value
        : null;

    document.querySelectorAll(".vehicle-item").forEach(item => {
        let itemCategory = item.dataset.category;
        let itemKapasitas = parseInt(item.dataset.kapasitas);

        let showByCategory = 
            checkedCategories.length === 0 || 
            checkedCategories.includes(itemCategory);

        let showByKapasitas = true;

        if (kapasitasFilter) {
            let val = parseInt(kapasitasFilter);

            if (val === 4) {
                showByKapasitas = itemKapasitas <= 4;
            } 
            else if (val === 14) {
                showByKapasitas = itemKapasitas <= 14;
            } 
            else if (val === 15) {
                showByKapasitas = itemKapasitas > 14;
            }
        }

        if (showByCategory && showByKapasitas) {
            item.style.display = "block";
        } else {
            item.style.display = "none";
        }
    });
}

// Event Listener
document.querySelectorAll(".filter-kategori").forEach(el => {
    el.addEventListener("change", applyFilter);
});

document.querySelectorAll(".filter-kapasitas").forEach(el => {
    el.addEventListener("change", applyFilter);
});

// Reset Filter
document.getElementById("resetFilter").addEventListener("click", () => {
    document.querySelectorAll(".filter-kategori").forEach(el => el.checked = false);
    document.querySelectorAll(".filter-kapasitas").forEach(el => el.checked = false);
    applyFilter();
});
</script>


</body>
</html>
