@extends('plantilla.plantilla',['sidebar'=>71])

@section('titulo', 'Cambiar contraseña')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Contraseña incorrecta, intente de nuevo')</script>
  @endif
@endsection

@section('contenido')
<div class="card col-md-4 offset-md-4">
  <div class="card-header">
    <h3>Cambio de contraseña</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('usuario.confirmar')}}" novalidate>    
    @csrf
    <div class="form-row">
      <div class="col-12 mb-3">
        <label for="validationCustom03">Ingrese contraseña actual</label>
        <input type="password" class="form-control" id="validationCustom03" required name="clave" autofocus>
        <div class="invalid-feedback">
          Por favor ingrese su contraseña
        </div>
        @if (session('error')=='ERROR')
        <small style="color:red">
          Contraseña incorrecta, intente de nuevo.
        </small>
        @endif        
      </div>     
    </div>
    <div class="float-sm-right">
      <button class="btn btn-primary" type="submit">Verificar</button>
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

