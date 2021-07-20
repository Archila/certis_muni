@extends('plantilla.plantilla',['sidebar'=>50])

@section('titulo', 'Encargados')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item active">Encargados</li>
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
            <h3>Listado de encargados</h3> 
        </div>
        @if($btn_nuevo)
        <div class="col-md-3 col-sm-12">
            <a class="btn btn-block btn-primary btn-sm" href="{{route('encargado.crear')}}">Nuevo encargado</a>
        </div>
        @endIf
    </div>

    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-light float-right">
                <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Buscar" aria-label="Search" name="search" value="{{$busqueda}}">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fas fa-search-plus"></i></button>
                </form>
            </nav>
        </div>   
    </div>  
    
  </div>
  <div class="card-body">
  <table id="datatable" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Puesto</th>
            <th>Empresa</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($encargados as $e)
        <tr>
            <td>{{$e->nombre}}</td>
            <td>{{$e->apellido}}</td>    
            <td>{{$e->telefono}}</td>    
            <td>{{$e->correo}}</td>    
            <td>{{$e->puesto}}</td>
            <td>{{$e->empresa ?? 'Sin empresa'}}</td>   
            <td>
                <div class="btn-group">                    
                    <a href="{{route('encargado.editar', $e->encargado_id)}}" type="button" class="btn btn-success btn-xs"><i class="fas fa-edit"></i></a>
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" 
                    data-target="#modal-eliminar" data-id="{{$e->encargado_id}}">
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
            <form  method="post" action="{{route('encargado.eliminar')}}" >
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

