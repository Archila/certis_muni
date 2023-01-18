@extends('plantilla.plantilla',['sidebar'=>65])

@section('titulo', 'Prácticas finales')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>    
    <li class="breadcrumb-item active">Prácticas finales</li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe solicitud en el sistema')</script>
  @endif
  @if (session('creado')>0)
  <script> alerta_create('Bitácora creada exitosamente')</script>
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
        <a href="{{route('practica.index', ['year'=>2020, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2020</a>
        <a href="{{route('practica.index', ['year'=>2021, 'semestre'=>1])}}" class="dropdown-item">Semestre 1 - 2021</a>
        <a href="{{route('practica.index', ['year'=>2021, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2021</a>        
        <a href="{{route('practica.index', ['year'=>2022, 'semestre'=>1])}}" class="dropdown-item">Semestre 1 - 2022</a>      
        <a href="{{route('practica.index', ['year'=>2022, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2022</a>      
        <a href="{{route('practica.index', ['year'=>2023, 'semestre'=>1])}}" class="dropdown-item">Semestre 1 - 2023</a>      
        <a href="{{route('practica.index', ['year'=>2023, 'semestre'=>2])}}" class="dropdown-item">Semestre 2 - 2023</a>
    </div>
  </li>
</ul>
</div>

<div class="card">
    <div class="card-header">
        <h3>Prácticas finales Semestre @php echo $semestre; @endphp - Año @php echo $year; @endphp</h3> 
    </div>

    <div class="card-body">

        <div class="row">
            <div class="col-12">
                <div class="card card-outline card-primary">
                <div class="card-header">
                    <h2 class="card-title">Cartas de solicitud y compromiso de prácticas finales</h2>
                    <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                    </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">        
                @empty($solicitudes)<!-- NO HAY CARTAS EN EL SISTEMA -->
                <h5 class="col-sm-6 "><b>No hay solicitudes en el sistema</b></h5>
                @else<!--BITACORAS EN EL SISTEMA -->  
                <table class="table">
                    <thead class="thead-light">
                        <th>Estudiante</th>
                        <th>Correo</th>
                        <th>Registro</th>
                        <th>Constancia</th>
                        <th>Certificación</th>
                        <th>Cronograma</th>
                        <th>Carta solicitud</th>
                    </thead>                    
                    @foreach($solicitudes as $s) <!--  CICLO SOLICITUDES -->                        
                    <tr>
                        <td>{{$s->nombre}} {{$s->apellido}}</td>
                        <td>{{$s->correo}} </td>
                        <td>{{$s->registro}}</td>

                        <td>
                            @empty($s->ruta_constancia)
                            <small><i class="fas fa-window-close"></i></small>
                            @else
                            <a href="{{route('pdf.ver', ['ruta'=>$s->ruta_constancia])}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i></a>
                            @endempty
                        </td>

                        <td>
                            @empty($s->ruta_certificacion)
                            <small><i class="fas fa-window-close"></i></small>
                            @else
                            <a href="{{route('pdf.ver', ['ruta'=>$s->ruta_certificacion])}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i></a>
                            @endempty
                        </td>

                        <td>
                            @empty($s->ruta_cronograma)
                            <small><i class="fas fa-window-close"></i></small>
                            @else
                            <a href="{{route('pdf.ver', ['ruta'=>$s->ruta_cronograma])}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i></a>
                            @endempty
                        </td>

                        <td>
                            @empty($s->ruta_carta)
                            <small><i class="fas fa-window-close"></i></small>
                            @else
                            <a href="{{route('pdf.ver', ['ruta'=>$s->ruta_carta])}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i></a>
                            @endempty
                        </td>
                    </tr>
                    @endforeach <!-- FIN CICLO BITACORAS -->
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
                        <th></th>
                        <th>Estudiante</th>
                        <th>Correo</th>
                        <th>Registro</th>
                        <th>No. Bitácora</th>
                        <th>Tipo</th>
                    </thead>
                    @foreach($bitacoras as $b) <!-- CICLO BITACORAS -->
                    <tr>
                        <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-cog"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-left" role="menu">
                            <a href="{{route('bitacora.ver', $b->bitacora_id)}}" class="dropdown-item">Ver bitácora</a>
                            <a href="{{route('oficio.pdf', $b->oficio_id)}}" class="dropdown-item">Ver oficio pdf</a>
                            <a href="{{route('oficio.respuesta', $b->oficio_id)}}" class="dropdown-item">Ver respuesta pdf</a>   
                        </div>  
                        </td>
                        <td>{{$b->nombre}} {{$b->apellido}}</td>
                        <td>{{$b->correo}} </td>
                        <td>{{$b->registro}}</td>
                        <td>
                        @if($b->codigo)
                        {{$b->codigo}}
                        @else
                        <span >--</span>
                        @endif
                        </td>                                
                        <td>
                        @if($b->tipo == 1)                                
                        <span class="badge bg-lightblue">Docente</span>                                
                        @elseif($b->tipo == 2)
                        <span class="badge bg-gray">Investigación</span>  
                        @else
                        <span class="badge bg-navy">Aplicada</span>  
                        @endif
                        </td>
                    </tr>
                    @endforeach<!-- FIN CICLO BITACORAS -->
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
                                <th></th>
                                <th>Estudiante</th>
                                <th>Correo</th>
                                <th>Registro</th>                        
                                <th>No. Oficio</th>
                                <th>Tipo</th>
                                <th>Estado</th>                        
                            </thead>
                            <tbody>
                            @foreach($oficios as $o)
                            <tr>
                                @if($o->aprobado)
                                <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-left" role="menu">
                                    <a href="{{route('oficio.pdf', $o->id)}}" class="dropdown-item">Ver oficio pdf</a>
                                    @if(!$o->revisado)
                                    <a href="{{route('oficio.revisar', $o->id)}}" class="dropdown-item">Revisar</a>
                                    @else
                                    <a href="{{route('oficio.respuesta', $o->id)}}" class="dropdown-item">Respuesta pdf</a>                                
                                    @endif
                                </div>
                                                
                                </td>
                                @else
                                <td>
                                <div class="btn-group">
                                    <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-left" role="menu">
                                    <a href="{{route('oficio.ver', $o->id)}}" class="dropdown-item">Ver solicitud</a>                                
                                </div>              
                                </td>
                                @endif
                                <td>{{$o->nombre}} {{$o->apellido}}</td>
                                <td>{{$o->correo}} </td>
                                <td>{{$o->registro}}</td>
                                <td>
                                @if($o->no_oficio)
                                {{$o->no_oficio}}
                                @else
                                <span >--</span>
                                @endif
                                </td>    
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
                                @if($o->rechazado)                                
                                <span class="badge badge-danger">Rechazado</span>                                                  
                                </td>              
                                @else
                                    @if($o->revisado)
                                    <span class="badge badge-success">Aceptado</span>  
                                    </td>        
                                    @else
                                        @if($o->aprobado)
                                        <span class="badge bg-purple">Aprobado</span>  
                                        </td> 
                                        @else
                                        <span class="badge badge-warning">No aprobado</span>
                                        </td> 
                                        @endif
                                    @endif                            
                                </td>                            
                                @endif
                            </tr>
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

