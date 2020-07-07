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
    <h3>Generar Archivo PDF</h3> 
  </div>
  <div class="card-body">
  <div class="row">
    <div class="col-md-6">
    <a href="{{route('pdf.oficio', $bitacora->id)}}" type="button" class="btn btn-block btn-info "><i class="fas fa-file-pdf"></i> Oficio</a>
    </div>
    <div class="col-md-6">
    <a href="{{route('pdf.bitacora', $bitacora->id)}}" type="button" class="btn btn-block btn-primary "><i class="fas fa-file-pdf"></i> Bitacora completa</a>
    </div>
  </div>
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

