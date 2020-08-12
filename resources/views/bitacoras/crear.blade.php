@extends('plantilla.plantilla',['sidebar'=>61])

@section('titulo', 'Nueva bitácora')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    @if(Auth()->user()->rol->id==2)
    <li class="breadcrumb-item"><a href="{{route('practica.index')}}">Prácticas</a></li>
    <li class="breadcrumb-item active">Nueva bitácora</li>
    @else
    <li class="breadcrumb-item"><a href="{{route('bitacora.index')}}">Bitácora</a></li>
    <li class="breadcrumb-item"><a href="{{route('bitacora.ver', $bitacora->id)}}">{{$estudiante->nombre}} {{$estudiante->apellido}} ({{$estudiante->registro}})</a></li>
    <li class="breadcrumb-item active">Revisar</li>
    @endif    
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
      <div class="col-12">
        <div class="callout callout-info">
          <dl class="row">
            <dd class="col-sm-12 mb-n1 mt-n1"> <b>Empresa o institución: </b> {{$empresa->nombre}}</dd>
            <dd class="col-sm-6 mb-n1"> <b>Dirección: </b> {{$empresa->direccion}}</dd>
            <dd class="col-sm-6 mb-n1"> <b>Ubicación: </b> {{$empresa->ubicacion}}</dd>
            <dd class="col-sm-4 mb-n3"> <b>Alias: </b> {{$empresa->alias}}</dd>
            <dd class="col-sm-2 mb-n3"> <b>Telefono: </b> {{$empresa->telefono}}</dd>
            <dd class="col-sm-4 mb-n3"> <b>Correo: </b> {{$empresa->correo}}</dd>         
          </dl>        
        </div>          
      </div>          
      <input type="hidden" name="empresa_id" value="{{$empresa->id}}" id="select_empresa"> 
      <input type="hidden" value="{{$empresa->nombre}}" id="nombre_empresa"> 
      <input type="hidden" value="{{$oficio->id}}" name="oficio_id">
    </div>
    
    <div class="form-row">
      <div class="col-md-4 mt-4 mb-3">        
        <label for="select_areas">Seleccione un área de la empresa</label>
        <div class="input-group input-group">
          <select id="select_areas" class="form-control" required name="area_id" onchange="encargadoArea()" >
              <option disabled>Seleccione un área</option>
              
          </select>   
          <span class="input-group-append">
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_area"><i class="fas fa-plus"></i></button>
          </span>             
        </div>
        <div class="invalid-feedback">
        Por favor seleccione un area
        </div>
      </div>

      <div class="col-md-8" >
        <div class="form-group ml-2">
          <div class="custom-control custom-switch">
              <input type="checkbox" checked class="custom-control-input" id="cbx_encargado" onclick="cbxEncargado()" name="existente" >
              <label class="custom-control-label" for="cbx_encargado">Encargados del area</label>
          </div>
        </div>     

        <div id="encargado-area">
          <div class="col-md-12 mt-n3 mb-3">
          <label for="select_encargado_area">Encargados disponibles</label>
            <div class="input-group input-group">
              <select id="select_encargado_area" class="form-control" required name="encargado_area_id">
                  <option disabled>Seleccione un encargado</option>
                  
              </select>
            </div>
            <div class="invalid-feedback">
              Por favor seleccione un encargado o cree uno
            </div>
          </div>
        </div>

        <div id="encargado-nuevo">
          <div class="row">
            <div class="col-md-5 mt-n3 mb-3">
              <label for="puesto">Puesto</label>
              <input type="text" class="form-control encargado" id="puesto" name="puesto" required > 
              <div class="invalid-feedback">
              Ingrese el puesto del encargado en la empresa.
              </div>      
            </div>   

            <div class="col-md-7 mt-n3">
            <label for="select_necargado">Encargado</label>
              <div class="input-group input-group">
                <select id="select_encargado" class="form-control" required name="encargado_id">
                @forelse ($encargados as $e)
                  <option value="{{$e->encargado_id}}">{{$e->nombre}} {{$e->apellido}}</option>
                @empty
                  <option disabled>No hay encargados, por favor cree uno</option>
                @endforelse                          
                </select>
                <span class="input-group-append">
                  <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_encargado"><i class="fas fa-plus"></i></button>
                </span>   
              </div>
              <div class="invalid-feedback">
              Por favor seleccione un encargado o cree uno
              </div>
            </div>
          </div>              
        </div>
      </div> 
    </div>
      
    <div class="float-sm-right">
      <button class="btn btn-success" type="submit">Crear</button>
      <a class="btn btn-secondary" href="{{url()->previous()}}" role="cancelar">Regresar</a>
    </div>    
  </form>
  </div>
