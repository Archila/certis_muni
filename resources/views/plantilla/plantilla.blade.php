<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>@yield('titulo', 'Inicio')</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{ URL::asset('plugins/fontawesome-free/css/all.min.css') }} ">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ URL::asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
  <!-- Toastr -->
  <link rel="stylesheet" href="{{ URL::asset('plugins/toastr/toastr.min.css') }}">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="{{URL::asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Select2 -->
  <link rel="stylesheet" href="{{ URL::asset('plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{ URL::asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <!-- pace-progress -->
  <link rel="stylesheet" href="{{URL::asset('plugins/pace-progress/themes/black/pace-theme-flat-top.css') }}">  
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ URL::asset('dist/css/adminlte.min.css') }}">  
  <!-- summernote -->
  <link rel="stylesheet" href="{{URL::asset('plugins/summernote/summernote-bs4.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  @yield('css')
</head>
<body class="hold-transition sidebar-mini pace-danger">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
    
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <!-- 
      <li class="nav-item d-none d-sm-inline-block">
        <a href="/" class="nav-link">Inicio</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('estudiante.index')}}" class="nav-link">Estudiantes</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{route('carrera.index')}}" class="nav-link">Carreras</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Reportes</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">        
            
      </li>
      -->
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-power-off"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">       
          <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
            {{ __('Cerrar sesión') }}
          </a>
        </div>
      </li>      
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
            class="fas fa-info"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{ URL::asset('dist/img/logo_cunoc.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">CUNOC</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ URL::asset('dist/img/user.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>          
        </div>
      </div>      
      @include('plantilla.sidebar_simple',['sidebar'=>$sidebar])
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">          
          <div class="col-sm-12">
            <ol class="breadcrumb float-sm-left">
                @yield('breadcrumb')
              
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    
    
    <!-- Main content -->
    <div class="content">
    @include('plantilla.error')
      <div class="container-fluid">        
        @yield('contenido')
      
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Información</h5>
            
      <hr>
      <h5>Contacto</h5>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- FORM Para cerrar sesion -->
  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
  </form>

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2019 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    <strong>Desarrollado por  <a href="https://kodsolutions.net">&copy; KOD Solutions</a>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ URL::asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ URL::asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- SweetAlert2 -->
<script src="{{ URL::asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Select2 -->
<script src="{{URL::asset('plugins/select2/js/select2.full.min.js')}}"></script>
<!-- DataTables -->
<script src="{{ URL::asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- bs-custom-file-input -->
<script src="{{ URL::asset('plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<!-- Bootstrap Switch -->
<script src="{{ URL::asset('plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ URL::asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ URL::asset('dist/js/adminlte.min.js') }}"></script>
<!-- FLOT CHARTS -->
<script src="{{ URL::asset('plugins/flot/jquery.flot.js') }}"></script>
<!-- FLOT RESIZE PLUGIN - allows the chart to redraw when the window is resized -->
<script src="{{ URL::asset('plugins/flot-old/jquery.flot.resize.min.js') }}"></script>
<!-- FLOT PIE PLUGIN - also used to draw donut charts -->
<script src="{{ URL::asset('plugins/flot-old/jquery.flot.pie.min.js') }}"></script>
<!-- Summernote -->
<script src="{{URL::asset('plugins/summernote/summernote-bs4.min.js')}}"></script>

<script type="text/javascript">
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3500
  });    

  function alerta_create(msg){
    Toast.fire({
        icon: 'success',
        title: msg
    })
  }    

  function alerta_edit(msg){
    Toast.fire({
        icon: 'success',
        title: msg
    })
  }    

  function alerta_delete(msg){
    Toast.fire({
        icon: 'warning',
        title: msg
    })
  }    

  function alerta_error(msg){
    Toast.fire({
        icon: 'error',
        title: msg
    })
  }   

  function alerta_info(msg){
    Toast.fire({
        icon: 'info',
        title: msg
    })
  }   
  
</script>

@yield('page_script')
@yield('alerta')
</body>
</html>