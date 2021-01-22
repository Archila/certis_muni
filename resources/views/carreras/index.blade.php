@extends('plantilla.plantilla',['sidebar'=>70])

@section('titulo', 'Carreras')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item active">Carreras</li>
@endsection

@section('alerta')
    @if(session('creado')>0)
    <script> alerta_create('Nueva carrera agregada exitosamente.')</script>
    @endif

    @if(session('eliminado')>0)
    <script> alerta_delete('Carrera eliminada exitosamente.')</script>
    @endif

    @if(session('editado')>0)
    <script> alerta_edit('Carrera editada exitosamente.')</script>
    @endif
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <div class="row">
        <div class="col-md-9 col-sm-12">
            <h3>Listado de carreras</h3> 
        </div>
        <div class="col-md-3 col-sm-12">
            <a class="btn btn-block btn-primary btn-sm" href="{{route('carrera.crear')}}">Nueva carrera</a>
        </div>
    </div>
    
  </div>
  <div class="card-body">
  <table id="datatable" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Prefijo</th>
            <th>Creado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($carreras as $c)
        <tr>
            <td>{{$c->codigo}}</td>
            <td>{{$c->nombre}}</td>    
            <td>{{$c->prefijo}}</td>
            <td>{{$c->created_at}}</td>    
            <td>
                <div class="btn-group">
                    <a href="{{route('carrera.editar', $c->id)}}" type="button" class="btn btn-success btn-xs"><i class="fas fa-edit"></i></a>
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
            <h4 class="modal-title">Eliminar carrera</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Confirmar eliminación de registro. Esta acción no se puede deshacer.</p>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <form  method="post" action="{{route('carrera.eliminar')}}" >
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

