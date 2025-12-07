<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Temen Holiday - Galeri</title>
  <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/svg">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">
</head>
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
<body>

<!-- NAVBAR -->
@include('landing.components.header')

<!-- HERO -->
<section class="hero hero-small" style="background-image: url('assets/image/home1.jpeg');">
    <div class="hero-text">
        <h1>Gallery</h1>
    </div>
</section>

<!-- GALLERY -->
<div class="container py-5">

    <div class="row g-4">

        @foreach ($galeri as $item)
        <div class="col-6 col-md-3">
            <a href="{{ asset('storage/galeri/' . $item->gambar) }}" class="gallery-item">
                <div class="gallery-card">
                    <img src="{{ asset('storage/galeri/' . $item->gambar) }}" alt="{{ $item->judul }}">
                    <div class="overlay">
                        <span class="title">{{ $item->judul }}</span>
                    </div>
                </div>
            </a>
        </div>
        @endforeach

    </div>
</div>

<!-- FOOTER -->
@include('landing.components.footer')

<!-- MODAL -->
<div class="modal fade" id="galleryModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content p-4" style="max-width: 540px; margin: auto; border-radius: 12px;">
            
            <h3 class="text-center fw-bold" id="modalTitle"></h3>
            <div style="
                width: 90px;
                height: 3px;
                background-color: #007bff;
                margin: 10px auto 20px auto;
                border-radius: 5px;
            "></div>

            <img id="modalImage"
                class="rounded shadow-sm"
                style="width: 100%; height: 310px; object-fit: cover; border-radius: 10px;">

            <div class="text-center mt-4">
                <button class="btn btn-secondary px-4" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Navbar scroll effect
    const navbar = document.getElementById("mainNavbar");
    window.addEventListener("scroll", () => {
        navbar.classList.toggle("scrolled", window.scrollY > 50);
    });

    // Modal image preview
    document.querySelectorAll(".gallery-item").forEach(item => {
        item.addEventListener("click", function (e) {
            e.preventDefault();

            const img = this.querySelector("img");

            document.getElementById("modalImage").src = img.src;
            document.getElementById("modalTitle").textContent = img.alt;

            new bootstrap.Modal(document.getElementById("galleryModal")).show();
        });
    });
</script>

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
