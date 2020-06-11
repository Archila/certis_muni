@extends('plantilla.plantilla',['sidebar'=>71])

@section('titulo', 'Nueva carrera')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('carrera.index')}}">Carreras</a></li>
    <li class="breadcrumb-item active">Nueva carrera</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe carrera con ese código')</script>
  @endif
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3>Crear nueva carrera</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('carrera.guardar')}}" novalidate>    
    @csrf
    <div class="form-row">
      <div class="col-md-7 mb-3">
        <label for="validationCustom03">Nombre de la carrera</label>
        <input type="text" class="form-control" id="validationCustom03" required name="nombre" autofocus>
        <div class="invalid-feedback">
          Por favor ingrese nombre de la carrera
        </div>
      </div>      
      <div class="col-md-3 mb-3">
        <label for="validationCustom05">Código</label>
        <input type="number" min="1" class="form-control" id="validationCustom05" required name="codigo">
        <div class="invalid-feedback">
          Ingrese un código válido
        </div>
      </div>
      <div class="col-md-2 mb-3">
        <label for="validationCustom06">Prefijo</label>
        <input type="text" class="form-control" id="validationCustom06" minlength="4" required name="prefijo">
        <div class="invalid-feedback">
          Ingrese un prefijo de al menos 4 caracteres.
        </div>
      </div>
    </div>
    <div class="float-sm-right">
      <button class="btn btn-primary" type="submit">Crear</button>
      <a class="btn btn-secondary" href="{{route('carrera.index')}}" role="cancelar">Regresar</a>
    </div>    
  </form>
  </div>
</div>
@endsection

