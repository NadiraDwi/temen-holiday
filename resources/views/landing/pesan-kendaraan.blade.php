<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pesan Kendaraan - Temen Holiday</title>

  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <!-- CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">
</head>

<body>

<!-- NAVBAR -->
@include('landing.components.header')

<!-- PAGE CONTENT -->
<div class="container py-5">

    <!-- TITLE CARD -->
    <div class="card shadow-sm p-4 border-0 mb-4">
        <h3 class="fw-bold mb-0">Pesan Kendaraan</h3>
        <p class="text-muted mb-0">Lengkapi data di bawah untuk melakukan pemesanan kendaraan.</p>
    </div>

    <div class="row g-4">

        <!-- RIGHT: DETAIL KENDARAAN -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 overflow-hidden">

                <img src="{{ asset('storage/kendaraan/' . $kendaraan->gambar) }}"
                     style="height: 260px; width:100%; object-fit:cover;">

                <div class="p-4">

                    <h4 class="fw-bold">{{ $kendaraan->nama_kendaraan }}</h4>

                    <p class="text-muted mt-2">
                        <i class="bi bi-people-fill text-primary"></i>
                        Kapasitas: {{ $kendaraan->kapasitas }} orang
                    </p>

                    <p class="h5 fw-bold text-success mt-3">
                        Harga: Rp {{ number_format($kendaraan->harga, 0, ',', '.') }} / Hari
                    </p>

                    <p class="fw-semibold mt-3">Fasilitas:</p>
                    <ul>
                        @foreach(explode(',', $kendaraan->fasilitas) as $f)
                            <li>{{ $f }}</li>
                        @endforeach
                    </ul>

                </div>

            </div>
        </div>

        <!-- LEFT: FORM PEMESANAN -->
        <div class="col-lg-7">
            <div class="card shadow-sm p-4 border-0">

                <form action="{{ route('kendaraan.whatsapp') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nomor Telepon</label>
                        <input type="text" name="telepon" class="form-control" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Mulai</label>
                            <input type="date" name="mulai" class="form-control" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Selesai</label>
                            <input type="date" name="selesai" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat Penjemputan</label>
                        <textarea name="alamat" class="form-control" rows="3" required></textarea>
                    </div>

                    <input type="hidden" name="id_kendaraan" value="{{ $kendaraan->id_vehicle }}">
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Lanjutkan Pemesanan</button>
                </form>

            </div>
        </div>

    </div><!-- END ROW -->

</div><!-- END CONTAINER -->

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

<!-- SCRIPT -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
