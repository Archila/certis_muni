@extends('plantilla.plantilla',['sidebar'=>40])

@section('titulo', 'Empresas')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item active">Empresas</li>
@endsection

@section('alerta')
    @if(session('creado')>0)
    <script> alerta_create('Nueva empresa agregada exitosamente.')</script>
    @endif

    @if(session('eliminado')>0)
    <script> alerta_delete('Empresa eliminada exitosamente.')</script>
    @endif

    @if(session('editado')>0)
    <script> alerta_edit('Empresa editada exitosamente.')</script>
    @endif
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <div class="row">
        <div class="col-md-8 col-sm-12">
            <h3>Listado de empresas</h3> 
        </div>
        <div class="col-md-2 col-sm-12">
            <a class="btn btn-block btn-primary btn-sm" href="{{route('empresa.crear')}}">Nueva empresa</a>
        </div>
        <div class="col-md-2 col-sm-12">
            <a class="btn btn-block btn-info btn-sm" href="{{route('tipo_empresa.index')}}">Tipos</a>
        </div>
    </div>
    
  </div>
  <div class="card-body">
  <table id="datatable" class="table table-sm table-responsive table-bordered table-hover">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Tipo</th>
            <th>Público</th>
            <th>Validado</th>
            <th>Calificación</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($empresas as $e)
        <tr>
            <td>{{$e->nombre}}</td>
            <td>{{$e->direccion}}</td>    
            <td>{{$e->telefono}}</td>    
            <td>{{$e->correo}}</td>    
            <td>{{$e->tipo}}</td>
            <td>
            @if($e->publico==1)
            <span class="badge bg-success">SI</span>
            @else
            <span class="badge bg-danger">NO</span>
            @endif
            </td>    
            <td>
            @if($e->valido==1)
            <span class="badge bg-success">SI</span>
            @else
            <span class="badge bg-danger">NO</span>
            @endif
            </td>    
            <td>            
            @if($e->calificacion=="Bien")
            <span class="badge bg-success">BIEN</span>
            @elseif ($e->calificacion=="Regular")
            <span class="badge bg-warning">REGULAR</span>
            @elseif($e->calificacion=="Mala")
            <span class="badge bg-danger">MALA</span>
            @else
            <span class="badge bg-secondary">Sin registro</span>
            @endif              
            </td>    
            <td>
                <div class="btn-group">
                    <a href="{{route('empresa.ver', $e->empresa_id)}}" type="button" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a>
                    <a href="{{route('empresa.editar', $e->empresa_id)}}" type="button" class="btn btn-success btn-xs"><i class="fas fa-edit"></i></a>
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" 
                    data-target="#modal-eliminar" data-id="{{$e->empresa_id}}">
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
            <h4 class="modal-title">Eliminar estudiante</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Confirmar eliminación de registro. Esta acción no se puede deshacer.</p>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <form  method="post" action="{{route('empresa.eliminar')}}" >
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
