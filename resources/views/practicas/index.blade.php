@extends('plantilla.plantilla',['sidebar'=>65])

@section('titulo', 'Prácticas finales')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('practica.index')}}">Prácticas finales</a></li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe solicitud en el sistema')</script>
  @endif
@endsection

@section('contenido')
<div class="card">
    <div class="card-header">
        <h3>Prácticas finales</h3> 
    </div>

    <div class="card-body">

    @empty($estudiantes)
        <div class="callout callout-danger">
            <h5> <i class="icon fas fa-exclamation-triangle"></i> No hay estudiantes agregados para su usuario.</h5>
        </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                <div class="card-header">
                    <h2 class="card-title">Bitácoras</h2>
                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">        
                @empty($bitacoras)<!-- NO HAY BITACORAS EN EL SISTEMA -->
                <h5 class="col-sm-6 "><b>No hay bitácoras en el sistema</b></h5>
                @else<!--BITACORAS EN EL SISTEMA -->  
                <table class="table">
                    <thead class="thead-light">
                        <th>Estudiante</th>
                    </thead>
                    @foreach($bitacoras as $b)
                        @foreach($estudiantes as $e)

                        @endforeach
                    @endforeach
                </table>  
                @endempty <!-- BITACORAS -->  
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>    

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                <div class="card-header">
                    <h2 class="card-title">Solicitudes práctica</h2>
                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">        
                @empty($oficios)<!-- NO HAY BITACORAS EN EL SISTEMA -->
                <h5 class="col-sm-6 "><b>No hay solicitudes en el sistema</b></h5>
                @else<!--BITACORAS EN EL SISTEMA -->  
                <table class="table">
                    <thead class="thead-light">
                        <th>Estudiante</th>
                        <th>Carne</th>
                        <th>Registro</th>                        
                        <th>Fecha solicitud</th>
                        <th>Tipo</th>
                        <th>Estado</th>
                        <th></th>
                    </thead>
                    <tbody>
                    @foreach($oficios as $o)
                        @foreach($estudiantes as $e)
                        @if($o->usuario_id == $e->usuario_id)
                        <tr>
                            <td>{{$e->nombre}} {{$e->apellido}}</td>
                            <td>{{$e->carne}} </td>
                            <td>{{$e->registro}}</td>
                            <td>{{date('d-M-Y', strtotime($o->created_at))}}</td>
                            <td>
                            @if($o->tipo == 1)                                
                            <span class="badge bg-lightblue">Docente</span>                                
                            @elseif($o->tipo == 2)
                            <span class="badge bg-gray">Investigación</span>  
                            @else
                            <span class="badge bg-navy">Aplicada</span>  
                            @endif
                            </td>
                            <td>
                            @if($o->aprobado)                                
                            <span class="badge badge-success">Aprobada</span>  </td>
                            <td>
                            <a href="{{route('oficio.pdf', $o->id)}}" type="button" class="btn btn-primary btn-xs"><i class="fas fa-file-pdf"></i></a>
                            </td>              
                            @else
                            <span class="badge badge-warning">No aprobada</span>  
                            </td>
                            <td>
                            <a href="{{route('oficio.ver', $o->id)}}" type="button" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a>
                            </td>
                            @endif
                            
                        </tr>
                        @endif
                        @endforeach
                    @endforeach
                    </tbody>                    
                </table>  
                @endempty <!-- BITACORAS -->  
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>    
    @endempty

        
    
    
    </div>

</div>
@endsection

@section('page_script')
<!-- page script -->
<script>
   
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>

@endsection

