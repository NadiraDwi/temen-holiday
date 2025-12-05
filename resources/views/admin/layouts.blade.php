<!DOCTYPE html>
<html lang="en">
  <!-- [Head] start -->
<head>
    <title>
        @yield('title', 'Temen Holiday')
    </title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies.">
    <meta name="keywords" content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard">
    <meta name="author" content="Phoenixcoded">

    <!-- [Favicon] icon -->
    <link rel="icon" href="{{ asset('assets') }}/image/logo.svg" type="image/x-icon">
    <!-- [Font] Family -->
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/inter/inter.css" id="main-font-link" />

    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/tabler-icons.min.css" />
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/feather.css" />
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/fontawesome.css" />
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('assets') }}/fonts/material.css" />
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('assets') }}/css/css-admin/style.css" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/css-admin/style-preset.css" />
    <link rel="stylesheet" href="{{ asset('assets') }}/css/custom.css" />

    @stack('custom-css')
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-14K1GBX9FG"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag() {
    dataLayer.push(arguments);
  }
  gtag('js', new Date());

  gtag('config', 'G-14K1GBX9FG');
</script>
<!-- WiserNotify -->
<script>
  !(function () {
    if (window.t4hto4) console.log('WiserNotify pixel installed multiple time in this page');
    else {
      window.t4hto4 = !0;
      var t = document,
        e = window,
        n = function () {
          var e = t.createElement('script');
          (e.type = 'text/javascript'),
            (e.async = !0),
            (e.src = '../../pt.wisernotify.com/pixel6d4c.js?ti=1jclj6jkfc4hhry'),
            document.body.appendChild(e);
        };
      'complete' === t.readyState ? n() : window.attachEvent ? e.attachEvent('onload', n) : e.addEventListener('load', n, !1);
    }
  })();
</script>
<!-- Microsoft clarity -->
<script type="text/javascript">
  (function (c, l, a, r, i, t, y) {
    c[a] =
      c[a] ||
      function () {
        (c[a].q = c[a].q || []).push(arguments);
      };
    t = l.createElement(r);
    t.async = 1;
    t.src = 'https://www.clarity.ms/tag/' + i;
    y = l.getElementsByTagName(r)[0];
    y.parentNode.insertBefore(t, y);
  })(window, document, 'clarity', 'script', 'gkn6wuhrtb');
</script>

  </head>
  <!-- [Head] end -->
  <!-- [Body] Start -->

  <body>
    <!-- [ Pre-loader ] start -->
<div class="loader-bg">
  <div class="loader-track">
    <div class="loader-fill"></div>
  </div>
</div>
<!-- [ Pre-loader ] End -->
 <!-- [ Sidebar Menu ] start -->
<nav class="pc-sidebar">
  <div class="navbar-wrapper">
    <div class="m-header logo-container">
      <a href="#" class="b-brand text-primary">
        <img src="{{asset('assets')}}/image/loho-67.png" class="logo-header" />
      </a>
    </div>

    <div class="navbar-content">
      <div class="card pc-user-card">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="flex-shrink-0">
              <img src="{{ asset('assets') }}/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-45 rounded-circle" />
            </div>
            <div class="flex-grow-1 ms-3 me-2">
              <h6 class="mb-0">
                {{ Auth::guard('admin')->user()->username }}
            </h6>
              <small>
                {{ Auth::guard('admin')->user()->name }}
              </small>
            </div>
            <a class="btn btn-icon btn-link-secondary avtar" data-bs-toggle="collapse" href="#pc_sidebar_userlink">
              <svg class="pc-icon">
                <use xlink:href="#custom-sort-outline"></use>
              </svg>
            </a>
          </div>
          <div class="collapse pc-user-links" id="pc_sidebar_userlink">
            <div class="pt-3">
              <a href="#!">
                <i class="ti ti-user"></i>
                <span>My Account</span>
              </a>
              <a href="{{ route('admin.logout') }}">
                <i class="ti ti-power"></i>
                <span>Logout</span>
              </a>
            </div>
          </div>
        </div>
      </div>

      <ul class="pc-navbar">
        <li class="pc-item pc-caption">
          <label>Navigasi</label>
          <i class="ti ti-dashboard"></i>
        </li>

        <!-- Beranda -->
        <li class="pc-item">
          <a href="/dashboard" class="pc-link">
            <span class="pc-micon">
              <i class="fas fa-home"></i>
            </span>
            <span class="pc-mtext">Beranda</span>
          </a>
        </li>

        <!-- Kendaraan -->
        <li class="pc-item pc-hasmenu">
          <a href="javascript:void(0)" class="pc-link">
            <span class="pc-micon">
              <i class="fas fa-car-side"></i>
            </span>
            <span class="pc-mtext">Kendaraan</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('kategori-kendaraan.index') }}">Kategori Kendaraan</a></li>
            <li class="pc-item">
                <a class="pc-link" href="{{ route('admin.kendaraan.index') }}">Data Kendaraan</a>
            </li>
          </ul>
        </li>

        <!-- Wisata -->
        <li class="pc-item pc-hasmenu">
          <a href="#" class="pc-link">
            <span class="pc-micon">
              <i class="fas fa-map-marked-alt"></i>
            </span>
            <span class="pc-mtext">Wisata</span>
            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
          </a>
          <ul class="pc-submenu">
            <li class="pc-item"><a class="pc-link" href="{{ route('wisata.index') }}">Wisata</a></li>
            <li class="pc-item"><a class="pc-link" href="{{ route('trip.index') }}">Open Trip</a></li>
          </ul>
        </li>

        <!-- Galeri -->
        <li class="pc-item">
          <a href="{{ route('galeri.index') }}" class="pc-link">
            <span class="pc-micon">
              <i class="fas fa-images"></i>
            </span>
            <span class="pc-mtext">Galeri</span>
          </a>
        </li>

        <li class="pc-item">
          <a href="{{ route('testimoni.index') }}" class="pc-link">
            <span class="pc-micon">
              <i class="fas fa-star-half-alt"></i>
            </span>
            <span class="pc-mtext">Testimoni</span>
          </a>
        </li>
      </ul>

    </div>
  </div>
