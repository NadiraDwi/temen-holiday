<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pesan Kendaraan - Temen Holiday</title>
  <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/svg">

  <!-- BOOTSTRAP -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
    /* FIX CAROUSEL IMAGE */
    .detail-carousel-img {
        width: 100%;
        height: 300px;          /* FIX HEIGHT */
        object-fit: cover;      /* BIAR images[0] RAPIH */
    }
  </style>

  <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">
</head>

<body>

@include('landing.components.header')

<div class="container py-5">
    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Terjadi kesalahan:</strong>
        <ul class="mt-2 mb-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- TITLE -->
    <div class="card shadow-sm p-4 border-0 mb-4">
        <h3 class="fw-bold mb-0">Pesan Kendaraan</h3>
        <p class="text-muted mb-0">Lengkapi data untuk melakukan pemesanan kendaraan.</p>
    </div>

    <div class="row g-4">

        <!-- RIGHT: DETAIL KENDARAAN -->
        <div class="col-lg-5">

            <div class="card shadow-sm border-0 overflow-hidden">

                @php
                    // Ambil images - Laravel biasanya sudah convert JSON ke array
                    $images = $kendaraan->images;

                    // Pastikan array
                    if (!is_array($images)) {
                        $images = json_decode($images ?? '[]', true) ?? [];
                    }

                    // Fallback ke gambar utama
                    if (count($images) === 0) {
                        $images = [$kendaraan->gambar];
                    }
                @endphp

                <div id="detailCarousel" class="carousel slide" data-bs-ride="carousel">

                    <!-- Indicators -->
                    <div class="carousel-indicators">
                        @foreach($images as $index => $img)
                            <button type="button"
                                data-bs-target="#detailCarousel"
                                data-bs-slide-to="{{ $index }}"
                                class="{{ $index==0 ? 'active' : '' }}">
                            </button>
                        @endforeach
                    </div>

                    <!-- Slides -->
                    <div class="carousel-inner">
                        @foreach($images as $index => $img)
                            <div class="carousel-item {{ $index==0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $img) }}"
                                    class="detail-carousel-img" />
                            </div>
                        @endforeach
                    </div>

                    <button class="carousel-control-prev" type="button"
                            data-bs-target="#detailCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>

                    <button class="carousel-control-next" type="button"
                            data-bs-target="#detailCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>

                </div>

            </div>

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
                        <li>{{ trim($f) }}</li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- LEFT: FORM PEMESANAN -->
        <div class="col-lg-7">
            <div class="card shadow-sm p-4 border-0">

                <form action="{{ route('kendaraan.whatsapp') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
       value="{{ old('nama') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nomor Telepon</label>
                        <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
       value="{{ old('telepon') }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Mulai</label>
                            <input type="date" name="mulai" class="form-control @error('mulai') is-invalid @enderror"
       value="{{ old('mulai') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Selesai</label>
                            <input type="date" name="selesai" class="form-control @error('selesai') is-invalid @enderror"
       value="{{ old('selesai') }}">
                        </div>
                    </div>

                    <!-- Destinasi -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Tujuan Destinasi</label>

                        <div id="destinasi-wrapper">
                            <div class="input-group mb-2 destinasi-item">
                                <input type="text" name="destinasi[]" class="form-control" placeholder="Contoh: Pantai Kuta" required>
                                <button type="button" class="btn btn-outline-danger remove-dst">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </div>

                        <button type="button" id="addDestinasi" class="btn btn-outline-primary btn-sm mt-2">
                            <i class="bi bi-plus-lg"></i> Tambah Tujuan
                        </button>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alamat Penjemputan</label>
                        <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
       value="{{ old('alamat') }}" rows="3"></textarea>
                    </div>

                    <input type="hidden" name="id_kendaraan" value="{{ $kendaraan->id_vehicle }}">

                    <button type="submit" class="btn btn-primary w-100 fw-bold">
                        Lanjutkan Pemesanan
                    </button>

                </form>

            </div>
        </div>

    </div>

</div>

@include('landing.components.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// ADD DESTINASI
document.getElementById("addDestinasi").addEventListener("click", function () {
    const wrapper = document.getElementById("destinasi-wrapper");

    const item = document.createElement("div");
    item.classList.add("input-group", "mb-2", "destinasi-item");

    item.innerHTML = `
        <input type="text" name="destinasi[]" class="form-control" placeholder="Tujuan berikutnya" required>
        <button type="button" class="btn btn-outline-danger remove-dst">
            <i class="bi bi-x-lg"></i>
        </button>
    `;

    wrapper.appendChild(item);
});

// REMOVE DESTINASI
document.addEventListener("click", function(e) {
    if (e.target.closest(".remove-dst")) {
        const total = document.querySelectorAll(".destinasi-item").length;
        if (total > 1) e.target.closest(".destinasi-item").remove();
    }
});
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
