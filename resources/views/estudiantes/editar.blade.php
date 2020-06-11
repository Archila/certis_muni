@extends('plantilla.plantilla',['sidebar'=>32])

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
  <form class="needs-validation" method="POST" action="{{route('estudiante.actualizar', $estudiante->estudiante_id)}}" novalidate >
    @method('PUT')   
    @csrf   
    <div class="form-row">
      <div class="col-md-6 col-sm-12 mb-3">
        <label for="validationCustom01">Nombres</label>
        <input type="text" class="form-control" id="validationCustom01" required name="nombre" autofocus value="{{$estudiante->nombre}}">
        <div class="invalid-feedback">
          Por favor ingrese nombre del estudiante
        </div>
      </div>      
      <div class="col-md-6 col-sm-12 mb-3">
        <label for="validationCustom02">Apellidos</label>
        <input type="text" class="form-control" id="validationCustom02" required name="apellido" value="{{$estudiante->apellido}}">
        <div class="invalid-feedback">
          Por favor ingrese apellido del estudiante 
        </div>
      </div>      
    </div>
    <div class="form-row">
      <div class="col-md-8 col-sm-12">
        <div class="row">
            <div class="col-md-4 col-sm-12 mb-3">
                <label for="validationCustom03">Carne</label>
                <input type="text" class="form-control" id="validationCustom03" minlength="13" placeholder="2600000000001" required name="carne" value="{{$estudiante->carne}}">
                <div class="invalid-feedback">
                Valor incorrecto. El carne es el valor del DPI
                </div>
            </div>      
            <div class="col-md-4 col-sm-12 mb-3">
                <label for="validationCustom04">Registro</label>
                <input type="text" class="form-control" id="validationCustom04" minlength="9" placeholder="201700001" required name="registro" value="{{$estudiante->registro}}">
                <div class="invalid-feedback">
                Por favor ingresar numero de registro correcto
                </div>
            </div>      
            <div class="col-md-4 col-sm-12 mb-3">
                <label for="validationCustom05">Teléfono</label>
                <input type="text" class="form-control" id="validationCustom05" minlength="8" required name="telefono" value="{{$estudiante->telefono}}">
                <div class="invalid-feedback">
                Por favor ingresar número de teléfono
                </div>
            </div>      
        </div>        
      </div>    
        <div class="col-md-4 col-sm-12 mb-3">
            <label for="validationCustom06">Correo</label>
            <input type="email" class="form-control" id="validationCustom06" required name="correo" value="{{$estudiante->correo}}">
            <div class="invalid-feedback">
            Por favor ingresar email
            </div>
        </div>    
    </div>
    <div class="form-row">
        <div class="col-md-4 col-sm-12 mb-3">
            <label for="validationCustom07">Carrera</label>
            <select id="validationCustom07" class="form-control" required name="carrera_id">
                <option disabled>Seleccione una carrera</option>
                @foreach ($carreras as $c)
                    @if($estudiante->carrera_id==$c->id)
                    <option value="{{$c->id}}" selected>{{$c->nombre}}</option>
                    @else
                    <option value="{{$c->id}}" >{{$c->nombre}}</option>
                    @endif
                @endforeach
            </select>
            <div class="invalid-feedback">
            Por favor seleccione una carrera
            </div>
        </div>           
        <div class="col-md-8 col-sm-12 mb-3">
            <div class="row">
                <div class="col-md-2 col-sm-12 mb-3">
                    <label for="validationCustom08">Promedio</label>
                    <input type="text" class="form-control" id="validationCustom08" required name="promedio" value="{{$estudiante->promedio}}">
                    <div class="invalid-feedback">
                    Por favor ingresar un valor numérico
                    </div>
                </div>      
                <div class="col-md-2 col-sm-12 mb-3">
                    <label for="validationCustom09">Créditos</label>
                    <input type="number" min="200" class="form-control" id="validationCustom09" required name="creditos" value="{{$estudiante->creditos}}">
                    <div class="invalid-feedback">
                    Por favor ingresar un valor numérico mayor a 200.
                    </div>
                </div>      
                <div class="col-md-4 col-sm-12 mb-3">
                    <label for="validationCustom07">Semestre actual</label>
                    <select id="validationCustom07" class="form-control" required name="semestre" >
                    @if($estudiante->semestre==1)
                        @php $primero='selected'; $segundo='';
                        @endphp
                    @else
                        @php $primero=''; $segundo='selected';
                        @endphp
                    @endif
                        <option value="1" {{$primero}}>Primer semestre</option>
                        <option value="2" {{$segundo}} >Segundo semestre</option>
                    </select>
                    <div class="invalid-feedback">
                    Por favor seleccione una carrera
                    </div>
                </div>   
                <div class="col-md-4 col-sm-12 mb-3">
                    @php $hoy = date('yy-m-d');
                    @endphp
                    <label for="validationCustom09">Fecha prácticas intermedias</label>
                    <input type="date" max="{{$hoy}}" class="form-control" id="validationCustom09" required name="practicas" value="{{$estudiante->practicas}}">
                    <div class="invalid-feedback">
                    Por favor seleccione una fecha válida
                    </div>
                </div>  
            </div>                
        </div>            
    </div>
    <div class="float-sm-right">
      <button class="btn btn-success" type="submit">Editar</button>
      <a class="btn btn-secondary" href="{{route('carrera.index')}}" role="cancelar">Regresar</a>
    </div>    
  </form>
  </div>
</div>
@endsection

