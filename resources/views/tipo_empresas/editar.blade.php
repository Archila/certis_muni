@extends('plantilla.plantilla',['sidebar'=>47])

@section('titulo', 'Editar tipo empresa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('empresa.index')}}">Empresas</a></li>
    <li class="breadcrumb-item"><a href="{{route('tipo_empresa.index')}}">Tipo de empresas</a></li>
    <li class="breadcrumb-item active">Editar tipo empresa</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe tipo empresa con ese nombre')</script>
  @endif
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3>Editar tipo empresa</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('tipo_empresa.actualizar', $tipo->id)}}" novalidate>  
    @method('PUT')     
    @csrf
    <div class="form-row">
      <div class="col-md-4 mb-3">
        <label for="validationCustom03">Nombre del tipo de empresa</label>
        <input type="text" class="form-control" id="validationCustom03" required name="nombre" autofocus value="{{$tipo->nombre}}">
        <div class="invalid-feedback">
          Por favor ingrese nombre de 
        </div>
      </div>      
      <div class="col-md-6 mb-3">
        <label for="validationCustom05">Descripción</label>
        <input type="text" class="form-control" id="validationCustom05" name="descripcion" value="{{$tipo->descripcion}}">       
      </div>
      <div class="col-md-2 mb-3">
        <label for="validationCustom06">Activo</label><br>
        @if($tipo->activo==1) @php $checked='checked'; @endphp @endif
        <input type="checkbox" {{ $checked ?? ''}} data-bootstrap-switch data-off-color="danger" data-on-color="success" name="activo">        
      </div>
    </div>
    <div class="float-sm-right">
      <button class="btn btn-success" type="submit">Guardar</button>
      <a class="btn btn-secondary" href="{{route('tipo_empresa.index')}}" role="cancelar">Regresar</a>
    </div>    
  </form>
  </div>
</div>
@endsection


@section('page_script')
<!-- Page script -->
<script>
  $(function () {    
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
  })
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

