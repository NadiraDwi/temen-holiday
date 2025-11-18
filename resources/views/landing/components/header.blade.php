<nav id="mainNavbar" class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">TEMENHOLIDAY</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('kendaraan') ? 'active' : '' }}" href="{{ url('/kendaraan') }}">Kendaraan</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('paket') ? 'active' : '' }}" href="{{ url('/paket') }}">Paket Wisata</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::is('galeri') ? 'active' : '' }}" href="{{ url('/galeri') }}">Galeri</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/admin/login') }}">Admin</a>
                </li>

            </ul>
        </div>
    </div>
</nav>
