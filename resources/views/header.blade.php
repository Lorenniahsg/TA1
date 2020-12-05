<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title>@yield('title')</title>

<!-- Bootstrap core CSS -->
<link href="{{ asset('template_madan/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

<!-- Custom styles -->
<link href="{{ asset('template_madan/css/style.css') }}" rel="stylesheet">
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-light bg-info fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="{{ url('/') }}">Rekomendasi Mahasiswa Teladan IT Del</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbar-Responsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarResponsive">
          
            <ul class="navbar-nav">
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" style="color:black;" href="{{ url('/') }}">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" style="color:black;" href="{{ url('/dimx_dim') }}">Import Data Mahasiswa</a>
              </li>
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" style="color:black;" href="{{ url('/Mahasiswa') }}">SAW</a>
              </li>
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" style="color:black;" href="{{ url('/PerhitunganFT') }}">Fuzzy Topsis</a>
              </li>
              <li class="nav-item">
                <a class="nav-link js-scroll-trigger" style="color:black;"   href="{{ url('/perbandingan') }}">Perbandingan</a>
              </li>
            </ul>
          
      </div>
    </div>
  </nav>
  <!-- END : Navigation -->
