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
    /* Biar modal nggak terlalu tinggi */
    .modal-body {
      max-height: 60vh;
      overflow-y: auto;
    }

    /* Lebar modal lebih kecil & elegan */
    .modal-dialog {
      max-width: 450px;
    }

    .star {
      font-size: 32px;
      color: #ccc;
      cursor: pointer;
      transition: 0.2s;
    }

    .star.hover,
    .star.selected {
      color: #f4b400; /* warna gold ala Google Maps */
    }
  </style>

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

<!-- ============================================================
     MODAL INPUT TESTIMONI UNTUK USER
=============================================================== -->
<div class="modal fade" id="modalCreateTestimoni" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <form action="{{ route('testimoni.store') }}" method="POST">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title">Tulis Ulasanmu</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <div class="star-rating d-flex justify-content-center gap-1">
              <i class="bi bi-star star" data-value="1"></i>
              <i class="bi bi-star star" data-value="2"></i>
              <i class="bi bi-star star" data-value="3"></i>
              <i class="bi bi-star star" data-value="4"></i>
              <i class="bi bi-star star" data-value="5"></i>
            </div>

            <!-- Hidden input to store real value -->
            <input type="hidden" name="rating" id="ratingInput" required>
          </div>

          <div class="mb-3">
            <input type="text" name="nama_user" class="form-control" placeholder="Nama kamu" required>
          </div>

          <div class="mb-3">
            <textarea name="pesan" class="form-control" rows="4" placeholder="Tulis pengalamanmu..." required></textarea>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Kirim</button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- TESTIMONI SECTION -->
<div class="container py-5">

  <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
      <h2 class="section-title-left mb-0">Apa Kata Mereka?</h2>

      <a href="#" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#modalCreateTestimoni">
          Berikan Ulasanmu
      </a>
    </div>

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

<script>
  const stars = document.querySelectorAll('.star');
  const ratingInput = document.getElementById('ratingInput');

  stars.forEach((star, index) => {

    // Hover effect
    star.addEventListener('mouseover', () => {
      stars.forEach((s, i) => {
        s.classList.toggle('hover', i <= index);
      });
    });

    // Remove hover when not active
    star.addEventListener('mouseout', () => {
      stars.forEach(s => s.classList.remove('hover'));
    });

    // Click = set rating
    star.addEventListener('click', () => {
      ratingInput.value = star.dataset.value;

      stars.forEach((s, i) => {
        s.classList.toggle('selected', i < star.dataset.value);
      });
    });

  });
</script>

</body>
</html>
