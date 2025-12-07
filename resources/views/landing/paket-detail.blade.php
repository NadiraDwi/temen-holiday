<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $trip->title }} - Temen Holiday</title>
  <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/svg">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">
  <style>
      .goog-te-banner-frame {
          display: none !important;
      }
  </style>
  <style>
.goog-te-banner-frame,
.goog-te-gadget-icon {
    display: none !important;
}
.skiptranslate {
    display: none !important;
}

body {
    top: 0px !important;
}
</style>
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

    .is-invalid {
      border-color: #dc3545 !important;
  }
  .invalid-feedback {
      display: none;
      color: #dc3545;
      font-size: 0.9rem;
  }
  .is-invalid + .invalid-feedback {
      display: block;
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
            <input type="text" class="form-control" id="nama">
            <div class="invalid-feedback">Nama wajib diisi.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor WhatsApp</label>
            <input type="text" class="form-control" id="telp">
            <div class="invalid-feedback">Nomor WhatsApp wajib diisi.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah Pax</label>
            <input type="number" class="form-control" id="jumlah" min="1" value="1">
            <div class="invalid-feedback">Jumlah minimal 1 orang.</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan Tambahan</label>
            <textarea class="form-control" id="catatan" rows="2"></textarea>
            <div class="invalid-feedback">Catatan tidak valid.</div>
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

    // Ambil elemen input
    const nama = document.getElementById("nama");
    const telp = document.getElementById("telp");
    const jumlah = document.getElementById("jumlah");
    const catatan = document.getElementById("catatan");

    let adaError = false;

    // Reset semua dulu
    [nama, telp, jumlah].forEach(input => input.classList.remove("is-invalid"));

    // Validasi Nama
    if (nama.value.trim() === "") {
        nama.classList.add("is-invalid");
        adaError = true;
    }

    // Validasi WA (boleh tambah regex nanti kalau mau)
    if (telp.value.trim() === "") {
        telp.classList.add("is-invalid");
        adaError = true;
    }

    // Validasi Pax
    if (jumlah.value < 1) {
        jumlah.classList.add("is-invalid");
        adaError = true;
    }

    // Jika error → highlight & stop proses
    if (adaError) {
        const firstInvalid = document.querySelector(".is-invalid");
        firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
        return;
    }

    // -----------------------------
    // Jika lolos validasi → Kirim WA
    // -----------------------------

    const trip = "{{ $trip->title }}";
    const nomorTujuan = "{{ $nomorAdmin }}";

    const pesan = 
`Halo kak, saya ingin memesan trip:

*Trip:* ${trip}
*Jumlah Pax:* ${jumlah.value}
*Nama:* ${nama.value}
*Nomor:* ${telp.value}

Catatan:
${catatan.value || "-"}

Mohon info lebih lanjut ya kak.`;

    const url = "https://wa.me/" + nomorTujuan + "?text=" + encodeURIComponent(pesan);
    window.open(url, "_blank");
}
</script>

<!-- =================== GOOGLE TRANSLATE (HIDDEN) =================== -->
<div id="google_translate_element" style="display:none;"></div>

<!-- Hapus banner jelek Google -->
<script>
    function removeGoogleTranslateBanner() {
        const frame = document.querySelector(".goog-te-banner-frame");
        if (frame) frame.remove();

        const skip = document.querySelector("body > .skiptranslate");
        if (skip) skip.style.top = "0px";

        document.body.style.top = "0px";
    }

    // Google load-nya telat → hapus berulang
    const interval = setInterval(removeGoogleTranslateBanner, 300);
    setTimeout(() => clearInterval(interval), 5000);
</script>

<!-- Init translate -->
<script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: "id",
            includedLanguages: "id,en",
            autoDisplay: false,
        }, "google_translate_element");
    }
</script>

<script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("btnID").addEventListener("click", () => changeLang("id"));
    document.getElementById("btnEN").addEventListener("click", () => changeLang("en"));
});
</script>

<!-- =================== BUTTON CONTROL =================== -->
<script>
function changeLang(lang) {
    const combo = document.querySelector("select.goog-te-combo");

    if (!combo) {
        console.warn("Google Translate combo belum siap");
        return;
    }

    if (lang === "id") {
        // RESET translate ke default (Indonesia)
        localStorage.removeItem("googtrans");
        sessionStorage.removeItem("googtrans");

        // Hapus cookie googtrans
        document.cookie = "googtrans=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;";
        document.cookie = "googtrans=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/id/en;";

        // Set combo ke default (kosong)
        combo.value = "";
        combo.dispatchEvent(new Event("change"));

        // Reload supaya benar-benar hilang efek translate
        setTimeout(() => location.reload(), 300);
        return;
    }

    // === Ubah ke INGGRIS ===
    combo.value = lang;
    combo.dispatchEvent(new Event("change"));

    // Simpan preferensi
    localStorage.setItem("googtrans", `/id/${lang}`);
    sessionStorage.setItem("googtrans", `/id/${lang}`);
}
</script>

</body>
</html>
