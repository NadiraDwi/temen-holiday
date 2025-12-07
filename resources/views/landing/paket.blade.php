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

<section class="hero hero-small" style="background-image: url('{{ asset('assets/image/home1.jpeg') }}');">
  <div class="hero-text">
    <h1>Paket Wisata</h1>
  </div>
</section>

<div class="container py-5">

  <div class="row g-4">

    @foreach ($paket as $item)
    <div class="col-md-4">
      <div class="card shadow-sm">

        {{-- GAMBAR COVER --}}
        <img 
          src="{{ asset('storage/' . $item->images[0]) }}" 
          class="card-img-top card-img-fixed"
          alt="Gambar Paket">

        <div class="card-body">

          {{-- TITLE --}}
          <h5 class="card-title fw-bold">{{ $item->title }}</h5>

          {{-- HARGA --}}
          <p class="text-muted">
            Harga:
            Rp {{ number_format($item->price, 0, ',', '.') }}
          </p>

          {{-- BADGE JENIS PAKET --}}
          <span class="badge bg-primary mb-2">
            {{ strtoupper($item->type) }}
          </span>

          {{-- BUTTON DETAIL OTOMATIS --}}
          <a 
            href="{{ $item->type === 'opentrip'
                    ? route('opentrip.detail', $item->id)
                    : route('wisata.user.detail', $item->id) }}"
            class="more-link d-block mt-2">
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

<!-- Swiper -->
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

</body>
</html>
