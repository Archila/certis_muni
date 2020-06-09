@extends('plantilla.plantilla',['sidebar'=>72])

@section('titulo', 'Editar carrera')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('carrera.index')}}">Carreras</a></li>
    <li class="breadcrumb-item active">Editar carrera</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>ERROR</strong> Ya existe una carrera con esos valores, intente nuevos datos.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>       
  @endif    
@endsection

@section('contenido')

<div class="card">
  <div class="card-header">
    <h3>Editar carrera</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('carrera.actualizar', $carrera->id)}}" novalidate> 
    @method('PUT')   
    @csrf
    <div class="form-row">
      <div class="col-md-7 mb-3">
        <label for="validationCustom03">Nombre de la carrera</label>
        <input type="text" class="form-control" id="validationCustom03" required name="nombre" value="{{$carrera->nombre}}">
        <div class="invalid-feedback">
          Por favor ingrese nombre de la carrera
        </div>
      </div>      
      <div class="col-md-3 mb-3">
        <label for="validationCustom05">Código</label>
        <input type="number" min="1" class="form-control" id="validationCustom05" required name="codigo" value="{{$carrera->codigo}}">
        <div class="invalid-feedback">
          Ingrese un código válido
        </div>
      </div>
      <div class="col-md-2 mb-3">
        <label for="validationCustom06">Prefijo</label>
        <input type="text" class="form-control" id="validationCustom06" minlength="4" required name="prefijo" value="{{$carrera->prefijo}}">
        <div class="invalid-feedback">
          Ingrese un prefijo de al menos 4 caracteres.
        </div>
      </div>
    </div>
    <div class="float-sm-right">
      <button class="btn btn-success" type="submit">Editar</button>
      <a class="btn btn-secondary" href="{{route('carrera.index')}}" role="cancelar">Regresar</a>
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