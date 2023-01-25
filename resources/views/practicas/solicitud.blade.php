@extends('plantilla.plantilla',['sidebar'=>61])

@section('titulo', 'Solicitud')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('practica.index')}}">Prácticas</a></li>
    <li class="breadcrumb-item active">Solicitud de practicas finales</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe bitácora con ese semestre y año')</script>
  @endif
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3>Generar solicitud</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('oficio.guardar')}}" novalidate>    
    @csrf 
    <div class="form-row">
      <div class="col-md-9 mb-2">
        <div class="row">
          <div class="col-md-6 mb-2">
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
          <div class="col-md-3 mb-2">
            <label for="validationCustom05">Año</label>
            <div class="input-group input-group">
              <select id="validationCustom07" class="form-control" required name="year">
                  <option disabled>Seleccione un semestre</option>
                  <option value="2020">2020</option>
                  <option value="2021">2021</option>
                  <option value="2022">2022</option>
                  <option value="2023">2023</option>
              </select>             
            </div>
            <div class="invalid-feedback">
            Por favor seleccione un año
            </div>
          </div>         
          <div class="col-md-3 mb-2">
            <label for="select_tipo">Tipo</label>
            <div class="input-group input-group">
              <select id="select_tipo" class="form-control" required name="tipo" onchange="tipoPractica()">
                  <option disabled>Seleccione un tipo</option>
                  <option value="1">Docencia</option>
                  <option value="2">Investigación</option>
                  <option value="3">Aplicada</option>
              </select>             
            </div>
            <div class="invalid-feedback">
            Por favor seleccione un año
            </div>
          </div>           
        </div>
      </div>  
    </div>

    @if($empresa) <!-- Si hay empresa creada por el usuario -->
    <div class="form-row mb-3">
      <div class="col-12">
        <div class="callout callout-info">
          <dl class="row">
            <dd class="col-sm-12 mb-n1 mt-n1"> <b>Empresa: </b> {{$empresa->nombre}}</dd>
            <dd class="col-sm-6 mb-n1"> <b>Dirección: </b> {{$empresa->direccion}}</dd>
            <dd class="col-sm-6 mb-n1"> <b>Ubicación: </b> {{$empresa->ubicacion}}</dd>
            <dd class="col-sm-4 mb-n3"> <b>Alias: </b> {{$empresa->alias}}</dd>
            <dd class="col-sm-2 mb-n3"> <b>Telefono: </b> {{$empresa->telefono}}</dd>
            <dd class="col-sm-4 mb-n3"> <b>Correo: </b> {{$empresa->correo}}</dd>              
          </dl>        
        </div>          
      </div>          
      <input type="hidden" name="empresa_id" value="{{$empresa->id}}" id="empresa_id"> 
      <input type="hidden" value="{{$empresa->nombre}}" id="nombre_empresa"> 
    </div>
    @else <!-- Si NO hay empresa creada por el usuario -->
    <div class="form-row mb-3">
      <div class="col-md-12">
        <label for="empresa_id">Empresa o institución</label>
        <div class="">
          <div class="row">
            <div class="col-2 input-group input-group">
              <input class="form-control" type="text" id="buscador_empresa" placeholder="Buscador...">
              <span class="input-group-append">
                <a><button onclick="buscarEmpresas()" type="button" class="btn btn-success"><i class="fas fa-search"></i></button></a> 
              </span>
            </div>
            <div class="col-10 input-group input-group">
              <select id="empresa_id" class="form-control" required name="empresa_id"  >
                @forelse ($empresas as $em)
                  <option value="{{$em->id}}">{{$em->nombre}} ({{$em->alias}}) {{$em->ubicacion}}</option>
                @empty
                  <option disabled>No hay datos disponibles, por favor cree una empresa o institución -></option>
                @endforelse                
              </select>      
              <span class="input-group-append">
                <a href="{{route('empresa.crear')}}"><button type="button" class="btn btn-success"><i class="fas fa-plus"></i></button></a> 
              </span>
            </div>
          </div>    
        </div>
        <div class="invalid-feedback">
        Por favor seleccione una empresa/institución o cree una.
        </div>
      </div>
    </div>      
    @endif <!-- EXISTENCIA DE EMPRESA POR EL USUARIO-->
    
    <div class="form-row mb-3">
      <div class="col-md-7">
        <label for="destinatario">Destinatario carta solicitud</label> <br>
        <small style="color:rgb(224,70,50)">** Se debe agregar el título de tratamiento al destinatario. Ejemplo: Ing. Lic. Sr. Sra. **</small>
        <input type="text" class="form-control encargado" id="destinatario" name="destinatario" required > 
        <div class="invalid-feedback">
        Ingrese el destinatario.
        </div>      
      </div>   
    </div>
    
    
    <div id="div_docencia" class="mb-3" style="display:none;">
      <h5>Práctica docente</h5>

      <div class="form-row">
        <div class="col-md-8 ">
          <label for="curso">Curso</label>
          <input type="text" class="form-control encargado" id="curso" name="curso" required > 
          <div class="invalid-feedback">
          Ingrese puesto de la persona a la cual va dirigida la carta solicitud.
          </div>      
        </div>   
        <div class="col-md-2 ">
          <label for="codigo">Código</label>
          <input type="number" min="0" class="form-control encargado" id="codigo" name="codigo" required > 
          <div class="invalid-feedback">
          Código del curso. Si no tiene ingrese el valor 0
          </div>      
        </div>   
      </div>           
      
    </div>

    <div class="" id="div_investigacion" class="mb-3" style="display:none;">
      <h5>Práctica en investigación</h5>
      <div class="form-row">
        <div class="col-md-11 ">
          <label for="tema">Tema o proyecto de investigación</label>
          <input type="text" class="form-control encargado" id="tema" name="tema" required > 
          <div class="invalid-feedback">
          Ingrese el tema o proyecto de investigación.
          </div>      
        </div>   
      </div>           
    </div>

    <div class="" id="div_aplicada"  class="mb-3" style="display:none;">
      <h5>Práctica aplicada</h5>
      <div class="form-row">
        <div class="col-md-5 ">
          <label for="puesto">Puesto del destinatario</label>
          <input type="text" class="form-control encargado" id="puesto" name="puesto" required > 
          <div class="invalid-feedback">
          Ingrese puesto de la persona a la cual va dirigida la carta solicitud.
          </div>      
        </div>   
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