</nav>
<!-- [ Sidebar Menu ] end -->
 <!-- [ Header Topbar ] start -->
<header class="pc-header">
  <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
<div class="me-auto pc-mob-drp">
  <ul class="list-unstyled">
    <!-- ======= Menu collapse Icon ===== -->
    <li class="pc-h-item pc-sidebar-collapse">
      <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
    <li class="pc-h-item pc-sidebar-popup">
      <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
        <i class="ti ti-menu-2"></i>
      </a>
    </li>
  </ul>
</div>
<!-- [Mobile Media Block end] -->
<div class="ms-auto">
  <ul class="list-unstyled">
    <li class="dropdown pc-h-item">
      <a
        class="pc-head-link dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        aria-expanded="false"
      >
        <svg class="pc-icon">
          <use xlink:href="#custom-sun-1"></use>
        </svg>
      </a>
      <div class="dropdown-menu dropdown-menu-end pc-h-dropdown">
        <a href="#!" class="dropdown-item" onclick="layout_change('dark')">
          <svg class="pc-icon">
            <use xlink:href="#custom-moon"></use>
          </svg>
          <span>Dark</span>
        </a>
        <a href="#!" class="dropdown-item" onclick="layout_change('light')">
          <svg class="pc-icon">
            <use xlink:href="#custom-sun-1"></use>
          </svg>
          <span>Light</span>
        </a>
        <a href="#!" class="dropdown-item" onclick="layout_change_default()">
          <svg class="pc-icon">
            <use xlink:href="#custom-setting-2"></use>
          </svg>
          <span>Default</span>
        </a>
      </div>
    </li>
    <li class="dropdown pc-h-item header-user-profile">
      <a
        class="pc-head-link dropdown-toggle arrow-none me-0"
        data-bs-toggle="dropdown"
        href="#"
        role="button"
        aria-haspopup="false"
        data-bs-auto-close="outside"
        aria-expanded="false"
      >
        <img src="{{ asset('assets') }}/images/user/avatar-2.jpg" alt="user-image" class="user-avtar" />
      </a>
      <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
        <div class="dropdown-header d-flex align-items-center justify-content-between">
          <h5 class="m-0">Profile</h5>
        </div>
        <div class="dropdown-body">
          <div class="profile-notification-scroll position-relative" style="max-height: calc(100vh - 225px)">
            <div class="d-flex mb-1">
              <div class="flex-shrink-0">
                <img src="{{ asset('assets') }}/images/user/avatar-2.jpg" alt="user-image" class="user-avtar wid-35" />
              </div>
              <div class="flex-grow-1 ms-3">
                <h6 class="mb-1"></h6>
                <span></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </li>
  </ul>
</div>
 </div>
</header>
<!-- [ Header ] end -->


        <!-- [ Main Content ] start -->
        <div class="pc-container">
            <div class="pc-content">
              <!-- [ breadcrumb ] start -->
              @yield('content')
              <!-- [ Main Content ] end -->
            </div>
          </div>
          <!-- [ Main Content ] end -->
    <!-- [Page Specific JS] end -->
    <!-- Required Js -->
    <script src="{{ asset('assets') }}/js/plugins/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/simplebar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/fonts/custom-font.js"></script>
    <script src="{{ asset('assets') }}/js/config.js"></script>
    <script src="{{ asset('assets') }}/js/pcoded.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/feather.min.js"></script>

    @stack('custom-js')

  </body>
  <!-- [Body] end -->

<!-- Mirrored from ableproadmin.com/dashboard/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 31 May 2023 03:33:33 GMT -->
</html>
