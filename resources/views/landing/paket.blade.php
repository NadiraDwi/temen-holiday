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

</body>
</html>
