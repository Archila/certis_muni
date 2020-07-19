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
            <h3>Bitácora    </h3> 
        </div>
        @if($btn_nuevo)        
        @endIf
    </div>
    
  </div>
  <div class="card-body">
  @if(Auth::user()->rol->id!=2)
  <table id="datatable" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Estudiante</th>
            <th>Registro</th>
            <th>Horas</th>
            <th>Empresa</th>
            <th>Encargado</th>
            <th>Estado</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($estudiantes as $e)       
        @foreach ($bitacoras as $b)
        @if($e->usuario_id== $b->usuario_id)         
        <tr>
            <td>{{$e->nombre}} {{$e->apellido}}</td>    
            <td>{{$e->registro}}</td>
            <td>{{$b->horas}}</td>    
            <td>{{$b->empresa}}</td>
            <td>{{$b->nombre}}{{' '}}{{$b->apellido}} ({{$b->puesto}})</td>
            <td>
                @if($b->oficio || $b->valida)
                    @if($b->valida)
                    <span class="badge badge-success">Activa</span>
                    @else
                    <a href="{{route('pdf.oficio', $b->bitacora_id)}}" type="button" class="btn btn-info btn-xs">En oficio</a>                 
                    @endif
                @else
                <a href="{{route('pdf.oficio', $b->bitacora_id)}}" type="button" class="btn btn-secondary btn-xs">No revisada</a>            
                @endif
            </td>
            <td>
                <div class="btn-group">
                @if($b->oficio || $b->valida)
                    @if($b->oficio)
                    <a href="{{route('pdf.oficio', $b->bitacora_id)}}" type="button" class="btn btn-info btn-xs"><i class="fas fa-file-pdf"></i></a>
                    @endif
                @else
                
                @endif
                    
                    <a href="{{route('bitacora.ver', $b->bitacora_id)}}" type="button" class="btn btn-success btn-xs"><i class="fas fa-eye"></i></a>
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" 
                    data-target="#modal-eliminar" data-id="{{$b->id}}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </td>              
        </tr>
        @endif  
        @endforeach 
    @endforeach
    </tbody>    
</table>

@endif
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

