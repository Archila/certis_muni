@extends('plantilla.plantilla',['sidebar'=>65])

@section('titulo', 'Crear folio')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('bitacora.index')}}">Bitácora</a></li>
    <li class="breadcrumb-item"><a href="{{route('bitacora.ver', $bitacora->id)}}">Semestre {{$bitacora->semestre}} ({{$bitacora->year}})</a></li>
    <li class="breadcrumb-item active">Crear PDF</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe folio con ese número')</script>
  @endif
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3>Generar Archivos PDF</h3> 
  </div>
  <div class="card-body">
  @if($bitacora->oficio || $bitacora->valida)
    <div id="accordion">

    @if($bitacora->oficio)
      <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
      <div class="card card-info">
        <div class="card-header">
          <h4 class="card-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
              Generar Oficio
            </a>
          </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in">
          <div class="card-body">
            <form class="needs-validation" method="POST" action="{{route('pdf.oficio', $bitacora->id)}}" novalidate>
            @csrf
              <div class="custom-control custom-checkbox">
                <input class="custom-control-input" type="checkbox" id="cbx_encargado" value="true" checked onclick="cbxEncargado()" name="cbx_encargado">
                <label for="cbx_encargado" class="custom-control-label"><h5>Utilizar datos del encargado de la bitácora.</h5></label>
              </div>    
              <div id="div-encargado" style="display: block">
                <div class="form-row">
                  <div class="col-md-5 mb-3">
                      <label for="validationCustom08">Destinatario</label>
                      <input type="text" class="form-control encargado" id="validationCustom08" name="destinatario"  > 
                      <div class="invalid-feedback">
                        Nombre de la persona a la cual va dirigido el oficio.
                      </div>      
                  </div>    
                  <div class="col-md-5 mb-3">
                      <label for="validationCustom08">Puesto</label>
                      <input type="text" class="form-control encargado" id="validationCustom08" name="puesto"  > 
                      <div class="invalid-feedback">
                        Ingrese el puesto de la personaa la cual va dirigido el oficio.
                      </div>      
                  </div>  
                </div>
              </div>
              <div class="float-sm-right">
                <button class="btn btn-primary" type="submit">Crear</button>
                <a class="btn btn-secondary" href="{{url()->previous()}}" role="cancelar">Regresar</a>
              </div>    
            </form>
          </div>
        </div>
      </div>
      @endif
      @if($bitacora->valida )
      <div class="card card-info">
        <div class="card-header">
          <h4 class="card-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
              Generar Caratula de bitácora
            </a>
          </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse in">
          <div class="card-body">
            <dl class="row">
              <dt class="col-sm-2">Bitacora No. </dt>
              <dd class="col-sm-4">{{$bitacora->codigo}}</dd>
              <dt class="col-sm-3">Horas totales:</dt>
              <dd class="col-sm-3">{{$bitacora->horas}}</dd>
              <dt class="col-sm-2">Tipo:</dt>
              <dd class="col-sm-4">@if($bitacora->tipo==1) Docencia @endif @if($bitacora->tipo==2) Investigación @endif @if($bitacora->tipo==3) Aplicada @endif</dd>
              <dt class="col-sm-3">Fecha extensión:</dt>
              <dd class="col-sm-3">{{$bitacora->f_aprobacion}}</dd>
              <dt class="col-sm-2">Estudiante:</dt>
              <dd class="col-sm-10">{{$estudiante->nombre}}&nbsp;{{$estudiante->apellido}}. Carne:&nbsp;<b>{{$estudiante->carne}}</b>. Registro: 
              <b>{{$estudiante->registro}}</b>. De la carrera de {{$estudiante->carrera}}.
              </dd>
              <dt class="col-sm-2">Empresa:</dt>
              <dd class="col-sm-10">{{$empresa->nombre}}&nbsp;{{$estudiante->direccion}}. Ubicada en:&nbsp;{{$empresa->ubicacion}}. </dd>
              <dt class="col-sm-2">Encargado:</dt>
              <dd class="col-sm-10">{{$encargado->nombre}}&nbsp;{{$encargado->apellido}}. Puesto en la empresa:&nbsp;{{$encargado->puesto}}</dd>
            </dl>
          <a href="{{route('pdf.caratula', $bitacora->id)}}" type="button" class="btn btn-block btn-success ">Generar Archivo PDF</a>
          </div>
        </div>
      </div>
      <div class="card card-info">
        <div class="card-header">
          <h4 class="card-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
              Generar folios vacios para llenar a mano
            </a>
          </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse in">
          <div class="card-body">
          <a href="{{route('pdf.caratula', $bitacora->id)}}" type="button" class="btn btn-block btn-success ">Generar folios vacios.</a>
          </div>
        </div>
      </div>
      @endif
    </div> 
    
  @else
    <div class="callout callout-danger">
      <h4><i class="fas fa-exclamation"></i> Tu bitácora está en proceso de aprobación.</h4>

      <p>Por favor espera o contacta con tu supervisor de prácticas finales.</p>
    </div>
  @endif
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

<script>
function cbxEncargado(){
    var forms = document.getElementsByClassName('needs-validation');
    forms[0].classList.remove('was-validated');
    // Get the checkbox
    var checkBox = document.getElementById("cbx_encargado");    

    // If the checkbox is checked, display the output
    if (checkBox.checked == false){
        $('#div-encargado').show(800);        
        $('.encargado').attr('required',true);
    } else {
        $("#div-encargado").hide(800);
        $('.encargado').removeAttr('required');
    }
}

cbxEncargado();

</script>
@endsection

