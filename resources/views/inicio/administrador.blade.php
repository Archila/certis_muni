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
                Tabla
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                </button>
            </div>
            </div>
            <div class="card-body">
              <!-- @include('inicio.tabla',['tabla'=>$tabla]) -->

              <div class="row">
                <div class="col col-md-2 offset-10">
                <button type="button" class="btn btn-primary btn-block" data-toggle="modal" data-target="#exampleModal">
                  Subir documento
                </button>
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
                  <th>Código Inmueble</th>
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
                    <button type="button" class="btn btn-secondary" data-toggle="tooltip" data-placement="top" title="Pendiente de implementar">
                      Ver
                    </button>
                    <button type="button" class="btn btn-success" data-toggle="tooltip" data-placement="top" title="Pendiente de implementar">
                      Aprobar
                    </button>
                  </td>
                </tr>
                @endforeach
              </table>
          </div>
        </div>
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
            <form method="POST" action="{{route('certi.subir_archivo')}}" enctype="multipart/form-data">
            @csrf 
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

