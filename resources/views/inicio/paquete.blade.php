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
    @if ($user->rol->id == 1)
    <h2 class="m-2">VISTA DE JEFATURA - CONTROL DE OBRAS</h2>
    @elseif($user->rol->id == 2)
    <h2 class="m-2">VISTA DE ADMINISTRADOR</h2>
    @elseif($user->rol->id == 3)
    <h2 class="m-2">VISTA DE DEPENDENCIA</h2>
    @else
    <h2 class="m-2">Vista de {{$user->rol->nombre}}</h2>
    @endif
    <div class="col-md-12">
        <div class="card card-warning card-outline"> <!-- Donut chart -->
            <div class="card-header">
            <h3 class="card-title">
                <i class="far fa-chart-bar"></i>
                Listado de paquetes
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
            </div>
            </div>
            <div class="card-body">
              <div class="row">
                @if ($user->rol->id == 2)
                <div class="col col-md-2 offset-7">
                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
                  Subir documento
                </button>
                </div>
                @endif
              </div>   

              <form method="GET" id="searchForm" action="{{route('inicio.index')}}" enctype="multipart/form-data">
              @csrf 
              <input type="hidden" name="page" id="page" value="{{$data->pagina}}">
              <input type="hidden" name="nueva_busqueda" id="nueva_busqueda" value="1">
              <div class="row">
                <div class="col col-sm-3">
                  <div class="form-group mb-2">
                    <label for="fecha1" >Fecha inicial </label>
                    <input type="date" class="form-control" id="fecha1" name="fecha_inicio" value="{{$data->fecha_inicio}}">
                  </div>
                </div>
                <div class="col col-sm-3">
                  <div class="form-group mb-2">
                    <label for="fecha2" >Fecha final </label>
                    <input type="date" class="form-control" id="fecha2" name="fecha_fin" value="{{$data->fecha_fin}}">                    
                  </div>
                </div>                
                <div class="col col-sm-1">
                  <div class="input-group-append mb-2 mt-4">
                    <br>
                    <button class="btn btn-success" onClick=enviarForm()>Buscar</button>
                  </div>
                </div>
              </div>
              </form>
            

            <div class="col col-md-3">
                  Página: {{$data->pagina}}
                </div>
              <table class="table table-sm table-bordered table-striped">
                <thead>
                  <th>Fecha</th>
                  <th>Cantidad</th>
                  <th>Observaciones</th>
                  <!-- <th>Creado</th> -->
                  <th>Opciones</th>
                </thead>
                @foreach($tabla as $f)
                <tr>
                  <td>{{date('d/m/Y', strtotime($f->fecha))}}</td>
                  <td>{{$f->cantidad}}</td>
                  <td>{{$f->observaciones}}</td>
                  <!-- <td>{{$f->created_at}}</td> -->
                  <td>
                    <a href="{{route('certi.index', $f->id)}}" type="button" class="btn btn-primary btn-xs"><i class="fas fa-eye"></i></a>
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

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Subir documento CSV</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <br>
      <div class="modal-body">        
          <div class="form-row">     
            <form method="POST" action="{{route('certi.subir_archivo')}}"  enctype="multipart/form-data">
            @csrf 
              <div class="form-group">
                <label for="exampleFormControlInput1">Fecha</label>
                <input type="date" class="form-control" name="fecha">
              </div>
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Observaciones</label>
                <textarea class="form-control" name="observaciones" rows="3"></textarea>
              </div>


              <div class="input-group">
                <div class="">
                  <input type="file" name="file">
                </div>
                <input type="hidden" name="tipo" value=1>
                <div class="input-group-append ml-3">
                  <button class="btn btn-outline-warning" type="submit">Guardar</button>
                </div>
              </div>
            </form>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
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

