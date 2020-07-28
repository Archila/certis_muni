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
        @if($empresa && $encargado)
        <div class="form-row">
          <div class="col-12">
            <div class="callout callout-info">
              <dl>
                <dt>Empresa: </dt>
                <dd>{{$empresa->nombre}}</dd>
                <dt>Encargado</dt>
                <dd>{{$encargado->nombre}}  &nbsp; {{$encargado->apellido}}</dd>
                <dd>{{$encargado->puesto}}</dd>
              </dl>
            </div>          
          </div>          
          <input type="hidden" name="empresa_id" value="{{$empresa->id}}">          
        </div>
        @elseif($empresa)
        <div class="form-row">
          <div class="col-12">
            <div class="callout callout-info">
              <dl>
                <dt>Empresa: </dt>
                <dd>{{$empresa->nombre}}</dd>                
              </dl>
            </div>          
          </div>               
        </div>
        <div class="form-row">
          <div class="col-md-6 mb-3">
          @empty($encargados)
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
            Por favor seleccione un encargado o cree uno.
            </div>
            @endempty
          </div>
        </div>
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
            <label for="validationCustom05">Empresa</label>
            <div class="input-group input-group">
              <select id="validationCustom07" class="form-control" required name="empresa_id">
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
          @endempty
          </div>
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
        @else
        <div class="form-row">
          <div class="col-md-6 mb-3">
          @empty($empresas)
            <p>No hay empresas en el sistema para su usuario.</p>
            <a href="{{route('empresa.crear')}}" class="btn-animar"><button type="button" class="btn btn-block btn-info">Crear empresa</i></button></a>                     
            <input class="form-control" type="hidden" value="1" id="no_empresa" > 
          @else
            <label for="validationCustom05">Empresa</label>
            <div class="input-group input-group">
              <select id="validationCustom07" class="form-control" required name="empresa_id">
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
          @endempty
          </div>
          

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
        <div class="col-md-6 mb-3">
        @if(!$empresas)
            <p>No hay empresas en el sistema para su usuario.</p>
            <a href="{{route('empresa.crear')}}" class="btn-animar"><button type="button" class="btn btn-block btn-info">Crear empresa</i></button></a>                     
            <input class="form-control" type="hidden" value="1" id="no_empresa" >
        @else
          <label for="validationCustom05">Empresa</label>
          <div class="input-group input-group">
            <select id="validationCustom07" class="form-control" required name="empresa_id">
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
</script>
@endsection