</div>

  <!-- Modal area -->
  <div class="modal fade" id="modal_area" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Crear nueva área</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form_area" id="form_area" method="POST" action="" novalidate >
        @csrf
        <div class="modal-body">     
          <div class="form-row">
            <h5 class="nombre_empresa"></h5>
          </div>  
          <div class="form-row">
            <div class="col-md-12 mb-3">
                <label for="nombre_area">Area</label>
                <input type="text" class="form-control" name="area" required placeholder="Ej. Recursos Humanos" id="nombre_area" >   
                <div class="invalid-feedback">
                Ingrese área de la empresa a la que pertenece el encargado
                </div>                 
            </div>    
            <div class="col-md-12 mb-3">
                <label for="descripcion_area">Descripción</label>
                <input type="text" class="form-control" name="descripcion" id="descripcion_area">                  
            </div>               
          </div>        
        </div>        
        <div class="modal-footer">          
          <button type="submit" class="btn btn-success btn-crear" onclick="form_area()">Crear</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- FIN MODAL AREA -->

  <!-- Modal encargado -->
  <div class="modal fade" id="modal_encargado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Crear nuevo encargado</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form_encargado" id="form_area" method="POST" action="" novalidate >
        @csrf
        <div class="modal-body">  
          <div class="form-row">
              <div class="col-md-5 mb-3">
                  <label for="nombre_encargado">Nombre</label>
                  <input type="text" class="form-control" id="nombre_encargado" name="nombre" required> 
                  <div class="invalid-feedback">
                  Ingrese nombre de encargado válido.
                  </div>      
              </div>    
              <div class="col-md-5 mb-3">
                  <label for="apellido_encargado">Apellido</label>
                  <input type="text" class="form-control" id="apellido_encargado" name="apellido" required> 
                  <div class="invalid-feedback">
                  Ingrese nombre de encargado válido.
                  </div>      
              </div>   
              <div class="col-md-2 mb-3">
                  <label for="telefono_encargado">Teléfono</label>
                  <input type="text" class="form-control" id="telefono_encargado" name="telefono" required >
                  <div class="invalid-feedback">
                  Ingrese telefono de encargado válido. Al menos 8 dígitos.
                  </div>
              </div>         
              <small class="mt-n3 mb-2">&nbsp; &nbsp; *Se recomienda agregar el título de tratamiento al nombre del encargado. Ejemplo: Ing. Lic. Sr. Sra.</small>               
          </div>

          <div class="form-row">
              <div class="col-md-3 mb-3">
                  <label for="colegiado_encargado">Colegiado</label>
                  <input type="text" class="form-control" id="colegiado_encargado" name="colegiado">                   
              </div>    
              <div class="col-md-5 mb-3">
                  <label for="profesion_encargado">Profesión</label>
                  <input type="text" class="form-control" id="profesion_encargado" name="profesion" required> 
                  <div class="invalid-feedback">
                  Ingrese profesión del encargado.
                  </div>      
              </div> 
              <div class="col-md-4 mb-3">
                  <label for="correo_encargado">Correo</label>
                  <input type="email" class="form-control" id="correo_encargado" name="correo" required >
                  <div class="invalid-feedback">
                  Ingrese un correo electrónico válido.
                  </div>
              </div>    
          </div>

        </div>        
        <div class="modal-footer"> 
          <button type="submit" class="btn btn-success" onclick="form_encargado()">Crear</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!-- FIN MODAL ENCARGADO -->

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

$('#modal_area').on('show.bs.modal', function (e) {
  if(!$('#select_empresa').val()){
    e.preventDefault();
    alerta_error('Se necesita una empresa para crear el área');
  }
  else{
    var modal = $(this);
    var n = $('#select_empresa').text()
    if(!n){
      n = $('#nombre_empresa').val()
    }
    modal.find('.nombre_empresa').text('Empresa: '+n);
  }
})

