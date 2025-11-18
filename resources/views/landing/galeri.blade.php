<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Temen Holiday - Galeri</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">
</head>

<body>

<!-- NAVBAR -->
@include('landing.components.header')

<!-- HERO -->
<section class="hero hero-small" style="background-image: url('https://picsum.photos/1200/600?travel1');">
    <div class="hero-text">
        <h1>Gallery</h1>
    </div>
</section>

<!-- GALLERY -->
<div class="container py-5">

    <h2 class="text-center fw-bold mb-4">Dokumentasi Perjalanan</h2>

    <div class="row g-4">

        @foreach ($galeri as $item)
        <div class="col-6 col-md-3">
            <a href="{{ asset($item['path']) }}" class="gallery-item">
                <div class="gallery-card">
                    <img src="{{ asset($item['path']) }}" alt="{{ $item['title'] }}">
                    <div class="overlay">
                        <span class="title">{{ $item['title'] }}</span>
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
                 style="width: 100%; max-height: 480px; object-fit: cover; border-radius: 10px;">

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

</body>
</html>
