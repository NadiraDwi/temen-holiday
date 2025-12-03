<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Temen Holiday</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">

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

    <div class="card shadow-sm p-4 border-0 mb-0 text-center">
        <h3 class="fw-bold mb-0">Tulis Testimonimu</h3>
    </div>

    <form id="testimoniForm" action="{{ route('testimoni.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row g-4">

            <!-- LEFT Upload Foto -->
            <div class="col-md-4">
                <h5 class="mb-3">Upload Foto</h5>

                <div class="upload-btn text-center" onclick="document.getElementById('imageInput').click()">
                    <i class="bi bi-image fs-3"></i><br>
                    <span>Pilih Foto</span>
                </div>

                <input type="file" hidden id="imageInput" accept="image/*" multiple>

                <div id="previewContainer" class="d-flex flex-wrap mt-3"></div>

                <!-- tempat hidden input file -->
                <div id="imagesContainer"></div>
            </div>

            <!-- RIGHT Form -->
            <div class="col-md-8">

                <!-- Fasilitas -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-semibold">Fasilitas</span>
                    <div class="rating-group" data-target="ratingFasilitasInput">
                        <i class="bi bi-star star" data-value="1"></i>
                        <i class="bi bi-star star" data-value="2"></i>
                        <i class="bi bi-star star" data-value="3"></i>
                        <i class="bi bi-star star" data-value="4"></i>
                        <i class="bi bi-star star" data-value="5"></i>
                    </div>
                </div>
                <input type="hidden" name="rating_fasilitas" id="ratingFasilitasInput">

                <!-- Harga -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fw-semibold">Harga</span>
                    <div class="rating-group" data-target="ratingHargaInput">
                        <i class="bi bi-star star" data-value="1"></i>
                        <i class="bi bi-star star" data-value="2"></i>
                        <i class="bi bi-star star" data-value="3"></i>
                        <i class="bi bi-star star" data-value="4"></i>
                        <i class="bi bi-star star" data-value="5"></i>
                    </div>
                </div>
                <input type="hidden" name="rating_harga" id="ratingHargaInput">

                <!-- Nama + Switch -->
                <div class="d-flex justify-content-between align-items-center">
                    <label class="fw-semibold">Nama</label>

                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="switchAnonim">
                        <label class="form-check-label">Anonim</label>
                    </div>
                </div>

                <input type="text" id="namaInput" name="nama_user" class="form-control mb-3" placeholder="Nama kamu" required>

                <!-- Ulasan -->
                <label class="fw-semibold">Ulasan</label>
                <textarea class="form-control" name="pesan" rows="5" placeholder="Tulis pengalamanmu..." required></textarea>

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

</body>
</html>
