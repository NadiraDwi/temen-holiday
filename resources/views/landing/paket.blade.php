<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Temen Holiday</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">
</head>
<body>

@include('landing.components.header')

<section class="hero hero-small" style="background-image: url('assets/image/home1.jpeg');">
  <div class="hero-text">
    <h1>Paket Wisata</h1>
  </div>
</section>

<div class="container py-5">

  <div class="row g-4">

    @foreach ($trips as $trip)
    <div class="col-md-4">
      <div class="card shadow-sm">

        <img src="{{ asset('storage/opentrip/' . $trip->cover_image) }}" 
             class="card-img-top card-img-fixed" alt="Gambar Trip">

        <div class="card-body">
          <h5 class="card-title fw-bold">{{ $trip->title }}</h5>

          <p class="text-muted">
            Harga: 
            {{ $trip->price_label ? $trip->price_label : 'Rp ' . number_format($trip->price) }}
          </p>

          {{-- BUTTON ARAH KE HALAMAN DETAIL BARU --}}
          <a href="{{ route('paket.detail', $trip->id) }}" class="more-link">
            Detail
          </a>

        </div>
      </div>
    </div>
    @endforeach

  </div>
</div>

@include('landing.components.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
