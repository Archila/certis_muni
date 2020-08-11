@extends('plantilla.plantilla',['sidebar'=>62])

@section('titulo', 'Ver bitácora')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    @if(Auth()->user()->rol->id==2)
    <li class="breadcrumb-item"><a href="{{route('practica.index')}}">Práctica</a></li>
    <li class="breadcrumb-item active">{{$bitacora->nombre}}</li>    
    @else
    <li class="breadcrumb-item"><a href="{{route('practica.index')}}">Práctica</a></li>
    <li class="breadcrumb-item active">Bitácora - {{$estudiante->nombre}} {{$estudiante->apellido}} ({{$estudiante->registro}})</li>
    @endif
@endsection

@section('alerta')
  @if (session('oficio')>0)
  <script> alerta_info('Oficio generado exitosamente.')</script>
  @endif  
  @if (session('valido')>0)
  <script> alerta_info('La bitácora ya está validada.')</script>
  @endif
  @if (session('revisado')>0)
  <script> alerta_info('No se puede editar, el folio ya fue revisado')</script>
  @endif
  @if (session('editado')>0)
  <script> alerta_create(' Folio editado exitosamente')</script>
  @endif
@endsection

@section('contenido')
<div class="card card-primary card-outline">
        <div class="card-header">
        @if($bitacora->semestre==1) @php $semestre='Primer semestre'; @endphp @else @php $semestre='Segundo semestre'; @endphp @endif
        <h4 class="">
            {{$bitacora->nombre}}
        </h4>
        </div>
        <div class="card-body">
        @if(Auth()->user()->rol->id !=2)
        <div class="callout callout-info">
          <h5 class="my-n2">Oficio: {{$oficio->no_oficio}}</h5>
        </div>       
        @endif
        @if(Auth()->user()->rol->id !=2)
        <div class="callout callout-success">
          <h5 class="my-n2">No. de bitácora: {{$bitacora->codigo}}</h5>
        </div>       
        @endif
        <div class="row shadow-sm bg-white rounded">
          <p class="col-sm-6 mb-n1 mt-1"><b>Estudiante: </b>{{$estudiante->nombre}} {{$estudiante->apellido}}</p>
          <p class="col-sm-3 mb-n1 mt-1"><b>Registro:  </b> {{$estudiante->registro}}</p>
          <p class="col-sm-3 mb-n1 mt-1"><b>Carne:  </b> {{$estudiante->carne}}</p>
          <p class="col-sm-4 "><b>Carrera:  </b> {{$estudiante->carrera}}</p>
          <p class="col-sm-2 "><b>Promedio:  </b> {{$estudiante->promedio}}</p>
          <p class="col-sm-2 "><b>Créditos:  </b> {{$estudiante->creditos}}</p>
          <p class="col-sm-2 "><b>Año:  </b> {{$estudiante->year}}</p>
          <p class="col-sm-2 "><b>Semestre:  </b> {{$estudiante->semestre}}</p>
          <hr>
          <p class="col-sm-6 my-n1"><b>Empresa: </b>{{$empresa->nombre}}</p>
          <p class="col-sm-6 my-n1"><b>Dirección: </b>{{$empresa->direccion}}</p>
          <p class="col-sm-6 "><b>Ubicación: </b>{{$empresa->ubicacion}}</p>
          <p class="col-sm-6 "></p>
          <hr>
          <p class="col-sm-6 mt-n1"><b>Encargado: </b>{{$encargado->nombre}} {{$encargado->apellido}}</p>
          <p class="col-sm-6 mt-n1"><b>Puesto: </b>{{$encargado->puesto}}</p>
        </div>
        
        <div class="row mt-2">
            <div class="col-md-9 col-sm-12 ">
                <h4>Horas acumuladas: {{$bitacora->horas}}</h4>
            </div>
            <div class="col-md-3 mb-3">
              <div class="btn-group">
                  <button type="button" class="btn btn-outline-success dropdown-toggle" data-toggle="dropdown">
                  Opciones
                  </button>
                  <div class="dropdown-menu dropdown-menu-left" role="menu">
                    @if(Auth()->user()->rol->id ==2)                    
                    <a href="{{route('bitacora.crear_folio', $bitacora->id)}}" class="dropdown-item">Agregar folio</a>
                    <a href="{{route('oficio.respuesta', $oficio->id)}}" class="dropdown-item">Respuesta pdf</a>     
                    @else
                    <a href="{{route('bitacora.revisar', $bitacora->id)}}" class="dropdown-item">Revisar folios</a>
                    <a href="{{route('pdf.oficio', $bitacora->id)}}" class="dropdown-item">Ver oficio</a>
                    <a href="{{route('oficio.respuesta', $oficio->id)}}" class="dropdown-item">Respuesta pdf</a>  
                    @endif
                    <a class="dropdown-divider"></a>
                    <a href="{{route('pdf.caratula', $bitacora->id)}}" class="dropdown-item">Ver Caratula</a>
                    <a href="{{route('pdf.caratula', $bitacora->id)}}" class="dropdown-item">Imprimir folios</a>
                    <a href="{{route('pdf.caratula', $bitacora->id)}}" class="dropdown-item">Generar folios vacio</a>
                  </div>                  
              </div>
            </div>            
        </div>
          <div class="col-12">
            <div class="card card-primary card-tabs">
              <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-two-tab" role="tablist">
                  <li class="pt-2 px-3"><h3 class="card-title">Folios</h3></li>
                    @php $activo='active'; @endphp
                    @foreach ($folios as $f)
                    <li class="nav-item">
                    <a class="nav-link {{$activo}}" id="custom-tabs-two-home-tab" data-toggle="pill" href="#custom-tabs-two-{{$f->id}}" role="tab" aria-controls="custom-tabs-two-home" aria-selected="false">#{{$f->numero}}</a>
                    </li>    
                    @php $activo=''; @endphp
                    @endforeach
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content" id="custom-tabs-two-tabContent">
                    @php $activo='show active'; @endphp
                    @foreach ($folios as $f)
                    <div class="tab-pane fade {{$activo}}" id="custom-tabs-two-{{$f->id}}" role="tabpanel" aria-labelledby="custom-tabs-two-home-tab">
                        <div class="row">
                            <div class="col-12 col-sm-3">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Fecha inicial</span>
                                <span class="info-box-number text-center text-muted mb-0">{{date('d-m-Y', strtotime($f->fecha_inicial))}}</span>
                                </div>
                            </div>
                            </div>
                            <div class="col-12 col-sm-3">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Fecha final</span>
                                <span class="info-box-number text-center text-muted mb-0">{{date('d-m-Y', strtotime($f->fecha_final))}}</span>
                                </div>
                            </div>
                            </div>
                            <div class="col-12 col-sm-3">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Horas </span>
                                <span class="info-box-number text-center text-muted mb-0">{{$f->horas}}<span>
                                </div>
                            </div>
                            </div>
                            <div class="col-12 col-sm-3">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                <span class="info-box-text text-center text-muted">Revisado </span>
                                <span class="info-box-number text-center text-muted mb-0">
                                @if($f->revisado) <span class="badge bg-success">SI</span> @else <span class="badge bg-danger">NO</span> @endif
                                <span>
                                </div>
                            </div>
                            </div>
                        </div> 
                        <div class="row">
                            <h4>Descripción</h4>
                        </div>     
                        <div class="post px-2" style="text-align: justify; text-justify: inter-word;">                        
                          <p> {{$f->descripcion}} </p>                       
                        </div>
                        <div class="row mt-n1">
                            <h4>Observaciones</h4>
                        </div>     
                        <div class="post px-2" style="text-align: justify; text-justify: inter-word;">                        
                          <p> {{$f->observaciones}} </p>                       
                        </div>    
                        <div class="row">
                          <div class="col-md-2 offset-md-10">
                          @if(!$f->revisado)
                          <a href="{{route('folio.editar', $f->id)}}" class="btn btn-block btn-sm btn-outline-success">Editar folio</a>
                          @endif
                          </div>
                        </div>                    
                    </div>
                    @php $activo=''; @endphp
                    @endforeach  
                </div>
              </div>
              <!-- /.card -->
            </div>  
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


