@extends('plantilla.plantilla',['sidebar'=>81])

@section('titulo', 'Nuevo supervisor')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('supervisor.index')}}">Supervisores</a></li>
    <li class="breadcrumb-item active">Nuevo supervisor</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe supervisor con ese número de colegiado')</script>
  @endif
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3>Crear nuevo supervisor</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('supervisor.guardar')}}" novalidate >    
    @csrf
    <div class="form-row">
      <div class="col-md-6 col-sm-12 mb-3">
        <label for="validationCustom01">Nombres</label>
        <input type="text" class="form-control" id="validationCustom01" required name="nombre" autofocus>
        <div class="invalid-feedback">
          Por favor ingrese nombre del supervisor
        </div>
      </div>      
      <div class="col-md-6 col-sm-12 mb-3">
        <label for="validationCustom02">Apellidos</label>
        <input type="text" class="form-control" id="validationCustom02" required name="apellido">
        <div class="invalid-feedback">
          Por favor ingrese apellido del supervisor 
        </div>
      </div>      
    </div>
    <div class="form-row">
        <div class="col-md-2 col-sm-12 mb-3">
            <label for="validationCustom03">Telefono</label>
            <input type="text" class="form-control" id="validationCustom03" minlength="8"  required name="telefono">
            <div class="invalid-feedback">
            Ingrese un valor numérido de al menos 8 dígitos.
            </div>
        </div>      
        <div class="col-md-3 col-sm-12 mb-3">
            <label for="validationCustom03">Correo electrónico</label>
            <input type="email" class="form-control" id="validationCustom03"  required name="correo">
            <div class="invalid-feedback">
            Ingrese un correo válido.
            </div>
        </div>      
        <div class="col-md-2 col-sm-12 mb-3">
            <label for="validationCustom03">No. Colegiado</label>
            <input type="number" min=1 class="form-control" id="validationCustom03" minlength="6"  required name="colegiado">
            <div class="invalid-feedback">
            Ingrese un valor numérido de al menos 6 dígitos.
            </div>
        </div>      
        <div class="col-md-5 col-sm-12 mb-3">
            <label for="validationCustom04">Profesión</label>
            <input type="text" class="form-control" id="validationCustom04" minlength="9" required name="profesion">
            <div class="invalid-feedback">
            Por favor ingresar profesión del supervisor.
            </div>
        </div>      
    </div>    
    <div class="float-sm-right">
      <button class="btn btn-primary" type="submit">Crear</button>
      <a class="btn btn-secondary" href="{{route('supervisor.index')}}" role="cancelar">Regresar</a>
    </div>    
  </form>
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