function tipoPractica(){
    var forms = document.getElementsByClassName('needs-validation');
    forms[0].classList.remove('was-validated');
    // Get the checkbox
    var tipo = $("#select_tipo").val();    
    console.log("TIPO: ", tipo);
    // If the checkbox is checked, display the output
    if(tipo == 1){
      $('#div_aplicada').hide(200);
      $('#div_investigacion').hide(200);
      $('#div_docencia').show(600);
      $('#curso').attr('required',true);
      $('#codigo').attr('required',true);
      $('#puesto').removeAttr('required');
      $('#tema').removeAttr('required');
    }
    else if(tipo == 2){
      $('#div_aplicada').hide(200);
      $('#div_docencia').hide(200);
      $('#div_investigacion').show(600);
      $('#tema').attr('required',true);
      $('#curso').removeAttr('required');
      $('#codigo').removeAttr('required');
      $('#puesto').removeAttr('required');
    }
    else{
      $('#div_docencia').hide(200);
      $('#div_investigacion').hide(200);
      $('#div_aplicada').show(600);
      $('#puesto').attr('required',true);
      $('#curso').removeAttr('required');
      $('#codigo').removeAttr('required');
      $('#tema').removeAttr('required');
    }
}

$( document ).ready(function() {
    tipoPractica();

});

function buscarEmpresas(){  
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    jQuery.ajax({
        url: "{{ route('api.empresas') }}",
        method: 'post',
        data: {
            _token: "{{ csrf_token() }}",
            buscador: jQuery('#buscador_empresa').val(),            
        },
        success: function(result){
            $('#empresa_id').html(result['msg']);
        }});    
}

</script>
@endsection

