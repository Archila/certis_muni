@extends('plantilla.plantilla',['sidebar'=>46])

@section('titulo', 'Nuevo tipo empresa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('tipo_empresa.index')}}">Tipo de empresas</a></li>
    <li class="breadcrumb-item active">Nuevo tipo</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>ERROR</strong> Ya existe un tipo de emrpresa con esos valores, intente nuevos datos.
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>       
  @endif    
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3>Crear nuevo tipo</h3> 
  </div>
  <div class="card-body">
  <form class="needs-validation" method="POST" action="{{route('tipo_empresa.guardar')}}" novalidate>    
    @csrf
    <div class="form-row">
      <div class="col-md-5 mb-3">
        <label for="validationCustom03">Nombre del tipo de empresa</label>
        <input type="text" class="form-control" id="validationCustom03" required name="nombre" autofocus>
        <div class="invalid-feedback">
          Por favor ingrese nombre de 
        </div>
      </div>      
      <div class="col-md-7 mb-3">
        <label for="validationCustom05">Descripción</label>
        <input type="text" class="form-control" id="validationCustom05" name="descripcion">       
      </div>      
    </div>
    <div class="float-sm-right">
      <button class="btn btn-primary" type="submit">Crear</button>
      <a class="btn btn-secondary" href="{{route('tipo_empresa.index')}}" role="cancelar">Regresar</a>
    </div>    
  </form>
  </div>
</div>
@endsection


@section('page_script')
<!-- Page script -->
<script>
  $(function () {    
    $("input[data-bootstrap-switch]").each(function(){
      $(this).bootstrapSwitch('state', $(this).prop('checked'));
    });
  })
</script>
@endsection

