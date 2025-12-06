<style>
  /* Semua teks bukan judul (judul pakai .fw-bold) */
  .footer p:not(.fw-bold),
  .footer a.text-light p,
  .footer small {
    color: #b1aaaaff !important; /* abu-abu terang */
  }
</style>

<!-- FOOTER -->
<footer class="footer mt-5 pt-5 pb-4 no-anim">
  <div class="container no-anim">
    <div class="row no-anim">

      <!-- Contact (KIRI) -->
      <div class="no-anim col-md-4 mb-4">        
        <p class="no-anim mb-1 fw-bold">CV. TIGA PUTRA SINGHASARI</p>
        <p class="no-anim text-light">Jl. Kebonagung Gg. 7, Gondorejo Krajan, Tamanharjo, Kec. Singosari, Kabupaten Malang, Jawa Timur 65153, Indonesia</p>

        <p class="no-anim mb-1 fw-bold">CALL US</p>
        <p class="no-anim text-light">+62 813-3511-5008</p>

        <p class="no-anim mb-1 fw-bold">MAIL US</p>
        <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ env('CONTACT_EMAIL') }}"
          target="_blank" 
          class="no-anim text-light">
          <p>{{ env('CONTACT_EMAIL') }}</p>
        </a>

        <p class="no-anim mb-2 fw-bold">FOLLOW US</p>
        <div class="no-anim d-flex gap-3">
          <a href="https://www.facebook.com/share/17czHQ6Son/" target="_blank" class="no-anim social-icon"><i class="no-anim bi bi-facebook"></i></a>
          <a href="https://www.instagram.com/temen_holiday?igsh=OWNtY2J0anZ2NnNw" target="_blank" class="no-anim social-icon"><i class="no-anim bi bi-instagram"></i></a>
          <a href="https://www.tiktok.com/@temenholiday?_r=1&_t=ZS-91vxshT9v8B" target="_blank" class="no-anim social-icon"><i class="no-anim bi bi-tiktok"></i></a>
        </div>
      </div>

      <!-- Links (TENGAH) -->
      <div class="no-anim col-md-4 mb-4">
        <ul class="no-anim footer-links">
          <li class="no-anim nav-item">
            <a class="no-anim nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
          </li>
          <li class="no-anim nav-item">
            <a class="no-anim nav-link {{ Request::is('about','about/*') ? 'active' : '' }}" href="{{ url('/about') }}">Tentang Kami</a>
          </li>
          <li class="no-anim nav-item">
            <a class="no-anim nav-link {{ Request::is('kendaraan','kendaraan/*') ? 'active' : '' }}" href="{{ url('/kendaraan') }}">Kendaraan</a>
          </li>
          <li class="no-anim nav-item">
            <a class="no-anim nav-link {{ Request::is('paket','paket/*') ? 'active' : '' }}" href="{{ url('/paket') }}">Paket Wisata</a>
          </li>
          <li class="no-anim nav-item">
            <a class="no-anim nav-link {{ Request::is('testimoni','testimoni/*') ? 'active' : '' }}" href="{{ url('/testimoni') }}">Ulasan</a>
          </li>
          <li class="no-anim nav-item">
            <a class="no-anim nav-link {{ Request::is('galeri', 'galeri/*') ? 'active' : '' }}" href="{{ url('/galeri') }}">Galeri</a>
          </li>
          <li class="no-anim nav-item">
            <a class="no-anim nav-link" href="{{ url('/admin/login') }}">Admin</a>
          </li>
        </ul>
      </div>

      <!-- FORM WHATSAPP (KANAN) -->
      <div class="no-anim col-md-4 mb-4">
        <h5 class="no-anim fw-bold mb-3 text-light">Info Lebih Lanjut</h5>

        <form id="waForm">
          <div class="no-anim mb-3">
            <input type="text" class="no-anim form-control" id="nama" placeholder="Nama lengkap" required>
          </div>

          <div class="no-anim mb-3">
            <select class="no-anim form-control" id="pilihan" required>
              <option value="" disabled selected>Pilih Layanan</option>
              <option value="Sewa Kendaraan">Sewa Kendaraan</option>
              <option value="Paket Wisata">Paket Wisata</option>
              <option value="Open Trip">Open Trip</option>
            </select>
          </div>

          <div class="no-anim mb-3">
            <input type="text" class="no-anim form-control" id="telp" placeholder="Nomor WhatsApp" required>
          </div>

          <button type="submit" id="submitBtn" class="no-anim btn btn-outline-light w-100 fw-bold" disabled>
            KIRIM VIA WHATSAPP →
          </button>
        </form>

        <small class="no-anim text-light d-block mt-3">
          Isi form dan kami akan mengarahkan Anda ke WhatsApp dengan pesan otomatis.
        </small>
      </div>

    </div>

    <hr class="no-anim footer-line">
    <p class="no-anim text-center text-light mt-3 mb-0">
      © 2025 Temen Holiday. All Rights Reserved.
    </p>
  </div>
</footer>
<style>
    .footer-links .nav-link {
        color: #b1aaaaff;
        transition: 0.2s;
    }

    /* Warna biru saat active */
    .footer-links .nav-link.active {
        color: #0056d2 !important;
        font-weight: 600;
    }

    /* Hover tetap konsisten */
    .footer-links .nav-link:hover {
        color: #0056d2;
    }
</style>

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

  const nomorTujuan = "6281335115008"; // GANTI nomor WA mitra

  const pesan =
`Halo kak, saya ingin ${pilihan}.

*Nama:* ${nama}
*Nomor:* ${telp}

Mohon info lebih lanjut ya kak.`;

  const url = "https://wa.me/" + nomorTujuan + "?text=" + encodeURIComponent(pesan);

  window.open(url, "_blank");
});
</script>
