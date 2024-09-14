<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title')</title>
  <link rel="shortcut icon" type="image/png" href="{{asset('vendor')}}/assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="{{asset('vendor')}}/assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
    <aside class="left-sidebar">
      <!-- Sidebar scroll-->
      <div>
        <div class="brand-logo d-flex align-items-center justify-content-between">
          <a href="./index.html" class="text-nowrap logo-img">
            <img src="{{asset('vendor')}}/assets/images/logos/dark-logo.svg" width="180" alt="" />
          </a>
          <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
            <i class="ti ti-x fs-8"></i>
          </div>
        </div>
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
          @include('layout.sidebar')
        </nav>
        <!-- End Sidebar navigation -->
      </div>
      <!-- End Sidebar scroll-->
    </aside>
    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
      <header class="app-header">
        <nav class="navbar navbar-expand-lg navbar-light">
          @include('layout.topbar')
        </nav>
      </header>
      <!--  Header End -->
      <div class="container-fluid">
        <!--  Row 1 -->
        @yield('content')
      </div>
    </div>
  </div>
  <script src="{{asset('vendor')}}/assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="{{asset('vendor')}}/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{asset('vendor')}}/assets/js/sidebarmenu.js"></script>
  <script src="{{asset('vendor')}}/assets/js/app.min.js"></script>
  <script src="{{asset('vendor')}}/assets/libs/apexcharts/dist/apexcharts.min.js"></script>
  <script src="{{asset('vendor')}}/assets/libs/simplebar/dist/simplebar.js"></script>
  <script src="{{asset('vendor')}}/assets/js/dashboard.js"></script>
</body>

</html>