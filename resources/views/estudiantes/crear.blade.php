@extends('plantilla.plantilla',['sidebar'=>31])

@section('titulo', 'Nuevo estudiante')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('estudiante.index')}}">Estudiantes</a></li>
    <li class="breadcrumb-item active">Nuevo estudiante</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe estudiante con ese registro o carne.')</script>
  @endif    
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3>Crear nuevo estudiante</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('estudiante.guardar')}}" novalidate >    
    @csrf
    <div class="form-row">
      <div class="col-md-5 col-sm-12 mb-3">
        <label for="validationCustom01">Nombres</label>
        <input type="text" class="form-control" id="validationCustom01" required name="nombre" autofocus value="{{old('nombre')}}">
        <div class="invalid-feedback">
          Por favor ingrese nombre del estudiante
        </div>
      </div>      
      <div class="col-md-5 col-sm-12 mb-3">
        <label for="validationCustom02">Apellidos</label>
        <input type="text" class="form-control" id="validationCustom02" required name="apellido" value="{{old('apellido')}}">
        <div class="invalid-feedback">
          Por favor ingrese apellido del estudiante 
        </div>
      </div>      
      <div class="col-md-2 col-sm-12 mb-3">
        <label for="validationCustom03">Carne</label>
        <input type="text" class="form-control" id="validationCustom03" minlength="13" placeholder="2600000000001" required name="carne" value="{{old('carne')}}">
        <div class="invalid-feedback">
        Valor incorrecto. El carne es el valor del DPI
        </div>
      </div>      
    </div>
    <div class="form-row">
      <div class="col-md-4 col-sm-12">
        <div class="row">            
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="validationCustom04">Registro</label>
                <input type="text" class="form-control" id="validationCustom04" minlength="9" placeholder="201700001" required name="registro" value="{{old('registro')}}">
                <div class="invalid-feedback">
                Por favor ingresar numero de registro correcto
                </div>
            </div>      
            <div class="col-md-6 col-sm-12 mb-3">
                <label for="validationCustom05">Teléfono</label>
                <input type="text" class="form-control" id="validationCustom05" minlength="8" required name="telefono" value="{{old('telefono')}}" >
                <div class="invalid-feedback">
                Por favor ingresar número de teléfono
                </div>
            </div>      
        </div>        
      </div>    
        <div class="col-md-5 col-sm-12 mb-3">
            <label for="validationCustom06">Dirección</label>
            <input type="text" class="form-control" id="validationCustom06" required name="direccion" value="{{old('direccion')}}">
            <div class="invalid-feedback">
            Por favor ingresar su dirección
            </div>
        </div>    
        <div class="col-md-3 col-sm-12 mb-3">
            <label for="validationCustom06">Correo</label>
            <input type="email" class="form-control" id="validationCustom06" required name="correo" value="{{old('correo')}}">
            <div class="invalid-feedback">
            Por favor ingresar email
            </div>
        </div>    
    </div>
    <div class="form-row">
        <div class="col-md-4 col-sm-12 mb-3">            
            @if(Auth()->user()->rol->id != 1)
            <label for="validationCustom07">Carrera</label>
            <select id="validationCustom07" class="form-control" disabled required>                
                <option  value="{{$carrera->id}}">{{$carrera->nombre}}</option>                
            </select>
            <input type="hidden" name="carrera_id" value="{{$carrera->id}}">
            @else
            <label for="validationCustom07">Carrera</label>
            <select id="validationCustom07" class="form-control" required name="carrera_id">
                <option disabled>Seleccione una carrera</option>
                @foreach ($carreras as $c)
                <option value="{{$c->id}}">{{$c->nombre}}</option>
                @endforeach
            </select>
            <div class="invalid-feedback">
            Por favor seleccione una carrera
            </div>
            @endif
        </div>           
        <div class="col-md-8 col-sm-12 mb-3">
            <div class="row">
                <div class="col-md-2 col-sm-12 mb-3">
                    <label for="validationCustom08">Promedio</label>
                    <input type="text" class="form-control" id="validationCustom08" required name="promedio" value="{{old('promedio')}}">
                    <div class="invalid-feedback">
                    Por favor ingresar un valor numérico
                    </div>
                </div>      
                <div class="col-md-2 col-sm-12 mb-3">
                    <label for="validationCustom09">Créditos</label>
                    <input type="number" min="200" class="form-control" id="validationCustom09" required name="creditos">
                    <div class="invalid-feedback">
                    Por favor ingresar valor numérico mayor a 200
                    </div>
                </div>      
                <div class="col-md-4 col-sm-12 mb-3">
                    <label for="validationCustom07">Semestre actual</label>
                    <select id="validationCustom07" class="form-control" required name="semestre">
                        <option value="1" selected>Primer semestre</option>
                        <option value="2">Segundo semestre</option>
                    </select>
                    <div class="invalid-feedback">
                    Por favor seleccione un semestre
                    </div>
                </div>   
                <div class="col-md-4 col-sm-12 mb-3">
                    @php $hoy = date('yy-m-d');
                    @endphp
                    <label for="validationCustom09">Fecha prácticas intermedias</label>
                    <input type="date" max="{{$hoy}}" class="form-control" id="validationCustom09" required name="practicas" value="{{old('practicas')}}">
                    <div class="invalid-feedback">
                    Por favor seleccione una fecha válida
                    </div>
                </div>  
            </div>                
        </div>            
    </div>
    @if(Auth()->user()->rol->id == 1)
    <div class="form-row">
      <div class="col-md-6 mb-2">
        <label for="validationCustom03">Supervisor a cargo</label>
        <select id="validationCustom07" class="form-control" required name="usuario_supervisor">
            <option disabled>Seleccione un supervisor de prácticas finales</option>
            @foreach($supervisores as $s)
            <option value="{{$s->usuario_id}}">{{$s->nombre}} {{$s->apellido}}</option>
            @endforeach
        </select>
        <div class="invalid-feedback">
        Por favor seleccione un semestre
        </div>
      </div>      
    </div>
    @endif
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
</script>
@endsection
