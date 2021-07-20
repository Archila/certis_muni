@extends('plantilla.plantilla',['sidebar'=>50])

@section('titulo', 'Editar encargado')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('encargado.index')}}">Encargados</a></li>
    <li class="breadcrumb-item active">Editar encargado</li>
@endsection

@section('alerta')
    @if(session('creado')>0)
    <script> alerta_create('Nuevo encargado agregado exitosamente.')</script>
    @endif

    @if(session('eliminado')>0)
    <script> alerta_delete('Encargado eliminado exitosamente.')</script>
    @endif

    @if(session('editado')>0)
    <script> alerta_edit('Encargado editado exitosamente.')</script>
    @endif
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <div class="row">
        <div class="col-md-9 col-sm-12">
            <h3>Editar datos básico de encargado</h3> 
        </div>
    </div>
    
  </div>
  <div class="card-body">
    <form class="needs-validation" method="POST" action="{{route('encargado.actualizar',$encargado->encargado_id)}}" novalidate>   
        @Method('PUT')
        @csrf
        <input type="hidden" name="persona_id" value="{{$encargado->persona_id}}">   
        <div id="encargado-nuevo" style="display: block">
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="validationCustom08">Nombre</label>
                    <input type="text" class="form-control" id="validationCustom08" name="nombre" required value="{{$encargado->nombre}}"> 
                    <div class="invalid-feedback">
                    Ingrese nombre de encargado válido.
                    </div>      
                </div>    
                <div class="col-md-4 mb-3">
                    <label for="validationCustom08">Apellido</label>
                    <input type="text" class="form-control" id="validationCustom08" name="apellido" required value="{{$encargado->apellido}}"> 
                    <div class="invalid-feedback">
                    Ingrese nombre de encargado válido.
                    </div>      
                </div>   
                <div class="col-md-2 mb-3">
                    <label for="validationCustom09">Teléfono</label>
                    <input type="text" class="form-control" id="validationCustom09" name="telefono" required value="{{$encargado->telefono}}">
                    <div class="invalid-feedback">
                    Ingrese telefono de encargado válido. Al menos 8 dígitos.
                    </div>
                </div>     
                <div class="col-md-2 mb-3">
                    <label for="validationCustom08">Colegiado</label>
                    <input type="text" class="form-control" id="validationCustom08" name="colegiado" value="{{$encargado->colegiado}}">                   
                </div>        
                <small class="mt-n3 mb-2">&nbsp; &nbsp; *Se recomienda agregar el título de tratamiento al nombre del encargado. Ejemplo: Ing. Lic. Sr. Sra.</small>               
            </div>

            <div class="form-row">  
                <div class="col-md-4 mb-3">
                    <label for="validationCustom08">Dedicatoria (para cartas)</label>
                    <input type="text" class="form-control" id="validationCustom08" name="encabezado" placeholder="Ej. Estimado ingeniero. Respetable señora" required value="{{$encargado->encabezado}}">
                    <div class="invalid-feedback">
                    Ingrese el encabezado para cartas.
                    </div>      
                </div>           
                <div class="col-md-4 mb-3">
                    <label for="validationCustom08">Profesión</label>
                    <input type="text" class="form-control" id="validationCustom08" name="profesion" required value="{{$encargado->profesion}}"> 
                    <div class="invalid-feedback">
                    Ingrese profesión del encargado.
                    </div>      
                </div> 
                <div class="col-md-4 mb-3">
                    <label for="validationCustom10">Correo</label>
                    <input type="email" class="form-control" id="validationCustom10" name="correo" required value="{{$encargado->correo}}">
                    <div class="invalid-feedback">
                    Ingrese un correo electrónico válido.
                    </div>
                </div>    
            </div>
        </div>

        <div class="float-sm-right">
        <button class="btn btn-primary" type="submit">Guardar</button>
        <a class="btn btn-secondary" href="{{url()->previous()}}" role="cancelar">Regresar</a>
        </div>    
    </form>
  </div>
</div>


@endsection

@section('page_script')
<!-- page script -->
<script>
  $(function () {    
    $('#datatable').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });

  $('#modal-eliminar').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var id = button.data('id') // Extract info from data-* attributes
  var modal = $(this)
  document.getElementById('input').setAttribute('value',id)
})
</script>
@endsection

