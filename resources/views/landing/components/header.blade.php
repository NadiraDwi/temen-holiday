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

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

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
{{-- ========== POPUP COOKIES ========== --}}
@if (!Cookie::has('cookie_consent'))
<div id="cookiePopup"
     style="
        position: fixed; 
        bottom: 20px; 
        left: 20px; 
        background: #2b2b2b; 
        color: #fff; 
        padding: 18px 20px; 
        border-radius: 12px; 
        z-index: 9999; 
        width: 280px;
        box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        animation: slideUp 0.4s ease;
     ">
    <p class="mb-2" style="font-size:14px; line-height:1.4; margin:0 0 10px;">
        Website ini menggunakan cookies untuk meningkatkan pengalaman Anda.
    </p>

    <button onclick="acceptCookies()" 
            style="
                background:#28a745; 
                border:none; 
                padding:8px 12px; 
                color:#fff; 
                width:100%; 
                border-radius:6px; 
                font-size:14px;
                cursor:pointer;
                transition:0.2s;
            "
            onmouseover="this.style.opacity='0.9'"
            onmouseout="this.style.opacity='1'">
        Saya Mengerti
    </button>
</div>

<style>
@keyframes slideUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}
</style>

<script>
function acceptCookies() {
    fetch("/set-cookie", {
        method: "POST",
        credentials: "same-origin",
        headers: {
            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            "Accept": "application/json"
        }
    }).then(() => {
        location.reload(); 
    });
}
</script>

@endif
{{-- ================================== --}}