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
        max-height: 700px;
        object-fit: cover;
        border-radius: 12px;
    }
    .trip-image-fixed {
        width: 100%;
        height: 350px;     /* FIXED HEIGHT */
        object-fit: cover; /* Crop rapi */
        border-radius: 12px;
    }
  </style>
  
</head>

<body>

@include('landing.components.header')

<div class="container py-5">

    <!-- TITLE -->
    <div class="card shadow-sm p-4 border-0 mb-4"></div>

    <div class="row g-4">

        <div class="col-md-4">

    <div id="tripCarousel" class="carousel slide" data-bs-ride="carousel">

        <!-- Indicators -->
        <div class="carousel-indicators">
            @foreach ($trip->images as $index => $img)
                <button 
                    type="button" 
                    data-bs-target="#tripCarousel" 
                    data-bs-slide-to="{{ $index }}"
                    class="{{ $index == 0 ? 'active' : '' }}"
                ></button>
            @endforeach
        </div>

        <!-- Slides -->
        <div class="carousel-inner shadow rounded">
            @foreach ($trip->images as $index => $img)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                    <img 
                        src="{{ asset('storage/' . $img) }}"
                        class="d-block w-100 trip-image-fixed"
                        alt="Gambar Trip {{ $index + 1 }}"
                    >
                </div>
            @endforeach
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#tripCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#tripCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>

    </div>

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

            <button 
                class="btn btn-primary px-4 py-2 mt-3 w-100"
                data-bs-toggle="modal"
                data-bs-target="#modalPesan"
            >
                <i class="bi bi-whatsapp"></i> Pesan Sekarang
            </button>

        </div>
    </div>

    <hr class="my-5">

    <!-- ================= DESTINASI & JADWAL ================= -->
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

<!-- ================= MODAL PESAN ================= -->
<div class="modal fade" id="modalPesan" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Form Pemesanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <form id="formPesan">

          <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" class="form-control" id="nama" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Nomor WhatsApp</label>
            <input type="text" class="form-control" id="telp" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Jumlah Pax</label>
            <input type="number" class="form-control" id="jumlah" min="1" value="1" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Catatan Tambahan</label>
            <textarea class="form-control" id="catatan" rows="2"></textarea>
          </div>

        </form>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button class="btn btn-success" onclick="kirimWhatsapp()">Kirim</button>
      </div>

    </div>
  </div>
</div>

@include('landing.components.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Swiper JS -->
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
function kirimWhatsapp() {
    const nama = document.getElementById("nama").value.trim();
    const telp = document.getElementById("telp").value.trim();
    const jumlah = document.getElementById("jumlah").value;
    const catatan = document.getElementById("catatan").value.trim();

    if (!nama || !telp || jumlah < 1) {
        alert("Harap isi data dengan lengkap.");
        return;
    }

    const trip = "{{ $trip->title }}";
    const nomorTujuan = "{{ $nomorAdmin }}"; // → sudah diformat dari helper

    if (!nomorTujuan) {
        alert("Nomor WhatsApp admin tidak ditemukan.");
        return;
    }

    const pesan = 
`Halo kak, saya ingin memesan trip:

*Trip:* ${trip}
*Jumlah Pax:* ${jumlah}
*Nama:* ${nama}
*Nomor:* ${telp}

Catatan:
${catatan || "-"}

Mohon info lebih lanjut ya kak.`;

    // nomorWa harus tanpa + dan tanpa spasi → helper sudah bereskan
    const url = "https://wa.me/" + nomorTujuan + "?text=" + encodeURIComponent(pesan);

    window.open(url, "_blank");
}
</script>

</body>
</html>
