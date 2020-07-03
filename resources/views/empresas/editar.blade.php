@extends('plantilla.plantilla',['sidebar'=>41])

@section('titulo', 'Editar empresa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('empresa.index')}}">Empresas</a></li>
    <li class="breadcrumb-item active">Editar empresa</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe empresa con ese nombre')</script>
  @endif  
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3>Editar empresa: {{$empresa->nombre}}</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('empresa.actualizar', $empresa->empresa_id)}}" novalidate>   
    @method('PUT') 
    @csrf
    <div class="form-row">
      <div class="col-md-4 mb-3">
        <label for="validationCustom03">Nombre de la empresa</label>
        <input type="text" class="form-control" id="validationCustom03" required name="nombre" autofocus value="{{$empresa->nombre}}">
        <div class="invalid-feedback">
          Por favor ingrese nombre de la carrera
        </div>
      </div>    
      <div class="col-md-4 mb-3">
        <label for="validationCustom04">Direccion</label>
        <input type="text" class="form-control" id="validationCustom04" placeholder="# Casa, Avenida, Zona." required name="direccion" value="{{$empresa->direccion}}">
        <div class="invalid-feedback">
          Ingrese una dirección para la empresa
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="validationCustom04">Ubicación</label>
        <input type="text" class="form-control" id="validationCustom04" placeholder="Municipio, Departamento" required name="ubicacion" value="{{$empresa->ubicacion}}">
        <div class="invalid-feedback">
          Ingrese una ubicación para la empresa
        </div>
      </div>
    </div>

    <div class="form-row">
      <div class="col-md-3 mb-3">
        <label for="validationCustom05">Alias</label>
        <input type="text" class="form-control" id="validationCustom05" name="alias" value="{{$empresa->alias}}">       
      </div>    
      <div class="col-md-3 mb-3">
        <label for="validationCustom06">Correo</label>
        <input type="email" class="form-control" id="validationCustom06" required name="correo" value="{{$empresa->correo}}">
        <div class="invalid-feedback">
          Ingrese una dirección de correo electrónico válida.
        </div>
      </div>
      <div class="col-md-2 mb-3">
        <label for="validationCustom07">Teléfono</label>
        <input type="text" class="form-control" id="validationCustom07" minlength="8" required name="telefono" value="{{$empresa->telefono}}">
        <div class="invalid-feedback">
          Ingrese un número telefónico de al menos 8 dígitos.
        </div>
      </div>
      <div class="col-4">
          <div class="row">
            <div class="col-md-3 mb-3">
                <label for="validationCustom06">Público</label><br>
                @if($empresa->publico==1) @php $checked1='checked'; @endphp @endif
                <input type="checkbox" {{ $checked1 ?? ''}} data-bootstrap-switch data-off-color="danger" data-on-color="success" name="publico">        
            </div>
            <div class="col-md-3 mb-3">
                <label for="validationCustom06">Válido</label><br>
                @if($empresa->valido==1) @php $checked2='checked'; @endphp @endif
                <input type="checkbox" {{ $checked2 ?? ''}} data-bootstrap-switch data-off-color="danger" data-on-color="success" name="valido">        
            </div>
            <div class="col-md-6 mb-3">        
                <label for="select_calificacion">Calificación</label><br>        
                <select id="select_calificacion" class="form-control" required name="calificacion">
                    <option disabled>Seleccione una calificación</option>                    
                    @if($empresa->calificacion=="Bien")
                    <option value="Bien" selected>Bien</option>
                    @else
                    <option value="Bien">Bien</option>
                    @endif
                    @if($empresa->calificacion=="Regular")
                    <option value="Regular" selected>Regular</option>
                    @else
                    <option value="Regular">Regular</option>
                    @endif
                    @if($empresa->calificacion=="Mala")
                    <option value="Mala" selected>Mala</option>
                    @else
                    <option value="Mala">Mala</option>
                    @endif
                </select>            
            </div>
          </div>
      </div>      
    </div>

    <div class="form-row">
      <div class="col-md-3 mb-3">
        <label for="validationCustom08">Persona de contacto</label>
        <input type="text" class="form-control" id="validationCustom08" name="contacto" value="{{$empresa->activo}}">       
      </div>    
      <div class="col-md-2 mb-3">
        <label for="validationCustom09">Teléfono contacto</label>
        <input type="text" class="form-control" id="validationCustom09" name="tel_contacto" value="{{$empresa->tel_contacto}}">
        <div class="invalid-feedback">
          Ingrese una dirección de correo electrónico válida.
        </div>
      </div>
      <div class="col-md-3 mb-3">
        <label for="validationCustom10">Correo contacto</label>
        <input type="email" class="form-control" id="validationCustom10" name="correo_contacto" value="{{$empresa->correo_contacto}}">
        <div class="invalid-feedback">
          Ingrese un número telefónico de al menos 8 dígitos.
        </div>
      </div>
      <div class="col-md-4 mb-3">
        <label for="select_tipo">Tipo empresa</label>                   
        <select id="select_tipo" class="form-control" required name="tipo_empresa_id">
            <option disabled>Seleccione una carrera</option>
            @foreach ($tipos as $t)
            @if($t->id==$empresa->tipo_empresa_id)
            <option value="{{$t->id}}" selected>{{$t->nombre}}</option>
            @else
            <option value="{{$t->id}}">{{$t->nombre}}</option>
            @endif
            @endforeach
        </select>
        <div class="invalid-feedback">
        Por favor seleccione un tipo de empresa
        </div>
      </div>
    </div>

    <div class="float-sm-right">
      <button class="btn btn-success" type="submit">Editar</button>
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
