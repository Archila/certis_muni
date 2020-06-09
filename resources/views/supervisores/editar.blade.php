@extends('plantilla.plantilla',['sidebar'=>82])

@section('titulo', 'Editar supervisor')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('supervisor.index')}}">Supervisores</a></li>
    <li class="breadcrumb-item active">Editar supervisor</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>ERROR</strong> Ya existe supervisor con ese mismo colegiado. Por favor verificar que los datos sean correctos. 
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>       
  @endif    
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3>Editar supervisor</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('supervisor.actualizar', $supervisor->supervisor_id)}}" novalidate >    
    @method('PUT') 
    @csrf
    <div class="form-row">
      <div class="col-md-6 col-sm-12 mb-3">
        <label for="validationCustom01">Nombres</label>
        <input type="text" class="form-control" id="validationCustom01" required name="nombre" autofocus value="{{$supervisor->nombre}}">
        <div class="invalid-feedback">
          Por favor ingrese nombre del supervisor
        </div>
      </div>      
      <div class="col-md-6 col-sm-12 mb-3">
        <label for="validationCustom02">Apellidos</label>
        <input type="text" class="form-control" id="validationCustom02" required name="apellido" value="{{$supervisor->apellido}}">
        <div class="invalid-feedback">
          Por favor ingrese apellido del supervisor 
        </div>
      </div>      
    </div>
    <div class="form-row">
        <div class="col-md-2 col-sm-12 mb-3">
            <label for="validationCustom03">Telefono</label>
            <input type="text" class="form-control" id="validationCustom03" minlength="8"  required name="telefono" value="{{$supervisor->telefono}}">
            <div class="invalid-feedback">
            Ingrese un valor numérido de al menos 8 dígitos.
            </div>
        </div>      
        <div class="col-md-3 col-sm-12 mb-3">
            <label for="validationCustom03">Correo electrónico</label>
            <input type="email" class="form-control" id="validationCustom03"  required name="correo" value="{{$supervisor->correo}}">
            <div class="invalid-feedback">
            Ingrese un correo válido.
            </div>
        </div>      
        <div class="col-md-2 col-sm-12 mb-3">
            <label for="validationCustom03">No. Colegiado</label>
            <input type="number" min=1 class="form-control" id="validationCustom03" minlength="6"  required name="colegiado" value="{{$supervisor->colegiado}}">
            <div class="invalid-feedback">
            Ingrese un valor numérido de al menos 6 dígitos.
            </div>
        </div>      
        <div class="col-md-5 col-sm-12 mb-3">
            <label for="validationCustom04">Profesión</label>
            <input type="text" class="form-control" id="validationCustom04" minlength="9" required name="profesion" value="{{$supervisor->profesion}}">
            <div class="invalid-feedback">
            Por favor ingresar profesión del supervisor.
            </div>
        </div>      
    </div>    
    <div class="float-sm-right">
      <button class="btn btn-success" type="submit">Editar</button>
      <a class="btn btn-secondary" href="{{route('supervisor.index')}}" role="cancelar">Regresar</a>
    </div>    
  </form>
  </div>
</div>
@endsection
