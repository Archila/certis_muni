@extends('plantilla.plantilla',['sidebar'=>71])

@section('titulo', 'Nueva contraseña')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
@endsection

@section('alerta')
  @if (session('validado'))
  <script> alerta_create('Validación exitosa.')</script>
  @else
    
  @endif
@endsection

@section('contenido')
<div class="card col-md-4 offset-md-4">
  <div class="card-header">
    <h3>Cambio de contraseña</h3> 
  </div>
  @if (session('validado'))
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('usuario.actualizar')}}" novalidate>    
    @csrf
    <div class="form-row">
      <div class="col-12 mb-3">
        <label for="validationCustom03">Nueva contraseña</label>
        <input type="password" class="form-control" id="validationCustom03" required name="clave1" autofocus>
        <div class="invalid-feedback">
          Por favor ingrese su nueva contraseña
        </div>         
      </div>    
      <div class="col-12 mb-3">
        <label for="validationCustom03">Confirmar contraseña</label>
        <input type="password" class="form-control" id="validationCustom03" required name="clave2" autofocus>
        <div class="invalid-feedback">
          Por favor ingrese su nueva contraseña
        </div>         
      </div> 
        @if (session('error')=='ERROR')
        <small style="color:red">
            Las contraseñas no son iguales.
        </small>
        @endif      
    </div>
    <div class="float-sm-right">
      <button class="btn btn-primary" type="submit">Cambiar</button>      
    </div>    
  </form>
  </div>
  @else
    
  @endif
  
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

