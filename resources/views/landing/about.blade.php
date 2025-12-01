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

  <style>
    /* ✅ Garis biru di bawah judul */
    .section-title {
      position: relative;
      display: inline-block;
      padding-bottom: 8px;
    }
    .section-title::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: 0;
      width: 60px;
      height: 3px;
      background: #007bff;
      border-radius: 2px;
    }
  </style>

</head>
<body>

{{-- HEADER --}}
@include('landing.components.header')

<!-- HERO -->
<section class="hero hero-small" style="background-image: url('assets/image/home1.jpeg');">
  <div class="hero-text">
    <h1>Tentang Kami</h1>
  </div>
</section>

<!-- ================= SECTION 1: ABOUT ================= -->
<section class="py-5 container">
  <div class="row align-items-start">
    <div class="col-md-6 mb-4 mb-md-0">
      <h2 class="fw-bold section-title mb-3">About Temen Holiday</h2>
      <p class="text-muted">
        Temen Holiday adalah layanan travel dan transportasi wisata yang hadir dengan satu tujuan sederhana: membuat setiap perjalanan terasa senyaman pergi bersama teman sendiri. Kami percaya bahwa liburan bukan sekadar berpindah tempat, tetapi tentang pengalaman, kebersamaan, dan momen yang layak dikenang.
      </p>
      <p class="text-muted">
        Berawal dari kebutuhan banyak orang akan perjalanan yang aman, fleksibel, dan tetap terjangkau, Temen Holiday dibangun untuk menjadi solusi transportasi dan wisata yang ramah, profesional, dan penuh kehangatan. Dengan semangat “As Close As Friends, As Warm As Family”, kami ingin setiap pelanggan merasa diperlakukan bukan sebagai penumpang—melainkan sebagai teman perjalanan.
      </p>
    </div>

    <div class="col-md-6">
        <img src="assets/image/home2.jpeg" class="img-fluid rounded shadow about-img" alt="Temen Holiday">
    </div>

  </div>
</section>

<!-- ================= SECTION 2: VISI & MISI ================= -->
<section class="py-5 bg-light">
  <div class="container text-center">
    <h2 class="fw-bold section-title-center mb-5">Visi & Misi</h2>

    <div class="row g-4">
      <div class="col-md-6">
        <div class="card shadow border-0 h-100">
          <div class="card-body">
            <h4 class="fw-bold mb-3">Visi</h4>
            <p class="text-muted">
              Menjadi layanan travel terbaik yang memberikan kenyamanan, keamanan, dan pengalaman perjalanan terbaik bagi setiap pelanggan.
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="card shadow border-0 h-100">
          <div class="card-body">
            <h4 class="fw-bold mb-3">Misi</h4>
            <p class="text-muted">
              Memberikan pelayanan profesional, menyediakan armada berkualitas, dan menjadi partner perjalanan yang dapat diandalkan kapanpun dan dimanapun.
            </p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ================= SECTION 3: MAPS ================= -->
<section class="py-5 container">
  <h2 class="fw-bold section-title mb-4">Lokasi Kami</h2>

  <div class="ratio ratio-16x9 shadow rounded overflow-hidden">
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3951.9732430914682!2d112.67068467405147!3d-7.897864078579777!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd62b271546bb3d%3A0xcbf3f116ff701fb3!2sCV%20TIGA%20PUTRA%20SINGHASARI%20(Temen%20Holiday)!5e0!3m2!1sid!2sid!4v1763436949363!5m2!1sid!2sid"
      width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy">
    </iframe>
  </div>
</section>

{{-- FOOTER --}}
@include('landing.components.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// NAVBAR SCROLL
const navbar = document.getElementById("mainNavbar");
window.addEventListener("scroll", () => {
  if (window.scrollY > 50) navbar.classList.add("scrolled");
  else navbar.classList.remove("scrolled");
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
