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
      <div class="col-md-9 mb-3">
        <div class="row">
          <div class="col-md-6 mb-3">
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
            <div class="input-group input-group">
              <select id="validationCustom07" class="form-control" required name="year">
                  <option disabled>Seleccione un semestre</option>
                  <option value="2020">2020</option>
                  <option value="2021">2021</option>
                  <option value="2022">2022</option>
              </select>             
            </div>
            <div class="invalid-feedback">
            Por favor seleccione un año
            </div>
          </div>         
          <div class="col-md-3 mb-3">
            <label for="validationCustom05">Tipo</label>
            <div class="input-group input-group">
              <select id="validationCustom07" class="form-control" required name="tipo">
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

    @if(Auth::user()->rol->id==2 )
    <!-- Si el estudiante ha ingresado empresa -->
      @if($empresa)
      <div class="form-row">
        <div class="col-12">
          <div class="callout callout-info">
            <dl class="row">
              <dd class="col-sm-12 mb-n1"> <b>Empresa: </b> {{$empresa->nombre}}</dd>
              <dd class="col-sm-6 mb-n1"> <b>Dirección: </b> {{$empresa->direccion}}</dd>
              <dd class="col-sm-6 mb-n1"> <b>Ubicación: </b> {{$empresa->ubicacion}}</dd>
              <dd class="col-sm-4"> <b>Alias: </b> {{$empresa->alias}}</dd>
              <dd class="col-sm-2"> <b>Telefono: </b> {{$empresa->telefono}}</dd>
              <dd class="col-sm-4"> <b>Correo: </b> {{$empresa->correo}}</dd>              
            </dl>        
          </div>          
        </div>          
        <input type="hidden" name="empresa_id" value="{{$empresa->id}}">          
      </div>
    <!-- FIN Empresa -->  
      <!-- Si el estudiante no ha ingresado empresa -->
      @else
        <input type="hidden" id="select_empresa" value="{{$empresa->id}}">
        <div class="form-row">
          <div class="col-12">
            <div class="callout callout-info">
              <dl class="row">
                <dd class="col-sm-12 mb-n1"> <b>Empresa: </b> {{$empresa->nombre}}</dd>
                <dd class="col-sm-6 mb-n1"> <b>Dirección: </b> {{$empresa->direccion}}</dd>
                <dd class="col-sm-6 mb-n1"> <b>Ubicación: </b> {{$empresa->ubicacion}}</dd>
                <dd class="col-sm-4"> <b>Alias: </b> {{$empresa->alias}}</dd>
                <dd class="col-sm-2"> <b>Telefono: </b> {{$empresa->telefono}}</dd>
                <dd class="col-sm-4"> <b>Correo: </b> {{$empresa->correo}}</dd>
              </dl>              
            </div>          
          </div>               
        </div>

        <div class="form-row">
          <div class="col-md-4 mb-3 mt-4">        
            <label for="select_areas">Seleccione un área de la empresa</label>
            <div class="input-group input-group">
              <select id="select_areas" class="form-control" required name="area_id" onchange="select_encargado_area()" >
                  <option disabled>Seleccione un área</option>
                  @foreach ($areas as $a)
                  <option value="{{$a->id}}">{{$a->area}}</option>
                  @endforeach
              </select>   
              <span class="input-group-append">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_area"><i class="fas fa-plus"></i></button>
              </span>             
            </div>
            <div class="invalid-feedback">
            Por favor seleccione un año
            </div>
          </div>

          <div class="col-md-8" >
            <div class="form-group ml-2">
              <div class="custom-control custom-switch">
                  <input type="checkbox" class="custom-control-input" id="cbx_encargado" onclick="cbxEncargado()" name="completo" >
                  <label class="custom-control-label" for="cbx_encargado">Encargados del area</label>
              </div>
            </div>     

            <div id="encargado-area">
              <div class="col-md-12 mt-n3">
              <label for="select_ecargado_area">Encargados disponibles</label>
                <div class="input-group input-group">
                  <select id="select_ecargado_area" class="form-control" required name="encargado_id">
                      <option disabled>Seleccione un encargado</option>
                      
                  </select>
                  <span class="input-group-append">
                    <a href="{{route('encargado.crear')}}"><button type="button" class="btn btn-success "><i class="fas fa-plus"></i></button></a> 
                  </span>
                </div>
                <div class="invalid-feedback">
                Por favor seleccione un año
                </div>
              </div>
            </div>

            <div id="encargado-nuevo">
              <div class="row">
                <div class="col-md-5 mt-n3">
                  <label for="validationCustom08">Puesto</label>
                  <input type="text" class="form-control encargado" id="validationCustom08" name="puesto" required > 
                  <div class="invalid-feedback">
                  Ingrese el puesto del encargado en la empresa.
                  </div>      
                </div>   

                <div class="col-md-7 mt-n3">
                <label for="select_ecargado_area">Encargado</label>
                  <div class="input-group input-group">
                    <select id="select_ecargado_area" class="form-control" required name="encargado_id">
                        <option disabled>Seleccione un encargado</option>
                        
                    </select>
                    <span class="input-group-append">
                      <a href="{{route('encargado.crear')}}"><button type="button" class="btn btn-success "><i class="fas fa-plus"></i></button></a> 
                    </span>
                  </div>
                  <div class="invalid-feedback">
                  Por favor seleccione un año
                  </div>
                </div>
              </div>              
            </div>
          </div>  
        </div>
      <!-- FIN SOLO EMPRESA -->
      <!-- SOLO ENCARGADO -->
      @elseif($encargado)
      <div class="form-row">
        <div class="col-12">
          <div class="callout callout-info">
            <dl>
              <dt>Encargado</dt>
              <dd>{{$encargado->nombre}}  &nbsp; {{$encargado->apellido}}</dd>
              <dd>{{$encargado->puesto}}</dd>        
            </dl>
          </div>          
        </div>               
      </div>
      <div class="form-row">
        <div class="col-md-4 mb-3">
        @empty($empresas)
          <p>No hay empresas en el sistema para su usuario.</p>
          <a href="{{route('empresa.crear')}}" class="btn-animar"><button type="button" class="btn btn-block btn-info">Crear empresa</i></button></a>                     
          <input class="form-control" type="hidden" value="1" id="no_empresa" >
        @else
          <label for="select_empresa">Empresa</label>
          <div class="input-group input-group">
            <select id="select_empresa" class="form-control" required name="empresa_id" >
                <option disabled>Seleccione una empresa</option>
                @foreach ($empresas as $em)
                <option value="{{$em->id}}">{{$em->alias}} </option>
                @endforeach
            </select>
            <span class="input-group-append">
              <a href="{{route('empresa.crear')}}"><button type="button" class="btn btn-success"><i class="fas fa-plus"></i></button></a> 
            </span>
          </div>
          <div class="invalid-feedback">
          Por favor seleccione una empresa o cree una.
          </div>
        </div>
        @endempty
        
          <div class="col-md-4 mb-3">
            <label for="validationCustom08">Área</label>
            <input type="text" class="form-control encargado" id="validationCustom08" name="area" required > 
            <div class="invalid-feedback">
            Ingrese el area en la que labora el encargado dentor de la empresa.
            </div>      
          </div>   
        <div class="col-md-4 mb-3">
          <label for="validationCustom08">Puesto</label>
          <input type="text" class="form-control encargado" id="validationCustom08" name="puesto" required > 
          <div class="invalid-feedback">
          Ingrese el puesto del encargado en la empresa.
          </div>      
        </div>   
      </div>
      <!-- FIN SOLO ENCARGADO -->
      <!-- NINGUNO -->
      @else
      <div class="form-row">          
        @empty($empresas)
        <div class="col-md-6 mb-3">
          <p>No hay empresas en el sistema para su usuario.</p>
          <a href="{{route('empresa.crear')}}" class="btn-animar"><button type="button" class="btn btn-block btn-info">Crear empresa</i></button></a>                     
          <input class="form-control" type="hidden" value="1" id="no_empresa" > 
        </div>
        @else
        <div class="col-md-7 mb-3">        
          <label for="select_empresa">Empresa</label>
          <div class="input-group input-group">
            <select id="select_empresa" class="form-control" required name="empresa_id" onchange="select_area_encargado()">
                <option disabled>Seleccione una empresa</option>
                @foreach ($empresas as $em)
                <option value="{{$em->id}}">{{$em->nombre}} ({{$em->alias}}) </option>
                @endforeach
            </select>
            <span class="input-group-append">
              <a href="{{route('empresa.crear')}}"><button type="button" class="btn btn-success"><i class="fas fa-plus"></i></button></a> 
            </span>
          </div>
          <div class="invalid-feedback">
          Por favor seleccione un año
          </div>
        </div>            
        <div class="col-md-5 mb-3">        
          <label for="select_areas">Seleccione un área de la empresa</label>
          <div class="input-group input-group">
            <select id="select_areas" class="form-control" required name="area_id" onchange="select_encargado()" >
                <option disabled>Seleccione un área</option>
                @foreach ($areas as $a)
                <option value="{{$a->id}}">{{$a->area}}</option>
                @endforeach
            </select>   
            <span class="input-group-append">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_area"><i class="fas fa-plus"></i></button>
            </span>             
          </div>
          <div class="invalid-feedback">
          Por favor seleccione un año
          </div>
        </div>

        <div class="col-md-12 mb-3" id="area_encargado">
        

        </div>    

        @endempty         
          
        <div class="col-md-6 mb-3">
        @empty($encargados)
          <p>No hay encargados en el sistema para su usuario.</p>
          <a href="{{route('encargado.crear')}}" class="btn-animar"><button type="button" class="btn btn-block btn-info">Crear encargado</i></button></a>                     
          <input class="form-control" type="hidden" value="1" id="no_empresa" >
        @else
          <label for="validationCustom05">Encargado</label>
          <div class="input-group input-group">
            <select id="validationCustom07" class="form-control" required name="encargado_id">
                <option disabled>Seleccione un encargado</option>
                @foreach ($encargados as $en)
                <option value="{{$en->encargado_id}}">{{$en->nombre}} {{' '}} {{$en->apellido}} ({{$en->profesion}})</option>
                @endforeach
            </select>
            <span class="input-group-append">
              <a href="{{route('encargado.crear')}}"><button type="button" class="btn btn-success "><i class="fas fa-plus"></i></button></a> 
            </span>
          </div>
          <div class="invalid-feedback">
          Por favor seleccione un año
          </div>
        @endempty
        </div>
      </div>
        @endIf
      @else  
      <div class="form-row">
        @if(!$empresas)
        <div class="col-md-6 mb-3">        
            <p>No hay empresas en el sistema para su usuario.</p>
            <a href="{{route('empresa.crear')}}" class="btn-animar"><button type="button" class="btn btn-block btn-info">Crear empresa</i></button></a>                     
            <input class="form-control" type="hidden" value="1" id="no_empresa" >
        </div>
        @else
        <div class="col-md-6 mb-3">      
          <label for="select_empresa">Empresa</label>
          <div class="input-group input-group">
            <select id="select_empresa" class="form-control" required name="empresa_id">
                <option disabled>Seleccione una empresa</option>
                @foreach ($empresas as $em)
                <option value="{{$em->id}}">{{$em->alias}} </option>
                @endforeach
            </select>
            <span class="input-group-append">
              <a href="{{route('empresa.crear')}}"><button type="button" class="btn btn-success"><i class="fas fa-plus"></i></button></a> 
            </span>
          </div>
          <div class="invalid-feedback">
          Por favor seleccione un año
          </div>
        @endif
        </div>

        <div class="col-md-6 mb-3">
          @if(!$encargados)
            <p>No hay encargados en el sistema para su usuario.</p>
            <a href="{{route('encargado.crear')}}" class="btn-animar"><button type="button" class="btn btn-block btn-info">Crear encargado</i></button></a>                     
            <input class="form-control" type="hidden" value="1" id="no_encargado" >
          @else
          <label for="validationCustom05">Encargado</label>
          <div class="input-group input-group">
            <select id="validationCustom07" class="form-control" required name="encargado_id">
                <option disabled>Seleccione un encargado</option>
                @foreach ($encargados as $en)
                <option value="{{$en->encargado_id}}">{{$en->nombre}} {{' '}} {{$en->apellido}} ({{$en->profesion}})</option>
                @endforeach
            </select>
            <span class="input-group-append">
              <a href="{{route('encargado.crear')}}"><button type="button" class="btn btn-success "><i class="fas fa-plus"></i></button></a> 
            </span>
          </div>
          <div class="invalid-feedback">
          Por favor seleccione un año
          </div>
          @endif
        </div>
      </div>
      @endIf


    <div class="float-sm-right">
      <button class="btn btn-primary" type="submit">Crear</button>
      <a class="btn btn-secondary" href="{{url()->previous()}}" role="cancelar">Regresar</a>
    </div>    
  </form>
  </div>
