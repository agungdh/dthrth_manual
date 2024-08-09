@php
    $user = auth()->user();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DTHRTH</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="/assets/AdminLTE-3.2.0/plugins/fontawesome-free/css/all.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="/assets/AdminLTE-3.2.0/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Toastr -->
  <link rel="stylesheet" href="/assets/AdminLTE-3.2.0/plugins/toastr/toastr.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="/assets/AdminLTE-3.2.0/dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
          <img src="/assets/Angular_gradient.png" class="user-image img-circle elevation-2" alt="User Image">
        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <!-- User image -->
          <li class="user-header bg-primary">
            <img src="/assets/Angular_gradient.png" class="img-circle elevation-2" alt="User Image">

            <p>
              {{$user->nama}}
              <small>{{$user->username}}</small>
            </p>
          </li>
          <!-- Menu Footer-->
          <li class="user-footer">
            <a href="/profil" class="btn btn-default btn-flat">Profil</a>
            <a href="/logout" class="btn btn-default btn-flat float-right">Sign out</a>
          </li>
        </ul>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/assets/AdminLTE-3.2.0/index3.html" class="brand-link">
      <img src="/assets/Angular_gradient.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">DTHRTH</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      @include('layouts.components.menu')
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">

    </section>

    <!-- Main content -->
    <section class="content">

        @yield('content')

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <strong>Copyright &copy; {{date('Y')}}.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="/assets/AdminLTE-3.2.0/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/assets/AdminLTE-3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="/assets/AdminLTE-3.2.0/plugins/sweetalert2/sweetalert2.min.js"></script>
<!-- Toastr -->
<script src="/assets/AdminLTE-3.2.0/plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="/assets/AdminLTE-3.2.0/dist/js/adminlte.min.js"></script>

<script defer src="/assets/alpine-3.14.1.min.js"></script>
<script src="/assets/axios-1.7.3.min.js"></script>
@include('layouts.scripts.axios-interceptor')

@stack('js')

</body>
</html>
