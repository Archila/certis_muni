@extends('plantilla.plantilla',['sidebar'=>45])

@section('titulo', 'Tipo Empresa')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('empresa.index')}}">Empresas</a></li>
    <li class="breadcrumb-item active">Tipo de empresas</li>
@endsection

@section('alerta')
    @if(session('creado')>0)
    <script> alerta_create('Nuevo tipo de empresa agregado exitosamente.')</script>
    @endif

    @if(session('eliminado')>0)
    <script> alerta_delete('Tipo de empresa eliminado exitosamente.')</script>
    @endif

    @if(session('editado')>0)
    <script> alerta_edit('Tipo de empresa editado exitosamente.')</script>
    @endif
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <div class="row">
        <div class="col-md-9 col-sm-12">
            <h3>Listado de tipos de empresas</h3> 
        </div>
        <div class="col-md-3 col-sm-12">
            <a class="btn btn-block btn-primary btn-sm" href="{{route('tipo_empresa.crear')}}">Nuevo tipo</a>
        </div>
    </div>
    
  </div>
  <div class="card-body">
  <table id="datatable" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Activo</th>
            <th>Creado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($tipos as $t)
        <tr>
            <td>{{$t->nombre}}</td>
            <td>{{$t->descripcion}}</td>    
            <td>
            @if($t->activo==1)
            <span class="badge bg-success">SI</span>
            @else
            <span class="badge bg-danger">NO</span>
            @endif
            </td>
            <td>{{$t->created_at}}</td>    
            <td>
                <div class="btn-group">
                    <a href="{{route('tipo_empresa.editar', $t->id)}}" type="button" class="btn btn-success btn-xs"><i class="fas fa-edit"></i></a>
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" 
                    data-target="#modal-eliminar" data-id="{{$t->id}}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>    
        </tr>
    @endforeach
    </tbody>    
</table>
  </div>
</div>

<div class="modal fade" id="modal-eliminar">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Eliminar tipo empresa</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Confirmar eliminación de registro. Esta acción no se puede deshacer.</p>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <form  method="post" action="{{route('tipo_empresa.eliminar')}}" >
            @method('DELETE')
            @csrf
                <input type="hidden" name="id" id="input" class="form-control">
                <button type="submit" class="btn btn-danger">Eliminar</button>
            </form>            
        </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal eliminar -->

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

