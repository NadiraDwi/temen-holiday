
<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
  <title>Login | Temen Holiday</title>
  <!-- [Meta] -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="description" content="Able Pro is trending dashboard template made using Bootstrap 5 design framework. Able Pro is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies.">
  <meta name="keywords" content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard">
  <meta name="author" content="Phoenixcoded">

  <!-- [Favicon] icon -->
  <link rel="icon" href="../assets/image/logo.svg" type="image/x-icon"> <!-- [Font] Family -->

<link rel="stylesheet" href="../assets/fonts/inter/inter.css" id="main-font-link" />
<!-- [Tabler Icons] https://tablericons.com -->
<link rel="stylesheet" href="../assets/fonts/tabler-icons.min.css" >
<!-- [Feather Icons] https://feathericons.com -->
<link rel="stylesheet" href="../assets/fonts/feather.css" >
<!-- [Font Awesome Icons] https://fontawesome.com/icons -->
<link rel="stylesheet" href="../assets/fonts/fontawesome.css" >
<!-- [Material Icons] https://fonts.google.com/icons -->
<link rel="stylesheet" href="../assets/fonts/material.css" >
<!-- [Template CSS Files] -->
<link rel="stylesheet" href="../assets/css/css-admin/style.css" id="main-style-link" >
<link rel="stylesheet" href="../assets/css/css-admin/style-preset.css" >
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
            (e.src = 'https://pt.wisernotify.com/pixel.js?ti=1jclj6jkfc4hhry'),
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

<body data-pc-preset="preset-1" data-pc-sidebar-caption="true" data-pc-direction="ltr" data-pc-theme_contrast="" data-pc-theme="light">
  <!-- [ Pre-loader ] start -->
  <div class="loader-bg">
    <div class="loader-track">
      <div class="loader-fill"></div>
    </div>
  </div>
  <!-- [ Pre-loader ] End -->

  <div class="auth-main">
    <div class="auth-wrapper v1">
      <div class="auth-form">
        <div class="card my-5">
          <div class="card-body">
            <div class="text-center">
                <div class="text-center mb-3">
                    <a href="#"><img src="{{ asset('assets/image/logo-new.png') }}" alt="img"></a>
                </div>
                @if ($errors->has('login'))
                    <div class="alert alert-danger">
                        {{ $errors->first('login') }}
                    </div>
                @endif
                <form action="{{ route('admin.login.action') }}" method="POST">
                  @csrf
                  <h4 class="text-center f-w-500 mb-3">Login with your email</h4>
                  <div class="form-group mb-3">
                    <input type="email" name="email" class="form-control" id="floatingInput" placeholder="Email Address" autofocus>
                  </div>
                  <div class="form-group mb-3">
                    <div class="input-group">
                      <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                      <div class="input-group-text" onclick="togglePassword(this)" data-toggle="close"><i class="fa fa-eye"></i></div>
                    </div>
                  </div>
                  <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Login</button>
                  </div>
                </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- [ Main Content ] end -->
  <!-- Required Js -->
  <script src="../assets/js/plugins/popper.min.js"></script>
  <script src="../assets/js/plugins/simplebar.min.js"></script>
  <script src="../assets/js/plugins/bootstrap.min.js"></script>
  <script src="../assets/js/fonts/custom-font.js"></script>
  <script src="../assets/js/pcoded.js"></script>
  <script src="../assets/js/plugins/feather.min.js"></script>

  
  <script>layout_change('light');</script>  
  
  
  <script>change_box_container('false');</script>
  
  
  <script>layout_caption_change('true');</script>
  
  
  
  
  <script>layout_rtl_change('false');</script>
  
  <script>
    function togglePassword(e){
      if( e.dataset.toggle == 'close' ){
        e.innerHTML = '<i class="fa fa-eye-slash"></i>'
        e.dataset.toggle = "open"
        document.querySelector('#password').setAttribute('type', 'text')
      }else{
        e.innerHTML = '<i class="fa fa-eye"></i>'
        e.dataset.toggle = "close"
        document.querySelector('#password').setAttribute('type', 'password')
      }
    }
  </script>
  
  <script>preset_change("preset-1");</script>
   <div class="pct-c-btn">
  <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_pc_layout">
    <i class="ph-duotone ph-gear-six"></i>
  </a>
</div>
</body>
<!-- [Body] end -->

</html>