@extends('plantilla.plantilla',['sidebar'=>41])

@section('titulo', 'Editar empresa')

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
    <h3>Aregar area a empresa: {{$empresa->nombre}}</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('encargado.guardar')}}" novalidate>   
    @csrf
    <input type="hidden" name="solo_encargado" value=0>
    <input type="hidden" name="empresa_id" value="{{$empresa->empresa_id}}">
    <div class="form-row">      

        <div class="form-group">
            <div class="custom-control custom-switch">
                <input type="checkbox" checked class="custom-control-input" id="cbx_encargado" onclick="cbxEncargado()" name="nuevo" >
                <label class="custom-control-label" for="cbx_encargado">Nuevo encargado</label>
            </div>
        </div>          
    </div>

    <div id="encargado-nuevo" style="display: block">
        <div class="form-row">
            <div class="col-md-3 mb-3">
                <label for="validationCustom08">Nombre</label>
                <input type="text" class="form-control" id="validationCustom08" name="nombre" required> 
                <div class="invalid-feedback">
                Ingrese nombre de encargado válido.
                </div>      
            </div>    
            <div class="col-md-3 mb-3">
                <label for="validationCustom08">Apellido</label>
                <input type="text" class="form-control" id="validationCustom08" name="apellido" required> 
                <div class="invalid-feedback">
                Ingrese nombre de encargado válido.
                </div>      
            </div>   
            <div class="col-md-2 mb-3">
                <label for="validationCustom09">Teléfono contacto</label>
                <input type="text" class="form-control" id="validationCustom09" name="telefono" required >
                <div class="invalid-feedback">
                Ingrese telefono de encargado válido. Al menos 8 dígitos.
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="validationCustom10">Correo contacto</label>
                <input type="email" class="form-control" id="validationCustom10" name="correo" required >
                <div class="invalid-feedback">
                Ingrese un correo electrónico válido.
                </div>
            </div>                
        </div>

        <div class="form-row">
            <div class="col-md-2 mb-3">
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
            <div class="col-md-5 mb-3">
                <label for="validationCustom08">Puesto</label>
                <input type="text" class="form-control" id="validationCustom08" name="puesto" required> 
                <div class="invalid-feedback">
                Ingrese profesión del encargado.
                </div>      
            </div>               
        </div>
    </div>

    <div id="encargado-existente" style="display: none">
        <div class="form-row">
            <div class="col-md-8 mb-3">
                <label for="select_tipo">Encargados en el sistema</label>                   
                <select id="select_tipo" class="form-control" name="encargado_id">
                    <option disabled value=0 >Seleccione un encargado</option>
                    @foreach ($encargados as $e)                    
                    <option value="{{$e->encargado_id}}">{{$e->nombre}} {{$e->apellido}} ({{$e->profesion}})</option>                   
                    @endforeach
                </select>
                <div class="invalid-feedback">
                Por favor seleccione un encargado
                </div>
            </div>
        </div>        
    </div>    

    <div class="form-row">
        <div class="col-md-5 mb-3">
            <label for="validationCustom08">Area</label>
            <input type="text" class="form-control" id="validationCustom08" name="area" required placeholder="Ej. Recursos Humanos">   
            <div class="invalid-feedback">
            Ingrese área a la que pertenece el encargado.
            </div>                 
        </div>    
        <div class="col-md-7 mb-3">
            <label for="validationCustom08">Descripción</label>
            <input type="text" class="form-control" id="validationCustom08" name="descripcion">                  
        </div>               
    </div>

    <div class="float-sm-right">
      <button class="btn btn-primary" type="submit">Guardar</button>
      <a class="btn btn-secondary" href="{{route('empresa.index')}}" role="cancelar">Regresar</a>
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
        if (checkBox.checked == true){
            if (form.checkValidity() === false) {
                event.preventDefault();
                event.stopPropagation();
            }
        }        
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>

<script>
function cbxEncargado(){
    var forms = document.getElementsByClassName('needs-validation');
    //forms[0].classList.remove('was-validated');
    // Get the checkbox
    var checkBox = document.getElementById("cbx_encargado");    

    // If the checkbox is checked, display the output
    if (checkBox.checked == true){
        $('#encargado-existente').hide(200);
        $('#encargado-nuevo').show(600);
    } else {
        $("#encargado-nuevo").hide(200);
        $("#encargado-existente").show(600);
    }
}

cbxEncargado();

</script>
@endsection
