@extends('plantilla.plantilla',['sidebar'=>65])

@section('titulo', 'Prácticas finales')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('practica.index')}}">Prácticas finales</a></li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe solicitud en el sistema')</script>
  @endif
@endsection

@section('contenido')
<div class="card">
    <div class="card-header">
        <h3>Prácticas finales</h3> 
    </div>

    <div class="card-body">
    
    @empty($bitacora)<!-- ESTUDIANTE SIN BITACORA -->
      @empty($oficio) <!-- ESTUDIANTE SIN BITACORA NI OFICIO -->
      <div class="row">
        <div class="col-12">
          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title">Solicitud practicas finales</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">              
              <h5 class="col-sm-6 "><b>No hay solicitud</h5>
              <h5 class="col-sm-12">Para poder iniciar su proceso, por favor ingrese una solicitud de prácticas finales. </h5>
              <br>
              <a  href="{{route('practica.solicitud')}}"><button class="btn btn-success">Nueva solicitud</button></a>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>        
        
      @else <!-- ESTUDIANTE SIN BITACORA PERO CON OFICIO -->

      <div class="row">
        <div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Solicitud practicas finales</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">              
              <div class="row">                  
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Creación:  </span>
                      <span class="info-box-number text-center text-muted mb-0">{{date('d-m-Y', strtotime($oficio->created_at))}}</span>
                      </div>
                  </div>
                </div>
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Aprobada: </span>
                      <span class="info-box-number text-center text-muted mb-0">
                      @if($oficio->aprobado) <span class="badge bg-success">SI</span> @else <span class="badge bg-danger">NO</span> @endif
                      <span>
                      </div>
                  </div>
                </div>
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Tipo: </span>
                      <span class="info-box-number text-center text-muted mb-0">
                      @if($oficio->tipo == 1) Docencia @elseif($oficio->tipo == 2) Investigación @else Aplicada @endif
                      <span>
                      </div>
                  </div>
                </div>
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Semestre: </span>
                      <span class="info-box-number text-center text-muted mb-0">
                      @if($oficio->semestre == 1) Primero @else Segundo @endif
                      <span>
                      </div>
                  </div>
                </div>
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Año: </span>
                      <span class="info-box-number text-center text-muted mb-0">{{$oficio->year}}<span>
                      </div>
                  </div>
                </div> 
              </div> 
              <!-- /.FIN ROW 1 -->

              <dl class="row">
                <dd class="col-sm-12 mb-n1"> <b>Empresa: </b> {{$oficio->empresa}}</dd>
                <dd class="col-sm-6 "> <b>Dirección: </b> {{$oficio->direccion}}</dd>
                <dd class="col-sm-6 "> <b>Ubicación: </b> {{$oficio->ubicacion}}</dd>
                <dd class="col-sm-4 "> <b>Estudiante: </b> {{$oficio->estudiante}}</dd>
                <dd class="col-sm-3 "> <b>Carne: </b> {{$oficio->carne}}</dd>
                <dd class="col-sm-3 "> <b>Registro: </b> {{$oficio->registro}}</dd>       

                <dd class="col-sm-6 mb-n1"> <b>Destinatario: </b> {{$oficio->destinatario}}</dd>      
                <dd class="col-sm-6 mb-n1"> <b>Saludo: </b> {{$oficio->encabezado}}</dd>     
                @if($oficio->tipo == 1) 
                <dd class="col-sm-10 mb-n1"> <b>Curso: </b> {{$oficio->curso}}</dd>
                <dd class="col-sm-2 mb-n1"> <b>Código: </b> {{$oficio->codigo_curso}}</dd>
                @elseif($oficio->tipo == 2) 
                <dd class="col-sm-10 mb-n1"> <b>Tema o investigación: </b>"{{$oficio->curso}}"</dd>
                @else
                <dd class="col-sm-10 mb-n1"> <b>Puesto: </b>{{$oficio->puesto}}</dd>
                @endif
              </dl>                   

              <div class="row"> 
              @if($oficio->aprobado) 
                <div class="callout callout-success">
                  <h5 > <i class="icon fas fa-check"></i> La solicitud de prácticas ya fue aprobada. Si ya ha recibido la respuesta afirmativa de la contraparte institucional, por favor proceda a crear una bitácora. </h5>
                  <br>
                  <a  href="{{route('bitacora.crear')}}"><button class="btn btn-success">Nueva bitácora</button></a>
                </div>              
              @else 
                <div class="callout callout-warning">
                  <h5> <i class="icon fas fa-exclamation-triangle"></i> La solicitud de prácticas no ha sido aprobada, por favor espere o contácte con su supervisor de prácticas finales.</h5>
                </div>
              @endif
              
              </div>
              <!-- /.FIN ROW 3 -->

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      @endempty <!-- FIN ESTUDIANTE SIN BITACORA CON/SIN OFICIO -->
    @else<!-- ESTUDIANTE CON BITACORA -->        
    
    @endempty <!-- FIN CON/SIN BITACORA -->
    
    </div>

</div>
@endsection

@section('page_script')
<!-- page script -->
<script>
   
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

