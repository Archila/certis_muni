@extends('plantilla.plantilla',['sidebar'=>60])

@section('titulo', 'Bitácoras')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item active">Bitácoras</li>
@endsection

@section('alerta')
    @if(session('creado')>0)
    <script> alerta_create('Nueva bitácora agregada exitosamente.')</script>
    @endif

    @if(session('eliminado')>0)
    <script> alerta_delete('Bitácora eliminada exitosamente.')</script>
    @endif

    @if(session('editado')>0)
    <script> alerta_edit('Bitácora editada exitosamente.')</script>
    @endif
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <div class="row">
        <div class="col-md-9 col-sm-12">
            <h3>Mis bitácoras</h3> 
        </div>
        @if($btn_nuevo)
        <div class="col-md-3 col-sm-12">
            <a class="btn btn-block btn-primary btn-sm" href="{{route('bitacora.crear')}}">Nueva bitácora</a>
        </div>
        @endIf
    </div>
    
  </div>
  <div class="card-body">
  <table id="datatable" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Semestre</th>
            <th>Año</th>
            <th>Horas</th>
            <th>Empresa</th>
            <th>Encargado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($bitacoras as $b)
        <tr>
            <td>{{$b->semestre}}</td>
            <td>{{$b->year}}</td>
            <td>{{$b->horas}}</td>    
            <td>{{$b->empresa}}</td>
            <td>{{$b->nombre}}{{' '}}{{$b->apellido}} ({{$b->puesto}})</td>
            <td>
                <div class="btn-group">
                    <a href="{{route('bitacora.ver', $b->bitacora_id)}}" type="button" class="btn btn-success btn-xs"><i class="fas fa-edit"></i></a>
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" 
                    data-target="#modal-eliminar" data-id="{{$b->id}}">
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
            <h4 class="modal-title">Eliminar bit</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <p>Confirmar eliminación de registro. Esta acción no se puede deshacer.</p>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            <form  method="post" action="{{route('bitacora.eliminar')}}" >
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

