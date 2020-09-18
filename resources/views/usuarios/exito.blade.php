@extends('plantilla.plantilla',['sidebar'=>71])

@section('titulo', 'Nueva contraseña')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
@endsection

@section('alerta')
  @if (session('validado'))
  <script> alerta_create('Validación exitosa.')</script>
  @else
  @endif
@endsection

@section('contenido')
<div class="card col-md-4 offset-md-4">
  <div class="card-header">
    <h3>Cambio de contraseña</h3> 
  </div>
  <div class="card-body">
    <div class="form-row">
        <div class="alert alert-success" role="alert">
        Contraseña cambiada exitosamente.
        </div>
    </div>    
  </div>
</div>
@endsection


