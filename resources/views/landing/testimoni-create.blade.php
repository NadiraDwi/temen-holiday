<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Temen Holiday - Tulis Testimoni</title>
  <link rel="icon" href="{{ asset('assets/image/logo.svg') }}" type="image/svg">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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
    .star { font-size: 32px; cursor: pointer; color: #c8c8c8; }
    .star.selected { color: #ffc107; }
    .preview-item {
        width: 80px; height: 80px; border-radius: 8px;
        margin-right: 6px; margin-bottom: 6px;
        object-fit: cover; border: 1px solid #ddd;
    }
    .upload-btn {
        padding: 10px 16px;
        border: 1px solid #ccc;
        border-radius: 10px;
        background: #f5f5f5;
        cursor: pointer;
        transition: 0.2s;
    }
    .upload-btn:hover { background: #eaeaea; }

    #imagesContainer input[type="file"] {
        display: none !important;
        visibility: hidden;
        opacity: 0;
        width: 0;
        height: 0;
        pointer-events: none;
    }
</style>
<body>

  @include('landing.components.header')

<div class="container py-5">

    <div class="card shadow-sm p-4 border-0 mb-4 mt-2 text-center">
        <h3 class="fw-bold mb-0">Tulis Testimonimu</h3>
    </div>

    <form id="testimoniForm" action="{{ route('testimoni.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-4">

        <!-- LEFT UPLOAD FOTO -->
        <div class="col-md-4">
            <h5 class="mb-3">Upload Foto</h5>

            <div class="upload-btn text-center" onclick="document.getElementById('imageInput').click()">
                <span>Pilih Foto</span>
            </div>

            <div id="imagesContainer"></div>

            <input type="file"
                   id="imageInput"
                   hidden
                   name="images[]"
                   accept="image/*"
                   multiple>

            <div id="previewContainer" class="d-flex flex-wrap mt-3"></div>

            <!-- ERROR FOTO -->
            @error('images')
                <small class="text-danger d-block mt-2">{{ $message }}</small>
            @enderror
            @error('images.*')
                <small class="text-danger d-block mt-2">{{ $message }}</small>
            @enderror
        </div>


        <!-- RIGHT FORM -->
        <div class="col-md-8">

            <!-- FASILITAS -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-semibold">Fasilitas</span>
                <div class="rating-group" data-target="ratingFasilitasInput">
                    <i class="bi bi-star star" data-value="1"></i>
                    <i class="bi bi-star star" data-value="2"></i>
                    <i class="bi bi-star star" data-value="3"></i>
                    <i class="bi bi-star star" data-value="4"></i>
                    <i class="bi bi-star star" data-value="5"></i>
                </div>
            </div>

            <input type="hidden"
                   name="rating_fasilitas"
                   id="ratingFasilitasInput"
                   value="{{ old('rating_fasilitas') }}">

            <!-- ERROR FASILITAS -->
            @error('rating_fasilitas')
                <small class="text-danger d-block mb-3">{{ $message }}</small>
            @enderror


            <!-- HARGA -->
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-semibold">Harga</span>
                <div class="rating-group" data-target="ratingHargaInput">
                    <i class="bi bi-star star" data-value="1"></i>
                    <i class="bi bi-star star" data-value="2"></i>
                    <i class="bi bi-star star" data-value="3"></i>
                    <i class="bi bi-star star" data-value="4"></i>
                    <i class="bi bi-star star" data-value="5"></i>
                </div>
            </div>

            <input type="hidden"
                   name="rating_harga"
                   id="ratingHargaInput"
                   value="{{ old('rating_harga') }}">

            <!-- ERROR HARGA -->
            @error('rating_harga')
                <small class="text-danger d-block mb-3">{{ $message }}</small>
            @enderror


            <!-- NAMA + SWITCH -->
            <div class="d-flex justify-content-between align-items-center">
                <label class="fw-semibold">Nama</label>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="switchAnonim">
                    <label class="form-check-label">Anonim</label>
                </div>
            </div>

            <input type="text"
                   id="namaInput"
                   name="nama_user"
                   class="form-control mb-2"
                   placeholder="Nama kamu"
                   value="{{ old('nama_user') }}">

            <!-- ERROR NAMA -->
            @error('nama_user')
                <small class="text-danger d-block mb-3">{{ $message }}</small>
            @enderror


            <!-- ULASAN -->
            <label class="fw-semibold">Ulasan</label>
            <textarea class="form-control"
                      name="pesan"
                      rows="5"
                      placeholder="Tulis pengalamanmu...">{{ old('pesan') }}</textarea>

            <!-- ERROR ULASAN -->
            @error('pesan')
                <small class="text-danger d-block">{{ $message }}</small>
            @enderror


            <div class="text-end mt-4">
                <button class="btn btn-primary px-4">Kirim</button>
            </div>
        </div>

    </div>
</form>


</div>

  @include('landing.components.footer')

<script>
// STAR RATING
document.querySelectorAll(".rating-group").forEach(group => {
    let target = document.getElementById(group.dataset.target);

    group.querySelectorAll(".star").forEach(star => {
        star.addEventListener("click", function () {
            let val = this.dataset.value;
            target.value = val;

            group.querySelectorAll(".star").forEach(s => {
                s.classList.remove("selected");
                
                if (s.dataset.value <= val) {
                    s.classList.add("selected");
                    s.classList.remove("bi-star");
                    s.classList.add("bi-star-fill"); // ★ full
                } else {
                    s.classList.remove("bi-star-fill");
                    s.classList.add("bi-star"); // ☆ outline
                }
            });
        });
    });
});

// ===============================
// FIX MULTI IMAGE SELECT
// ===============================
let allImages = [];

document.getElementById("imageInput").addEventListener("change", function () {
    let container = document.getElementById("previewContainer");

    [...this.files].forEach(file => {
        allImages.push(file);

        // Preview gambar
        let img = document.createElement("img");
        img.src = URL.createObjectURL(file);
        img.className = "preview-item";
        container.appendChild(img);
    });

    // reset input supaya bisa pilih lagi
    this.value = "";
});

// Saat submit → inject semua file ke form
document.getElementById("testimoniForm").addEventListener("submit", function () {
    let imagesContainer = document.getElementById("imagesContainer");
    imagesContainer.innerHTML = "";

    allImages.forEach(file => {
        const input = document.createElement("input");
        input.type = "file";
        input.name = "images[]";

        const dt = new DataTransfer();
        dt.items.add(file);
        input.files = dt.files;

        imagesContainer.appendChild(input);
    });
});

// SWITCH ANONIM
document.getElementById("switchAnonim").addEventListener("change", function () {
    let input = document.getElementById("namaInput");
    if (this.checked) {
        input.value = "Anonim";
        input.readOnly = true;
    } else {
        input.readOnly = false;
        input.value = "";
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
