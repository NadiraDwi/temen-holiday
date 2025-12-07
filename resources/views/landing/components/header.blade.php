<style>
/* Melindungi navbar agar tidak rusak karena translate */
.goog-te-banner-frame,
.skiptranslate {
    display: none !important;
}
body { top: 0 !important; }

/* Menu bahasa */
#languageDropdown {
    cursor: pointer;
}

.dropdown-menu a {
    cursor: pointer;
}
</style>

<nav id="mainNavbar" class="no-anim navbar navbar-expand-lg">
    <div class="no-anim container">
        <a class="no-anim navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('assets/image/logo1.png') }}" alt="Logo" class="no-anim logo-navbar">
        </a>

        <button class="no-anim navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="no-anim navbar-toggler-icon"></span>
        </button>

        <div class="no-anim collapse navbar-collapse" id="navbarNav">
            <ul class="no-anim navbar-nav ms-auto">

                <li class="no-anim nav-item">
                    <a class="no-anim nav-link {{ Request::is('/', 'search') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>

                <li class="no-anim nav-item">
                    <a class="no-anim nav-link {{ Request::is('about', 'about/*') ? 'active' : '' }}" href="{{ url('/about') }}">Tentang Kami</a>
                </li>

                <li class="no-anim nav-item">
                    <a class="no-anim nav-link {{ Request::is('kendaraan', 'kendaraan/*') ? 'active' : '' }}" href="{{ url('/kendaraan') }}">Kendaraan</a>
                </li>

                <li class="no-anim nav-item">
                    <a class="no-anim nav-link {{ Request::is('paket', 'paket/*') ? 'active' : '' }}" href="{{ url('/paket') }}">Wisata</a>
                </li>

                <li class="no-anim nav-item">
                    <a class="no-anim nav-link {{ Request::is('testimoni', 'testimoni/*') ? 'active' : '' }}" href="{{ url('/testimoni') }}">Ulasan</a>
                </li>

                <li class="no-anim nav-item">
                    <a class="no-anim nav-link {{ Request::is('galeri', 'galeri/*') ? 'active' : '' }}" href="{{ url('/galeri') }}">Galeri</a>
                </li>
                
                <li class="no-anim nav-item">
                    <a class="no-anim nav-link" href="{{ url('/admin/login') }}">Admin</a>
                </li>

                <li class="nav-item dropdown ms-3">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="languageDropdown"
                    role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-globe"></i>
                        <span class="ms-1">Lang</span>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" id="btnID">Indonesia</a></li>
                        <li><a class="dropdown-item" id="btnEN">English</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