</div>

  <!-- Modal -->
  <div class="modal fade" id="modal_area" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">Crear nueva área</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form class="form_area" id="form_area" method="POST" action="{{route('folio.guardar')}}" novalidate >
        @csrf
        <div class="modal-body">       
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
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" onclick="form_area()">Crear</button>
        </div>
        </form>
      </div>
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
        else if($('#no_empresa').val()){
          event.preventDefault();
          event.stopPropagation();          
          animacion();
        }
        else if($('#no_encargado').val()){
          event.preventDefault();
          event.stopPropagation();          
          animacion();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();

function animacion (){
    alerta_error('Para crear una bitácora se necesita una empresa y un encargado');
    var btn = $(".btn-animar");   
    btn.animate({fontSize: '5em', opacity: '0.1'}, 400);    
    btn.find('.btn').removeClass('btn-info');
    btn.animate({fontSize: '1em', opacity: '1'}, 1200);
    btn.find('.btn').addClass('btn-info');
}

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
            console.log(result['msg']);
            $('#select_areas').html(result['msg']);
        }});    
}

function select_encargado_area(){    
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
            console.log(result['msg']);
            $('#area_encargado_area').html(result['msg']);
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
            console.log("Si retorna");
            console.log(result['msg']);
            select_area();
            $('#modal_area').modal('hide');
            form.classList.remove('was-validated');
            $('#nombre_area').val(' ');
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
    } else {
        $("#encargado-area").hide(200);
        $("#encargado-nuevo").show(600);
    }
}

cbxEncargado();

$( document ).ready(function() {
    select_area();
    select_encargado();
});

</script>
@endsection

