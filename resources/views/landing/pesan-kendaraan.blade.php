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
@include('landing.components.footer')

<!-- SCRIPT -->
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
