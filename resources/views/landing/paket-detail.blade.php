<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $trip->title }} - Temen Holiday</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">
  <style>
    .trip-image {
        width: 100%;
        max-height: 700px;     /* ⬅️ gambar tidak akan terlalu tinggi */
        object-fit: cover;     /* ⬅️ crop rapi */
        border-radius: 12px;
    }
    </style>

</head>

<body>

@include('landing.components.header')

<div class="container py-5">
    <!-- TITLE CARD -->
    <div class="card shadow-sm p-4 border-0 mb-4">
    </div>

<div class="row g-4">

  <!-- FOTO -->
  <div class="col-md-4">
    <img src="{{ asset('storage/opentrip/' . $trip->cover_image) }}"
         class="trip-image shadow"
         alt="{{ $trip->title }}">
  </div>

  <!-- INFO -->
  <div class="col-md-8">

    <h2 class="fw-bold mb-2">{{ $trip->title }}</h2>

    <p class="text-muted" style="white-space: pre-line;">
      {{ $trip->description }}
    </p>

    <p class="mt-3">
      <i class="bi bi-geo-alt"></i>
      Meeting Point: <strong>{{ $trip->meeting_point ?? '-' }}</strong>
    </p>

    <div class="d-flex align-items-center gap-2 p-3 bg-light rounded border mt-3">
        
        <h3 class="fw-bold text-primary mb-0">
            Rp {{ number_format($trip->price, 0, ',', '.') }}
        </h3>

        @if ($trip->price_label)
            <span class="text-muted small">
                / {{ $trip->price_label }}
            </span>
        @endif

    </div>

    <a href="https://wa.me/6281234567890?text=Halo%20Admin,%20saya%20ingin%20pesan%20trip%20{{ urlencode($trip->title) }}"
    class="btn btn-primary px-4 py-2 mt-3 w-100"
    target="_blank">
    <i class="bi bi-whatsapp"></i> Pesan Sekarang
    </a>

  </div>
</div>

  <hr class="my-5">

  <!-- ================= ROW: DESTINASI & JADWAL ================= -->
  <div class="row g-4">

    <!-- DESTINASI -->
    <div class="col-md-6">
      <div class="p-4 border rounded shadow-sm h-100">
        <h3 class="fw-bold mb-3">Destinasi</h3>

        <ul class="mb-0">
          @forelse ($trip->destinations as $d)
            <li>{{ $d->destination ?? $d->name }}</li>
          @empty
            <p class="text-muted">Belum ada destinasi.</p>
          @endforelse
        </ul>
      </div>
    </div>

    <!-- JADWAL -->
    <div class="col-md-6">
      <div class="p-4 border rounded shadow-sm h-100">
        <h3 class="fw-bold mb-3">Jadwal Keberangkatan</h3>

        <ul class="mb-0">
          @forelse ($trip->schedules as $item)
            <li>
              {{ \Carbon\Carbon::parse($item->start_date)->format('d M Y') }}
              -
              {{ \Carbon\Carbon::parse($item->end_date)->format('d M Y') }}
            </li>
          @empty
            <p class="text-muted">Belum ada jadwal keberangkatan.</p>
          @endforelse
        </ul>
      </div>
    </div>

  </div>

  <hr class="my-5">

  <!-- ================= ITINERARY ================= -->
  <h3 class="fw-bold mb-3">Itinerary</h3>

  @forelse ($trip->itineraries as $hari)
    <div class="mb-4 p-4 border rounded shadow-sm">

      <h5 class="fw-bold">{{ $hari->day_title }}</h5>

      <ul class="mt-2">
        @foreach ($hari->items as $i)
          <li class="mb-1">
            <strong>{{ $i->time ?? '-' }}</strong> — {{ $i->activity }}
          </li>
        @endforeach
      </ul>
    </div>
  @empty
    <p class="text-muted">Belum ada itinerary.</p>
  @endforelse


  <hr class="my-5">

  <!-- ================= FASILITAS ================= -->
  <div class="p-4 border rounded shadow-sm">
    <h3 class="fw-bold mb-3">Fasilitas Termasuk</h3>
    
    <ul>
      @forelse ($fasilitas as $item)
        <li>{{ $item }}</li>
      @empty
        <p class="text-muted">Belum ada fasilitas.</p>
      @endforelse
    </ul>
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
