<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>SPT WEB - {{ $title }}</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('assets') }}/vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="{{ asset('assets') }}/vendors/flag-icon-css/css/flag-icon.min.css">
  <link rel="stylesheet" href="{{ asset('assets') }}/vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{ asset('assets') }}/vendors/font-awesome/css/font-awesome.min.css" />
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <!-- endinject -->
  <!-- Layout styles -->
  <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css">
  <!-- End layout styles -->
  <link rel="shortcut icon" href="{{ asset('assets') }}/images/favicon.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css" integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  @stack('css')
  @stack('style')
  <style>
    .modal-content{
        color: rgb(38, 38, 38) !important;
    }
    .select2-selection,.select2
    {
        width: 100% !important;
        padding: 0 0 0 0 !important;
    }
    .logo{

    font-size: 30px !important;
    color: #fff !important;
    }
    body{
        position: relative;
    }
  </style>
</head>

<body>

  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
        <h1 class="navbar-brand brand-logo logo mt-5 mb-3" >SIMSPT</h1>
        <a class="navbar-brand brand-logo-mini" href="index.html"><img src="{{ asset('assets') }}/images/logo-mini.svg"
            alt="logo" /></a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-stretch">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="mdi mdi-menu"></span>
        </button>
        <ul class="navbar-nav navbar-nav-right">

          <li class="nav-item nav-profile dropdown">
            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-toggle="dropdown"
              aria-expanded="false">
              <div class="nav-profile-img">
                <img src="{{ asset('assets') }}/images/faces/face28.png" alt="image">
              </div>
              <div class="nav-profile-text">
                <p class="mb-1 text-black">{{ auth()->user()->username }}</p>
              </div>
            </a>
            <div class="dropdown-menu navbar-dropdown dropdown-menu-right p-0 border-0 font-size-sm"
              aria-labelledby="profileDropdown" data-x-placement="bottom-end">
              <div class="p-3 text-center bg-primary">
                <img class="img-avatar img-avatar48 img-avatar-thumb"
                  src="{{ asset('assets') }}/images/faces/face28.png" alt="">
              </div>
              <div class="p-2">
                <h5 class="dropdown-header text-uppercase pl-2 text-dark">User Options</h5>
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between" href="#">
                  <span>Profile</span>
                  <span class="p-0">
                    <i class="mdi mdi-account-outline ml-1"></i>
                  </span>
                </a>
                <div role="separator" class="dropdown-divider"></div>
                <h5 class="dropdown-header text-uppercase  pl-2 text-dark mt-2">Actions</h5>
                <a class="dropdown-item py-1 d-flex align-items-center justify-content-between"
                  href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                  <span>Log Out</span>
                  <i class="mdi mdi-logout ml-1"></i>
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>

              </div>
            </div>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
              data-toggle="dropdown">
              <i class="mdi mdi-bell-outline"></i>
              <span class="count-symbol bg-danger"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
              aria-labelledby="notificationDropdown">
              <h6 class="p-3 mb-0 bg-primary text-white py-4">Notifications</h6>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-success">
                    <i class="mdi mdi-calendar"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                  <p class="text-gray ellipsis mb-0"> Just a reminder that you have an event today </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-warning">
                    <i class="mdi mdi-settings"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                  <p class="text-gray ellipsis mb-0"> Update dashboard </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item preview-item">
                <div class="preview-thumbnail">
                  <div class="preview-icon bg-info">
                    <i class="mdi mdi-link-variant"></i>
                  </div>
                </div>
                <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                  <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
                  <p class="text-gray ellipsis mb-0"> New admin wow! </p>
                </div>
              </a>
              <div class="dropdown-divider"></div>
              <h6 class="p-3 mb-0 text-center">See all notifications</h6>
            </div>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
          data-toggle="offcanvas">
          <span class="mdi mdi-menu"></span>
        </button>
      </div>
    </nav>

    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item nav-category">Main</li>
          <li class="nav-item">
            <a class="nav-link" href="/dashboard">
              <span class="icon-bg"><i class="mdi mdi-cube menu-icon"></i></span>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false"
              aria-controls="ui-basic">
              <span class="icon-bg"><i class="mdi mdi-file-document menu-icon"></i></span>
              <span class="menu-title">Manajemen Surat</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Surat Perintah</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/dropdowns.html">Surat Perjalan Dinas</a></li>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('employees.index') }}">
              <span class="icon-bg"><i class="mdi mdi-account-multiple menu-icon"></i></span>
              <span class="menu-title">Pegawai</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('users.index') }}">
              <span class="icon-bg"><i class="mdi mdi-account menu-icon"></i></span>
              <span class="menu-title">Akun Pengguna</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#anggaran" aria-expanded="@php
            if(Request::segment(1) == 'region'){
              echo 'true';
            }
        @endphp"
              aria-controls="anggaran">
              <span class="icon-bg"><i class="mdi  mdi-currency-usd menu-icon"></i></span>
              <span class="menu-title">Manajemen Anggaran</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="anggaran">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="{{ route('costs.dailies.index') }}">Uang Harian</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('costs.transports.index') }}">Transportasi</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('costs.tickets.index') }}">Tiket Pesawat</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('costs.lodgings.index') }}">Penginapan</a></li>
                <li class="nav-item"> <a class="nav-link" href="{{ route('costs.rentals.index') }}">Sewa Kendaraan</a></li>
                </li>
              </ul>
            </div>
          </li>
          <li class="nav-item nav-category">Master Data</li>
          <li class="nav-item @if (Request::is('postions')) active @endif">
            <a class="nav-link" href="{{ route('positions.index') }}">
              <span class="icon-bg"><i class="mdi mdi-puzzle menu-icon"></i></span>
              <span class="menu-title">Jabatan</span>
            </a>
          </li>
          <li class="nav-item  @if (Request::is('grades')) active @endif">
            <a class="nav-link" href="{{ route('grades.index') }}">
              <span class="icon-bg"><i class="mdi mdi-puzzle menu-icon"></i></span>
              <span class="menu-title">Pangkat</span>
            </a>
          </li>
          <li class="nav-item @if (Request::is('groups')) active @endif">
            <a class="nav-link" href="{{ route('groups.index') }}">
              <span class="icon-bg"><i class="mdi mdi-puzzle menu-icon"></i></span>
              <span class="menu-title">Golongan</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#region" aria-expanded="@php
                if(Request::segment(1) == 'region'){
                  echo 'true';
                }
            @endphp" aria-controls="region">
              <span class="icon-bg"><i class="mdi  mdi-map menu-icon"></i></span>
              <span class="menu-title">Wilayah</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="region">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item "> <a class="nav-link" href="{{ route('region.districts.index') }}"> Kabupaten/Kota </a></li>
                <li class="nav-item "> <a class="nav-link" href="{{ route('region.provinces.index') }}"> Provinsi </a></li>
              </ul>
            </div>
          </li>
          <hr>

          <li class="nav-item sidebar-user-actions">
            <div class="sidebar-user-menu">
              <a  href="{{ route('logout') }}"
              onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();" class="nav-link"><i class="mdi mdi-logout menu-icon"></i>
                <span class="menu-title">Log Out</span></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                  </form>
            </div>
          </li>
        </ul>
      </nav>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">
            <div class="page-header">
                <h3 class="page-title"> @yield('title') </h3>
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">@yield('breadcrumb')</li>
                  </ol>
                </nav>
              </div>
          @yield('content')
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="footer-inner-wraper">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © bootstrapdash.com
                2020</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Free <a
                  href="https://www.bootstrapdash.com/" target="_blank">Bootstrap dashboard templates</a> from
                Bootstrapdash.com</span>
            </div>
          </div>
        </footer>
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{ asset('assets') }}/vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page -->
  <script src="{{ asset('assets') }}/vendors/jquery-circle-progress/js/circle-progress.min.js"></script>
  <!-- End plugin js for this page -->
  <!-- inject:js -->
  <script src="{{ asset('assets') }}/js/off-canvas.js"></script>
  <script src="{{ asset('assets') }}/js/hoverable-collapse.js"></script>
  <script src="{{ asset('assets') }}/js/misc.js"></script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js" integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script>
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })
  </script>
  <!-- endinject -->
  <!-- Custom js for this page -->
  <!-- End custom js for this page -->
  @stack('js')
  @stack('script')
</body>

</html>
