@extends('plantilla.plantilla',['sidebar'=>91])

@section('titulo', 'Nuevo rol')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('rol.index')}}">Roles</a></li>
    <li class="breadcrumb-item active">Nuevo rol</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe rol con ese nombre')</script>
  @endif
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3>Crear nuevo rol</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('rol.guardar')}}" novalidate>    
    @csrf
    <div class="form-row">
      <div class="col-md-5 mb-3">
        <label for="validationCustom03">Nombre del rol</label>
        <input type="text" class="form-control" id="validationCustom03" required name="nombre" autofocus>
        <div class="invalid-feedback">
          Por favor ingrese nombre de la carrera
        </div>
      </div>      
      <div class="col-md-7 mb-3">
        <label for="validationCustom05">Descripcion</label>
        <input type="text" class="form-control" id="validationCustom05" required name="descripcion">        
      </div>      
    </div>
    <div class="float-sm-right">
      <button class="btn btn-primary" type="submit">Crear</button>
      <a class="btn btn-secondary" href="{{url()->previous()}}" role="cancelar">Regresar</a>
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