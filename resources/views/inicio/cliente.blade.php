@extends('plantilla.plantilla',['sidebar'=>10])

@section('titulo', 'Inicio')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>    
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe solicitud en el sistema')</script>
  @endif
@endsection

@section('contenido')
<div class="container row">
<ul class="navbar-nav ml-auto">
  <li class="nav-item dropdown">
    
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
      <a href="{{route('inicio.index', ['year'=>2020, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2020</a>
      <a href="{{route('inicio.index', ['year'=>2021, 'semestre'=>1])}}" class="dropdown-item">Semestre 1 - 2021</a>
      <a href="{{route('inicio.index', ['year'=>2021, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2021</a>
      <a href="{{route('inicio.index', ['year'=>2022, 'semestre'=>1])}}" class="dropdown-item">Semestre 1 - 2022</a>
      <a href="{{route('inicio.index', ['year'=>2022, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2022</a>
      <a href="{{route('inicio.index', ['year'=>2023, 'semestre'=>1])}}" class="dropdown-item">Semestre 1 - 2023</a>
    </div>
  </li>
</ul>
</div>


<div class="row">
    <h2 class="m-2">VISTA DE CLIENTE</h2>
    <div class="col-md-12">
        <div class="card card-success card-outline"> <!-- Donut chart -->
            <div class="card-header">
              <h3 class="card-title">
                  <i class="far fa-chart-bar"></i>
                  Lista de certificaciones
              </h3>

              <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
              </div>
            </div>
            <div class="card-body">

            <div class="row">
              <form class="form-inline" method="GET" id="searchForm" action="{{route('inicio.index')}}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="page" id="page" value="{{$data->pagina}}">
              <input type="hidden" name="nueva_busqueda" id="nueva_busqueda" value="1">
                <div class="form-group mx-sm-3 mb-2">
                  <label for="inputPassword2" class="sr-only">Licencia</label>
                  <input type="text" class="form-control" name="licencia" placeholder="Licencia" value="{{$data->licencia}}">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                  <label for="inputPassword2" class="sr-only">Expediente</label>
                  <input type="text" class="form-control" name="expediente" placeholder="Expediente" value="{{$data->expediente}}">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                  <label for="inputPassword2" class="sr-only">Propietario</label>
                  <input type="text" class="form-control" name="propietario" placeholder="Propietario" value="{{$data->propietario}}">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                  <label for="inputPassword2" class="sr-only">Inmueble</label>
                  <input type="text" class="form-control" name="inmueble" placeholder="Inmueble" value="{{$data->inmueble}}">
                </div>
                <div class="input-group">                  
                  <div class="input-group-append ml-3">
                    <button class="btn btn-success" onClick=enviarForm()>Buscar</button>
                  </div>
                </div>
              </form>
            </div>

              <table class="table table-sm table-bordered table-striped">
                <thead>
                  <th>Número</th>
                  <th>Fecha Ext.</th>
                  <th>Fecha Pago Lice.</th>
                  <th>No. Licencia.</th>
                  <th>No. Exp.</th>
                  <th>Propietario</th>
                  <th>Ubicación Inmueble</th>
                  <th>Opciones</th>
                </thead>
                @foreach($tabla as $f)
                <tr>
                  <td>{{$f->numero}}</td>
                  <td>{{$f->fecha_extension}}</td>
                  <td>{{$f->fecha_pago_licencia}}</td>
                  <td>{{$f->no_licencia}}</td>
                  <td>{{$f->no_expediente}}</td>
                  <td>{{$f->nombre_propietario}}</td>
                  <td>{{$f->direccion_inmueble}}</td>
                  <td>
                    <a href="{{route('certi.ver', $f->id)}}" type="button" class="btn btn-primary btn-xs"><i class="fas fa-eye"></i></a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
        </div>

        <nav aria-label="...">
          <ul class="pagination">
            @if($data->pagina <= 1)
            <li class="page-item disabled">
              <button class="page-link">Anterior</button>
            </li>
            <li class="page-item active" aria-current="page">
              <button class="page-link" >{{$data->pagina}}</button>
            </li>
            <li class="page-item"><button class="page-link" onClick=siguiente()>{{$data->pagina + 1}}</button></li>
            <li class="page-item">
              <button class="page-link" onClick=siguiente()>Siguiente</button>
            </li>
            @else 
            <li class="page-item">
              <button class="page-link" onClick=anterior()>Anterior</button>
            </li>
            <li class="page-item"><button class="page-link" onClick=anterior()>{{$data->pagina - 1}}</button></li>
            <li class="page-item active" aria-current="page">
              <button class="page-link" >{{$data->pagina}}</button>
            </li>
            <li class="page-item"><button class="page-link" onClick=siguiente()>{{$data->pagina + 1}}</button></li>
            <li class="page-item">
              <button class="page-link" onClick=siguiente()>Siguiente</button>
            </li>
            @endif       
          </ul>
        </nav>
        <!-- /.donut chart -->
    </div>
        


</div>
    
    
@endsection

@section('page_script')
<!-- page script -->
<script>

function anterior(){
  var paginaActual = document.getElementById("page").value;
  document.getElementById("page").value = Number(paginaActual) - 1;
  document.getElementById("searchForm").submit(); 
}

function siguiente(){
  var paginaActual = document.getElementById("page").value;
  document.getElementById("page").value = Number(paginaActual) + 1;
  document.getElementById("searchForm").submit(); 
}

function enviarForm(){
  document.getElementById("page").value = 1;
  document.getElementById("searchForm").submit(); 
}


  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
@endsection

