<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $wisata->title }} - Temen Holiday</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="{{ asset('assets/css/style-landing.css') }}">

  <style>
    .trip-image-fixed {
        width: 100%;
        height: 350px;
        object-fit: cover;
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

    <!-- HEADER -->
    <div class="card shadow-sm p-4 border-0 mb-4"></div>

    <div class="row g-4">

        <!-- FOTO / CAROUSEL -->
        <div class="col-md-4">

            <div id="wisataCarousel" class="carousel slide" data-bs-ride="carousel">

                <div class="carousel-indicators">
                    @foreach ($wisata->images as $index => $img)
                        <button 
                            type="button" 
                            data-bs-target="#wisataCarousel" 
                            data-bs-slide-to="{{ $index }}"
                            class="{{ $index == 0 ? 'active' : '' }}"
                        ></button>
                    @endforeach
                </div>

                <div class="carousel-inner shadow rounded">
                    @foreach ($wisata->images as $index => $img)
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <img 
                                src="{{ asset('storage/' . $img) }}"
                                class="d-block w-100 trip-image-fixed"
                                alt="Gambar Wisata {{ $index + 1 }}"
                            >
                        </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#wisataCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#wisataCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>

            </div>

        </div>

        <!-- DETAIL -->
        <div class="col-md-8">

            <h2 class="fw-bold mb-2">{{ $wisata->title }}</h2>

            <p class="text-muted" style="white-space: pre-line;">
                {{ $wisata->description }}
            </p>

            <!-- MAP -->
            @if ($wisata->map_url)
                <p class="mt-2">
                    <i class="bi bi-map"></i> 
                    <a href="{{ $wisata->map_url }}" target="_blank">Lihat Lokasi di Google Maps</a>
                </p>
            @endif

            <!-- HARGA -->
            <div class="d-flex align-items-center gap-2 p-3 bg-light rounded border mt-3">
                <h3 class="fw-bold text-primary mb-0">
                    Rp {{ number_format($wisata->price, 0, ',', '.') }}
                </h3>

                @if ($wisata->price_label)
                    <span class="text-muted small">
                        / {{ $wisata->price_label }}
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

    <!-- FASILITAS TERMASUK -->
    <div class="p-4 border rounded shadow-sm">
        <h3 class="fw-bold mb-3">Fasilitas Termasuk</h3>

        @php
            $fasilitas = array_filter(
                array_map('trim', explode(',', $wisata->include ?? ''))
            );
        @endphp

        <ul>
            @forelse ($fasilitas as $item)
                <li>{{ $item }}</li>
            @empty
                <p class="text-muted">Belum ada fasilitas.</p>
            @endforelse
        </ul>
    </div>

</div>

<!-- MODAL PESAN -->
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
            <div class="invalid-feedback">Nama wajib diisi</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Nomor WhatsApp</label>
            <input type="text" class="form-control" id="telp">
            <div class="invalid-feedback">Nomor WhatsApp wajib diisi</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Jumlah Pax</label>
            <input type="number" class="form-control" id="jumlah" min="1" value="1">
            <div class="invalid-feedback">Minimal 1 orang</div>
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan Tambahan</label>
            <textarea class="form-control" id="catatan" rows="2"></textarea>
            <div class="invalid-feedback">Catatan tidak valid</div>
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

<script>
function kirimWhatsapp() {
    const nama = document.getElementById("nama");
    const telp = document.getElementById("telp");
    const jumlah = document.getElementById("jumlah");
    const catatan = document.getElementById("catatan");

    let adaError = false;

    // reset dulu
    [nama, telp, jumlah].forEach(input => input.classList.remove("is-invalid"));

    // Validasi Nama
    if (nama.value.trim() === "") {
        nama.classList.add("is-invalid");
        adaError = true;
    }

    // Validasi WhatsApp
    if (telp.value.trim() === "") {
        telp.classList.add("is-invalid");
        adaError = true;
    }

    // Validasi Jumlah
    if (jumlah.value < 1) {
        jumlah.classList.add("is-invalid");
        adaError = true;
    }

    // Kalau ada error → stop + scroll ke input error
    if (adaError) {
        const firstInvalid = document.querySelector(".is-invalid");
        firstInvalid.scrollIntoView({ behavior: "smooth", block: "center" });
        return;
    }

    // FORMAT PESAN
    const wisata = "{{ $wisata->title }}";
    const nomorTujuan = "{{ $nomorAdmin }}";

    const pesan = 
`Halo kak, saya ingin memesan paket wisata:

*Paket:* ${wisata}
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

</body>
</html>
