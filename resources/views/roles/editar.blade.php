@extends('plantilla.plantilla',['sidebar'=>92])

@section('titulo', 'Editar rol')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('rol.index')}}">Roles</a></li>
    <li class="breadcrumb-item active">Editar rol</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe rol con ese nombre')</script>
  @endif
@endsection

@section('contenido')

<div class="card">
  <div class="card-header">
    <h3>Editar rol</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('rol.actualizar', $rol->id)}}" novalidate> 
    @method('PUT')   
    @csrf
    <div class="form-row">
      <div class="col-md-5 mb-3">
        <label for="validationCustom03">Nombre del rol</label>
        <input type="text" class="form-control" id="validationCustom03" required name="nombre" value="{{$rol->nombre}}">
        <div class="invalid-feedback">
          Por favor ingrese nombre de la carrera
        </div>
      </div>      
      <div class="col-md-7 mb-3">
        <label for="validationCustom05">Descripción</label>
        <input type="text" class="form-control" id="validationCustom05" name="descripcion" value="{{$rol->descripcion}}">        
      </div>      
    </div>
    <div class="float-sm-right">
      <button class="btn btn-success" type="submit">Editar</button>
      <a class="btn btn-secondary" href="{{route('rol.index')}}" role="cancelar">Regresar</a>
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