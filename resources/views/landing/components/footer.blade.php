<style>
  /* Semua teks bukan judul (judul pakai .fw-bold) */
  .footer p:not(.fw-bold),
  .footer a.text-light p,
  .footer small {
    color: #b1aaaaff !important; /* abu-abu terang */
  }
</style>

<!-- FOOTER -->
<footer class="footer mt-5 pt-5 pb-4">
  <div class="container">
    <div class="row">

      <!-- Contact (KIRI) -->
      <div class="col-md-4 mb-4">        
        <p class="mb-1 fw-bold">CV. TIGA PUTRA SINGHASARI</p>
        <p class="text-light">Jl. Kebonagung Gg. 7, Gondorejo Krajan, Tamanharjo, Kec. Singosari, Kabupaten Malang, Jawa Timur 65153, Indonesia</p>

        <p class="mb-1 fw-bold">CALL US</p>
        <p class="text-light">+62 813-3511-5008</p>

        <p class="mb-1 fw-bold">MAIL US</p>
        <a href="https://mail.google.com/mail/?view=cm&fs=1&to={{ env('CONTACT_EMAIL') }}"
          target="_blank" 
          class="text-light">
          <p>{{ env('CONTACT_EMAIL') }}</p>
        </a>

        <p class="mb-2 fw-bold">FOLLOW US</p>
        <div class="d-flex gap-3">
          <a href="https://www.facebook.com/share/17czHQ6Son/" target="_blank" class="social-icon"><i class="bi bi-facebook"></i></a>
          <a href="https://www.instagram.com/temen_holiday?igsh=OWNtY2J0anZ2NnNw" target="_blank" class="social-icon"><i class="bi bi-instagram"></i></a>
          <a href="https://www.tiktok.com/@temenholiday?_r=1&_t=ZS-91vxshT9v8B" target="_blank" class="social-icon"><i class="bi bi-tiktok"></i></a>
        </div>
      </div>

      <!-- Links (TENGAH) -->
      <div class="col-md-4 mb-4">
        <ul class="footer-links">
          <li class="nav-item">
            <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('about') ? 'active' : '' }}" href="{{ url('/about') }}">Tentang Kami</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('kendaraan') ? 'active' : '' }}" href="{{ url('/kendaraan') }}">Kendaraan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('paket') ? 'active' : '' }}" href="{{ url('/paket') }}">Paket Wisata</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('testimoni') ? 'active' : '' }}" href="{{ url('/testimoni') }}">Ulasan</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ Request::is('galeri') ? 'active' : '' }}" href="{{ url('/galeri') }}">Galeri</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ url('/admin/login') }}">Admin</a>
          </li>
        </ul>
      </div>

      <!-- FORM WHATSAPP (KANAN) -->
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold mb-3 text-light">Info Lebih Lanjut</h5>

        <form id="waForm">
          <div class="mb-3">
            <input type="text" class="form-control" id="nama" placeholder="Nama lengkap" required>
          </div>

          <div class="mb-3">
            <select class="form-control" id="pilihan" required>
              <option value="" disabled selected>Pilih Layanan</option>
              <option value="Sewa Kendaraan">Sewa Kendaraan</option>
              <option value="Paket Wisata">Paket Wisata</option>
              <option value="Open Trip">Open Trip</option>
            </select>
          </div>

          <div class="mb-3">
            <input type="text" class="form-control" id="telp" placeholder="Nomor WhatsApp" required>
          </div>

          <button type="submit" id="submitBtn" class="btn btn-outline-light w-100 fw-bold" disabled>
            KIRIM VIA WHATSAPP →
          </button>
        </form>

        <small class="text-light d-block mt-3">
          Isi form dan kami akan mengarahkan Anda ke WhatsApp dengan pesan otomatis.
        </small>
      </div>

    </div>

    <hr class="footer-line">
    <p class="text-center text-light mt-3 mb-0">
      © 2025 Temen Holiday. All Rights Reserved.
    </p>
  </div>
</footer>