function select_area(){

    //e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    jQuery.ajax({
        url: "{{ route('api.areas_empresa') }}",
        method: 'get',
        data: {
            empresa_id: jQuery('#select_empresa').val(),            
        },
        success: function(result){
            $('#select_areas').html(result['msg']);
            encargadoArea();
        }});    
}

function encargados(){
    //e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    jQuery.ajax({
        url: "{{ route('api.encargados') }}",
        method: 'get',
        data: {
                    
        },
        success: function(result){
            $('#select_encargado').html(result['msg']);
        }});    
}

function encargadoArea(){    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    jQuery.ajax({
        url: "{{ route('api.encargados_area') }}",
        method: 'get',
        data: {
            area_id: jQuery('#select_areas').val(),            
        },
        success: function(result){
            $('#select_encargado_area').html(result['msg']);
        }});    
}

function form_area(){
  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.getElementsByClassName('form_area');
  // Loop over them and prevent submission  
  var validation = Array.prototype.filter.call(forms, function(form) {
    
    form.addEventListener('submit', function(event) {
      event.preventDefault();
      event.stopPropagation();
      form.classList.add('was-validated');
      if (form.checkValidity() === true) {
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });   
        jQuery.ajax({
          url: "{{ route('api.crear_area') }}",
          method: 'post',
          data: {
              _token: "{{ csrf_token() }}",
              empresa_id: jQuery('#select_empresa').val(),   
              nombre: jQuery('#nombre_area').val(),   
              descripcion: jQuery('#descripcion_area').val(),            
          },
          success: function(result){
            select_area();
            $('#modal_area').modal('hide');
            form.classList.remove('was-validated');
            $('#nombre_area').val(' ');
          }});    
      }
    }, false);
  });
}

function form_encargado(){
  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.getElementsByClassName('form_encargado');
  // Loop over them and prevent submission  
  var validation = Array.prototype.filter.call(forms, function(form) {
    
    form.addEventListener('submit', function(event) {
      event.preventDefault();
      event.stopPropagation();
      form.classList.add('was-validated');
      if (form.checkValidity() === true) {
        $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
          }
        });   
        jQuery.ajax({
          url: "{{ route('api.crear_encargado') }}",
          method: 'post',
          data: {
              _token: "{{ csrf_token() }}",
              nombre: jQuery('#nombre_encargado').val(),   
              apellido: jQuery('#apellido_encargado').val(),   
              telefono: jQuery('#telefono_encargado').val(),     
              correo: jQuery('#correo_encargado').val(),     
              profesion: jQuery('#profesion_encargado').val(),     
              colegiado: jQuery('#colegiado_encargado').val(),     
          },
          success: function(result){
            encargados();
            $('#modal_encargado').modal('hide');
            form.classList.remove('was-validated');
            $('#nombre_encargado').val(' ');
            $('#apellido_encargado').val(' ');
            $('#telefono_encargado').val(' ');
            $('#correo_encargado').val(' ');
            $('#profesion_encargado').val(' ');
            $('#colegiado_encargado').val(null);
          }});    
      }
    }, false);
  });
}

function cbxEncargado(){
    var forms = document.getElementsByClassName('needs-validation');
    forms[0].classList.remove('was-validated');
    // Get the checkbox
    var checkBox = document.getElementById("cbx_encargado");    

    // If the checkbox is checked, display the output
    if (checkBox.checked == true){
        $('#encargado-nuevo').hide(200);
        $('#encargado-area').show(600);
        $('#puesto').removeAttr('required');
        $('#select_encargado').removeAttr('required');
        $('#select_encargado_area').attr('required',true);
    } else {
        $("#encargado-area").hide(200);
        $("#encargado-nuevo").show(600);
        $('.puesto').attr('required',true);
        $('.select_encargado').attr('required',true);
        $('#select_encargado_area').removeAttr('required');
    }
}

$( document ).ready(function() {
    select_area(); 
    encargados();  
    
    var checkBox = document.getElementById("cbx_encargado"); 
    if(checkBox){ cbxEncargado(); }

});

</script>
@endsection

