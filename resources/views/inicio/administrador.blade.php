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
    
  </li>
</ul>
</div>


<div class="row">
    <h2 class="m-2">VISTA DE ADMINISTRADOR</h2>
    <div class="col-md-12">
        <div class="card card-primary card-outline"> <!-- Donut chart -->
            <div class="card-header">
            <h3 class="card-title">
                <i class="far fa-chart-bar"></i>
                Listado de certificaciones
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
            </div>
            </div>
            <div class="card-body">
              <!-- @include('inicio.tabla',['tabla'=>$tabla]) -->

              <div class="row">
                <div class="col col-md-3">
                  Página: {{$data->pagina}}
                </div>
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
            <form class="form-inline" method="GET" id="paginationForm" action="{{route('inicio.index')}}" enctype="multipart/form-data">
            @csrf 
            <input type="hidden" name="page" id="page" value="{{$data->pagina}}">
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
            </form>            
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
  document.getElementById("paginationForm").submit(); 
}

function siguiente(){
  var paginaActual = document.getElementById("page").value;
  document.getElementById("page").value = Number(paginaActual) + 1;
  document.getElementById("paginationForm").submit(); 
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

