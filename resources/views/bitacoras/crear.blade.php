@extends('plantilla.plantilla',['sidebar'=>61])

@section('titulo', 'Nueva bitácora')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('bitacora.index')}}">Bitácora</a></li>
    <li class="breadcrumb-item active">Nueva bitácora</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe bitácora con ese semestre y año')</script>
  @endif
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3>Crear nueva bitácora</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('bitacora.guardar')}}" novalidate>    
    @csrf
    <div class="form-row">
      <div class="col-md-5 mb-3">
        <label for="validationCustom03">Semestre</label>
        <select id="validationCustom07" class="form-control" required name="semestre">
            <option disabled>Seleccione un semestre</option>
            <option value="1">Primer semestre</option>
            <option value="2">Segundo semestre</option>
        </select>
        <div class="invalid-feedback">
        Por favor seleccione un semestre
        </div>
      </div>      
      <div class="col-md-3 mb-3">
        <label for="validationCustom05">Año</label>
        <select id="validationCustom07" class="form-control" required name="year">
            <option disabled>Seleccione un semestre</option>
            <option value="2020">2020</option>
            <option value="2021">2021</option>
            <option value="2022">2022</option>
        </select>
        <div class="invalid-feedback">
        Por favor seleccione un año
        </div>
      </div>
      
    </div>
    <div class="float-sm-right">
      <button class="btn btn-primary" type="submit">Crear</button>
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

