@extends('plantilla.plantilla',['sidebar'=>30])

@section('titulo', 'Estudiantes')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item active">Estudiantes</li>
@endsection

@section('alerta')    
        @if(session('creado')>0)
        <script> alerta_create('Nuevo estudiante agregado exitosamente.')</script>
        @endif

        @if(session('eliminado')>0)
        <script> alerta_delete('Estudiante eliminado exitosamente.')</script>
        @endif

        @if(session('editado')>0)
        <script> alerta_edit('Estudiante editado exitosamente.')</script>
        @endif
        @if(session('duplicado'))
        <script> alerta_edit('Estudiante creado exitosamente. El estudiante es duplicado')</script>
        @endif
@endsection

@section('contenido')
<div class="container row">
<ul class="navbar-nav ml-auto">
  <li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Semestre @php echo $semestre; @endphp - Año @php echo $year; @endphp
    </a>
    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
      <a href="{{route('estudiante.index', ['year'=>2020, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2020</a>
      <a href="{{route('estudiante.index', ['year'=>2021, 'semestre'=>1])}}" class="dropdown-item">Semestre 1 - 2021</a>
      <a href="{{route('estudiante.index', ['year'=>2021, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2021</a>
      <a href="{{route('estudiante.index', ['year'=>2022, 'semestre'=>1])}}" class="dropdown-item">Semestre 1 - 2022</a>
      <a href="{{route('estudiante.index', ['year'=>2022, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2022</a>
    </div>
  </li>
</ul>
</div>

<div class="card">
  <div class="card-header">
    <div class="row">
        <div class="col-md-9 col-sm-12">
            <h3>Listado de estudiantes Semestre @php echo $semestre; @endphp - Año @php echo $year; @endphp</h3> 
        </div>
        <div class="col-md-3 col-sm-12">
            <a class="btn btn-block btn-primary btn-sm" href="{{route('estudiante.crear')}}">Nuevo estudiante</a>
        </div>
    </div>    
  </div>
  <div class="card-body">
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
  <table id="datatable" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Registro</th>
            <th>Carne</th>
            <th>Carrera</th>
            <th>Usuario</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    @foreach ($estudiantes as $e)
        <tr>
            <td>{{$e->nombre}}</td>
            <td>{{$e->apellido}}</td>    
            <td>{{$e->registro}}</td>    
            <td>{{$e->carne}}</td>    
            <td>{{$e->carrera}}</td>    
            <td>
            @foreach($usuarios as $u)
                @if($e->persona_id==$u->persona_id)
                <p>{{$u->carne}}</p>
                @endif
            @endforeach
            </td>
            <td>
                <div class="btn-group">
                    <a href="{{route('estudiante.editar', $e->estudiante_id)}}" type="button" class="btn btn-success btn-xs"><i class="fas fa-edit"></i></a>
                    <button type="button" class="btn btn-danger btn-xs" data-toggle="modal" 
                    data-target="#modal-eliminar" data-id="{{$e->estudiante_id}}">
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
            <form  method="post" action="{{route('estudiante.eliminar')}}" >
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
<script type="text/javascript">
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

