<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Temen Holiday</title>
  <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/svg">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

  <!-- Custom CSS -->
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
  </head>
<body>

<!-- NAVBAR -->
@include('landing.components.header')

<div class="container py-5">
    <div class="card shadow-sm p-4 border-0 mb-4"></div>
    <a href="{{ url('/') }}" class="text-decoration-none text-dark d-inline-flex align-items-center mb-3"
    style="font-size: 18px;">
        <i class="bi bi-arrow-left"></i>
        <span class="ms-1">Kembali</span>
    </a>

    <h3 class="mb-4">Hasil Pencarian: <strong>{{ $q }}</strong></h3>

    @if ($results->count() == 0)
        <p class="text-muted">Tidak ada hasil ditemukan.</p>
    @endif

    <div class="row">
        @foreach ($results as $item)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">

                    <img src="{{ asset('storage/' . $item->images[0]) }}"
                         class="card-img-top"
                         style="height: 200px; object-fit: cover;">

                    <div class="card-body">
                        <h5 class="fw-bold">{{ $item->title }}</h5>
                        <p class="text-success fw-bold">
                            Rp {{ number_format($item->price, 0, ',', '.') }}
                        </p>

                       @if ($item->type === 'opentrip')
                            <a href="{{ route('opentrip.detail', $item->id) }}" class="btn btn-primary w-100">Detail</a>

                        @elseif ($item->type === 'wisata')
                            <a href="{{ route('wisata.user.detail', $item->id) }}" class="btn btn-primary w-100">Detail</a>

                        @elseif ($item->type === 'kendaraan')
                            <a href="{{ url('/kendaraan/pesan/' . $item->id) }}" class="btn btn-primary w-100">Pesan</a>
                        @endif
                    </div>

                </div>
            </div>
        @endforeach
    </div>

</div>
@include('landing.components.footer')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
