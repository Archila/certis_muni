@extends('plantilla.plantilla',['sidebar'=>51])

@section('titulo', 'Nuevo encargado')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('empresa.index')}}">Empresas</a></li>
    <li class="breadcrumb-item active">Agregar area</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe empresa con ese nombre')</script>
  @endif  
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3>Crear un nuevo encargado @if(Auth::user()->rol->id !=2 ) sin empresa @endIf</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('encargado.guardar')}}" novalidate>   
    @csrf
    <input type="hidden" name="solo_encargado" value=1>        
    <div id="encargado-nuevo" style="display: block">
        <div class="form-row">
            <div class="col-md-5 mb-3">
                <label for="validationCustom08">Nombre</label>
                <input type="text" class="form-control" id="validationCustom08" name="nombre" required> 
                <div class="invalid-feedback">
                Ingrese nombre de encargado válido.
                </div>      
            </div>    
            <div class="col-md-5 mb-3">
                <label for="validationCustom08">Apellido</label>
                <input type="text" class="form-control" id="validationCustom08" name="apellido" required> 
                <div class="invalid-feedback">
                Ingrese nombre de encargado válido.
                </div>      
            </div>   
            <div class="col-md-2 mb-3">
                <label for="validationCustom09">Teléfono</label>
                <input type="text" class="form-control" id="validationCustom09" name="telefono" required >
                <div class="invalid-feedback">
                Ingrese telefono de encargado válido. Al menos 8 dígitos.
                </div>
            </div>         
            <small class="mt-n3 mb-2">&nbsp; &nbsp; *Se recomienda agregar el título de tratamiento al nombre del encargado. Ejemplo: Ing. Lic. Sr. Sra.</small>               
        </div>

        <div class="form-row">
            <div class="col-md-3 mb-3">
                <label for="validationCustom08">Colegiado</label>
                <input type="text" class="form-control" id="validationCustom08" name="colegiado">                   
            </div>    
            <div class="col-md-5 mb-3">
                <label for="validationCustom08">Profesión</label>
                <input type="text" class="form-control" id="validationCustom08" name="profesion" required> 
                <div class="invalid-feedback">
                Ingrese profesión del encargado.
                </div>      
            </div> 
            <div class="col-md-4 mb-3">
                <label for="validationCustom10">Correo</label>
                <input type="email" class="form-control" id="validationCustom10" name="correo" required >
                <div class="invalid-feedback">
                Ingrese un correo electrónico válido.
                </div>
            </div>    
        </div>

        @if(Auth::user()->rol->id==2 )
        @if($empresa)
        <hr>
        <div class="form-row">
          <h5>Encargado de prácticas en: <b>{{$empresa->nombre}}</b></h5>
          <input type="hidden" name="empresa_id" value="{{$empresa->id}}">
          <div class="col-md-6 mb-3">
              <label for="validationCustom08">Area</label>
              <input type="text" class="form-control" id="validationCustom08" name="area" required placeholder="Ej. Recursos Humanos">   
              <div class="invalid-feedback">
              Ingrese área a la que pertenece el encargado.
              </div>                 
          </div>    
          <div class="col-md-6 mb-3">
              <label for="validationCustom10">Puesto</label>
              <input type="text" class="form-control" id="validationCustom10" name="puesto" required placeholder="Ej. Gerente de RRHH" >
              <div class="invalid-feedback">
              Por favor ingrese información.
              </div>
          </div>    
        </div>
        @endIf
        @endIf
    </div>

    <div class="float-sm-right">
      <button class="btn btn-primary" type="submit">Guardar</button>
      <a class="btn btn-secondary" href="{{url()->previous()}}" role="cancelar">Regresar</a>
    </div>    
  </form>
  </div>
</div>
@endsection

@section('page_script')
<!-- page script -->
<script>    
  $(function () {    
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
  })
</script>
<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    var checkBox = document.getElementById("cbx_encargado");
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


</script>
@endsection
