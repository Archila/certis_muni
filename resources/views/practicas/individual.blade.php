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

  @if(count($errors) > 0)
    @foreach ($errors->all() as $error)
    <script> alerta_error({{$error}})</script>
    @endforeach
  @endif
@endsection

@section('contenido')
<div class="card">
    <div class="card-header">
        <h3>Prácticas finales</h3> 
    </div>

    <div class="card-body">

    @empty($bitacora) @php $collapsed = ""; @endphp 
    @else @php $collapsed = "collapsed-card"; @endphp @endempty

    <div class="card card-warning @php echo $collapsed; @endphp">
      <div class="card-header">
        <h3 class="card-title">Requisitos y carta de solicitud y compromiso.</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
          </button>
        </div>
        <!-- /.card-tools -->
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-4 order-2 order-md-1">
              <h3 class="text-primary"><i class="fas fa-clipboard"></i> 
              Plantillas para cartas de solicitud y compromiso de prácticas finales</h3>
              <div class="text-muted">
                  <p class="text-sm">Los siguientes son documentos que sirven como guía para generar su carta de 
                  solicitud y compromiso de prácticas finales. Por favor sustituya los textos en rojo con la información 
                  correspondiente, imprima la carta (blanco y negro); firme la carta y luego la sube al sistema por este 
                  medio como el requisito que corresponde.
                  </p>
              </div>              
                <ul class="list-unstyled">
                    <li>
                    <a href="{{route('pdf.aplicada')}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i>Aplicada</a>
                    </li>
                    <li>
                    <a href="{{route('pdf.docente')}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i>Docente</a>
                    </li>   
                    <li>
                    <a href="{{route('pdf.investigacion')}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i>Investigación</a>
                    </li>        
                </ul>         
          </div>

          <div class="col-12 col-md-12 col-lg-8 order-1 order-md-2">
            <h3>Requisitos</h3>
            <h5>Por favor subir todos los documentos en formato PDF</h5>
            <small style="color:red">** Cada archivo no puede ser mayor a 2 MB **</small>
              <div class="row mt-3"> <!-- Constancia de inscripción -->
                <div class="col-8 col-md-10">
                <small class="">Constancia de inscripción en PDF</small>
                  <form method="POST" action="{{route('solicitud.requisito')}}" enctype="multipart/form-data">
                  @csrf 
                    <div class="input-group">
                      <div class="">
                        <input type="file" name="file">
                      </div>
                      <input type="hidden" name="tipo" value=1>
                      <div class="input-group-append ml-3">
                        <button class="btn btn-outline-warning" type="submit">Guardar</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col-4 col-md-2 mt-3">
                  <div class="input-group">
                    @empty($solicitud->ruta_constancia)
                      <small>No hay archivo en la base de datos.</small>
                    @else
                    <a href="{{route('pdf.ver', ['ruta'=>$solicitud->ruta_constancia])}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i></a>
                    @endempty
                  </div>
                </div>
                <hr>
              </div> <!-- FIN constancia de inscripción -->

              <div class="row mt-3"> <!-- Certificación de cursos -->
                <div class="col-8 col-md-10">
                <small class="my-2">Certificación de cursos en PDF</small>
                  <form method="POST" action="{{route('solicitud.requisito')}}" enctype="multipart/form-data">
                  @csrf 
                    <div class="input-group">
                      <div class="">
                        <input type="file" name="file">
                      </div>
                      <input type="hidden" name="tipo" value=2>
                      <div class="input-group-append ml-3">
                        <button class="btn btn-outline-warning" type="submit">Guardar</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col-4 col-md-2 mt-3">
                  <div class="input-group">
                    @empty($solicitud->ruta_certificacion)
                      <small>No hay archivo en la base de datos.</small>
                    @else
                    <a href="{{route('pdf.ver', ['ruta'=>$solicitud->ruta_certificacion])}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i></a>
                    @endempty
                  </div>
                </div>
                <hr>
              </div> <!-- FIN certificación de cursos -->

              <div class="row mt-3"> <!-- Cronograma de actividades -->
                <div class="col-8 col-md-10">
                <small class="my-2">Planificación de actividades en PDF</small>
                  <form method="POST" action="{{route('solicitud.requisito')}}" enctype="multipart/form-data">
                  @csrf 
                    <div class="input-group">
                      <div class="">
                        <input type="file" name="file">
                      </div>
                      <input type="hidden" name="tipo" value=3>
                      <div class="input-group-append ml-3">
                        <button class="btn btn-outline-warning" type="submit">Guardar</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col-4 col-md-2 mt-3">
                  <div class="input-group">
                    @empty($solicitud->ruta_cronograma)
                      <small>No hay archivo en la base de datos.</small>
                    @else
                    <a href="{{route('pdf.ver', ['ruta'=>$solicitud->ruta_cronograma])}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i></a>
                    @endempty
                  </div>
                </div>
                <hr>
              </div> <!-- FIN cronograma de actividades -->

              <div class="row mt-3"> <!-- Carta solicitud y compromiso -->
                <div class="col-8 col-md-10">
                <small class="my-2">Carta de solicitud y compromiso firmada en PDF</small>
                  <form method="POST" action="{{route('solicitud.requisito')}}" enctype="multipart/form-data">
                  @csrf 
                    <div class="input-group">
                      <div class="">
                        <input type="file" name="file">
                      </div>
                      <input type="hidden" name="tipo" value=4>
                      <div class="input-group-append ml-3">
                        <button class="btn btn-outline-warning" type="submit">Guardar</button>
                      </div>
                    </div>
                  </form>
                </div>
                <div class="col-4 col-md-2 mt-3">
                  <div class="input-group">
                    @empty($solicitud->ruta_carta)
                      <small>No hay archivo en la base de datos.</small>
                    @else
                    <a href="{{route('pdf.ver', ['ruta'=>$solicitud->ruta_carta])}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i></a>
                    @endempty
                  </div>
                </div>
                <hr>
              </div> <!-- FIN carta solicitud y compromiso -->
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

    @empty($bitacora)<!-- ESTUDIANTE SIN BITACORA -->
      @empty($oficio) <!-- ESTUDIANTE SIN BITACORA NI OFICIO -->
      <div class="row">
        <div class="col-12">
          <div class="card card-outline card-primary">
            <div class="card-header">
              <h3 class="card-title">Solicitud practicas finales</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">              
              <h5 class="col-sm-6 "><b>No hay solicitud</h5>
              <h5 class="col-sm-12">Para poder iniciar su proceso, por favor ingrese una solicitud de prácticas finales. </h5>
              <br>
              <a  href="{{route('practica.solicitud')}}"><button class="btn btn-success">Nueva solicitud</button></a>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>        
        
      @else <!-- ESTUDIANTE SIN BITACORA PERO CON OFICIO -->

      <div class="row">
        <div class="col-12">
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Solicitud practicas finales</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">              
              <div class="row">                  
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Creación:  </span>
                      <span class="info-box-number text-center text-muted mb-0">{{date('d-m-Y', strtotime($oficio->created_at))}}</span>
                      </div>
                  </div>
                </div>
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Aprobada: </span>
                      <span class="info-box-number text-center text-muted mb-0">
                      @if($oficio->aprobado) <span class="badge bg-success">SI</span> @else <span class="badge bg-danger">NO</span> @endif
                      <span>
                      </div>
                  </div>
                </div>
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Tipo: </span>
                      <span class="info-box-number text-center text-muted mb-0">
                      @if($oficio->tipo == 1) Docencia @elseif($oficio->tipo == 2) Investigación @else Aplicada @endif
                      <span>
                      </div>
                  </div>
                </div>
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Semestre: </span>
                      <span class="info-box-number text-center text-muted mb-0">
                      @if($oficio->semestre == 1) Primero @else Segundo @endif
                      <span>
                      </div>
                  </div>
                </div>
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Año: </span>
                      <span class="info-box-number text-center text-muted mb-0">{{$oficio->year}}<span>
                      </div>
                  </div>
                </div> 
              </div> 
              <!-- /.FIN ROW 1 -->

              <dl class="row">
                <dd class="col-sm-12 mb-n1"> <b>Empresa: </b> {{$oficio->empresa}}</dd>
                <dd class="col-sm-6 "> <b>Dirección: </b> {{$oficio->direccion}}</dd>
                <dd class="col-sm-6 "> <b>Ubicación: </b> {{$oficio->ubicacion}}</dd>
                <dd class="col-sm-4 "> <b>Estudiante: </b> {{$oficio->estudiante}}</dd>
                <dd class="col-sm-3 "> <b>Carne: </b> {{$oficio->carne}}</dd>
                <dd class="col-sm-3 "> <b>Registro: </b> {{$oficio->registro}}</dd>       

                <dd class="col-sm-6 mb-n1"> <b>Destinatario: </b> {{$oficio->destinatario}}</dd>      
                <dd class="col-sm-6 mb-n1"> <b>Saludo: </b> {{$oficio->encabezado}}</dd>     
                @if($oficio->tipo == 1) 
                <dd class="col-sm-10 mb-n1"> <b>Curso: </b> {{$oficio->curso}}</dd>
                <dd class="col-sm-2 mb-n1"> <b>Código: </b> {{$oficio->codigo_curso}}</dd>
                @elseif($oficio->tipo == 2) 
                <dd class="col-sm-10 mb-n1"> <b>Tema o investigación: </b>"{{$oficio->curso}}"</dd>
                @else
                <dd class="col-sm-10 mb-n1"> <b>Puesto: </b>{{$oficio->puesto}}</dd>
                @endif
              </dl>                   

              <div class="row"> 
              @if($oficio->aprobado) 

                @if($oficio->revisado && !$oficio->rechazado)<!-- APROBADO Y REVISADO --->     
                <div class="callout callout-success">
                  <h5 > <i class="icon fas fa-check"></i> La solicitud de prácticas ya fue aprobada y revisada. Ya puede iniciar con la creación de una bitácora.</h5>
                  <br>         
                  <a  href="{{route('bitacora.crear')}}"><button class="btn btn-success">Nueva bitácora</button></a>     
                </div>   
                <!-- FIN APROBADO Y REVISADO --->           
                @else
                  @if($oficio->rechazado)
                  <div class="callout callout-warning">
                    <h5 > <i class="icon fas fa-exclamation-triangle"></i> La solicitud de prácticas no fue aceptada por la contraparte institucional, por favor cree una nueva solicitud.</h5>
                    <br>         
                    <a  href="{{route('practica.solicitud')}}"><button class="btn btn-success">Nueva solicitud</button></a>  
                  </div>   
                  <!-- FIN APROBADO Y REVISADO --->    
                  @else
                    @if($oficio->ruta_pdf)
                    <div class="callout callout-success">
                      <h5 > <i class="icon fas fa-check"></i> La respuesta ya ha sido enviada a su supervisor. Por favor espere o contácte con su supervisor de prácticas finales.</h5>
                      <br>    
                      <div class="row">
                        <div class="col-md-8 pr-3" style="height:30em;"><!--Formulario-->
                        <h4>Respuesta en el sistema</h4>
                          <iframe src="{{route('oficio.respuesta', $oficio->id)}}" 
                          width="100%" height="100%">

                          This browser does not support PDFs. Please download the PDF to view it: Download PDF

                          </iframe>
                        </div>   
                        <div class="col-md-4">
                          <form method="POST" action="{{route('practica.respuesta')}}" enctype="multipart/form-data">
                            @csrf 
                            <input type="hidden" value="{{$oficio->id}}" name="oficio_id">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="exampleInputFile">Cambiar archivo</label>
                                  <div class="input-group">
                                    <div class="custom-file">
                                      <input type="file" class="custom-file-input" id="exampleInputFile" name="file"> 
                                      <label class="custom-file-label" for="exampleInputFile">Seleccione pdf</label>
                                    </div>                                    
                                  </div>
                                </div>                      
                              </div>
                              <div class="col-md-12 mt-4">
                              <button type="submit" class="btn btn-primary">Cambiar</button>
                              </div>
                            </div>
                            </form>                  
                          </div>           
                        </div>
                      </div> 
                    @else
                    <div class="callout callout-success">
                      <h5 > <i class="icon fas fa-check"></i> La solicitud de prácticas ya fue aprobada. Si ya ha recibido la respuesta de la contraparte institucional, por favor envíe la respuesta en formato PDF. </h5>
                      <br>                 
                      <form method="POST" action="{{route('practica.respuesta')}}" enctype="multipart/form-data">
                      @csrf 
                      <input type="hidden" value="{{$oficio->id}}" name="oficio_id">
                      <div class="row">
                        <div class="col-md-9">
                          <div class="form-group">
                            <label for="exampleInputFile">Ingreso de archivo</label>
                            <div class="input-group">
                              <div class="custom-file">
                                <input type="file" class="custom-file-input" id="exampleInputFile" name="file">
                                <label class="custom-file-label" for="exampleInputFile">Seleccione pdf</label>
                              </div>                              
                            </div>
                          </div>                      
                        </div>
                        <div class="col-md-3 mt-4">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                        </div>
                      </div>
                      </form>                  
                    </div>           
                    @endif
                  @endif
                @endif      
              @else 
                <div class="callout callout-warning">
                  <h5> <i class="icon fas fa-exclamation-triangle"></i> La solicitud de prácticas no ha sido aprobada, por favor espere o contácte con su supervisor de prácticas finales.</h5>
                </div>
              @endif
              
              </div>
              <!-- /.FIN ROW 3 -->

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      @endempty <!-- FIN ESTUDIANTE SIN BITACORA CON/SIN OFICIO -->
    @else<!-- ESTUDIANTE CON BITACORA -->        
    
    <div class="card card-success">
      <div class="card-header">
        <h3 class="card-title">Bitácora</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
          </button>
        </div>
        <!-- /.card-tools -->
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col-12 col-md-12 col-lg-4 order-2 order-md-1">
              <h3 class="text-primary"><i class="fas fa-clipboard"></i> 
              {{$bitacora->nombre}}</h3>
              <div class="text-muted">
                  <p class="text-sm">Empresa / Institución
                  <b class="d-block">{{$empresa->nombre}} ({{$empresa->alias}})</b>
                  <p class="text-sm mt-n3">Dirección
                  <b class="d-block">{{$empresa->direccion}} ({{$empresa->ubicacion}})</b>
                  </p>
                  <p class="text-sm">Encargado
                  <b class="d-block">{{$encargado->nombre}} {{$encargado->apellido}}</b>
                  <p class="text-sm mt-n3">Puesto
                  <b class="d-block">{{$encargado->puesto}} </b>
                  </p>
              </div>                      
                <ul class="list-unstyled">
                    @if(Auth()->user()->rol->id !=2)     
                    <li>
                    <a href="{{route('pdf.oficio', $bitacora->id)}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i>Ver oficio</a>
                    </li>   
                    <li>
                    <a href="{{route('bitacora.revisar', $bitacora->id)}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i>Revisar folios</a>
                    </li>                    
                    @endif
                    @if($oficio->ruta_pdf)
                    <li>
                    <a href="{{route('oficio.respuesta', $oficio->id)}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i>Respuesta institución</a>
                    </li> 
                    @endif                   
                    <li>
                    <a href="{{route('pdf.caratula', $bitacora->id)}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i>Caratula</a>
                    </li>
                    <li>
                    <a href="{{route('pdf.folios', $bitacora->id)}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i>Imprimir folios</a>
                    </li>   
                    <li>
                    <a href="{{route('pdf.vacios', $bitacora->id)}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i>Generar folios vacios</a>
                    </li>                  
                </ul>         
              <div class="text-center mb-3">  
                  <a href="{{route('bitacora.ver', $bitacora->id)}}" class="btn btn-sm btn-primary">Detalle folios</a>
                  <a href="{{route('bitacora.crear_folio', $bitacora->id)}}" class="btn btn-sm btn-success">Agregar folio</a>
              </div>
          </div>

          <div class="col-12 col-md-12 col-lg-8 order-1 order-md-2">
              <div class="row">
                  <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Código</span>
                      <span class="info-box-number text-center text-muted mb-0">{{$bitacora->codigo ?? '--'}}</span>
                      </div>
                  </div>
                  </div>
                  <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Tipo</span>
                      <span class="info-box-number text-center text-muted mb-0">
                      @if($oficio->tipo == 1) Docencia @elseif($oficio->tipo == 2) Investigación @else Aplicada @endif                    
                      </span>
                      </div>
                  </div>
                  </div>
                  <div class="col-12 col-sm-4">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Horas acumuladas</span>
                      <span class="info-box-number text-center text-muted mb-0">{{$bitacora->horas}}<span>
                      </div>
                  </div>
                  </div>
              </div>
              <div class="row">
                  <div class="col-12">
                  <h5>Folios agregados</h5>
                      <div class="post">
                          <table class="table table-sm">
                              <thead class="thead-light">
                                  <th>Folio #</th>
                                  <th>Revisado</th>
                                  <th>Horas</th>
                              </thead>
                              <tbody>
                              @if($folios)
                              @php $cont = 0; @endphp
                                  @foreach ($folios as $f)
                                  <tr>
                                      <td>{{$f->numero}}</td>
                                      <td>@if($f->revisado)<span class="badge badge-success">SI</span>  @php $cont += $f->horas; @endphp
                                      @else <span class="badge badge-danger">NO</span>@endif</td>
                                      <td>{{$f->horas}}</td>                                    
                                  </tr>                               
                                  @endforeach
                                  <tr>
                                      <td colspan="1"></td>
                                      <th colspan="2">Horas revisadas: {{$cont}}</th>
                                  </tr>
                              @endif
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          </div>
        </div>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="row">
        <div class="col-12">
          <div class="card card-primary collapsed-card">
            <div class="card-header">
              <h3 class="card-title">Solicitud practicas finales</h3>
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                </button>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body">              
              <div class="row">                  
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Creación:  </span>
                      <span class="info-box-number text-center text-muted mb-0">{{date('d-m-Y', strtotime($oficio->created_at))}}</span>
                      </div>
                  </div>
                </div>
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Aprobada: </span>
                      <span class="info-box-number text-center text-muted mb-0">
                      @if($oficio->aprobado) <span class="badge bg-success">SI</span> @else <span class="badge bg-danger">NO</span> @endif
                      <span>
                      </div>
                  </div>
                </div>
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Tipo: </span>
                      <span class="info-box-number text-center text-muted mb-0">
                      @if($oficio->tipo == 1) Docencia @elseif($oficio->tipo == 2) Investigación @else Aplicada @endif
                      <span>
                      </div>
                  </div>
                </div>
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Semestre: </span>
                      <span class="info-box-number text-center text-muted mb-0">
                      @if($oficio->semestre == 1) Primero @else Segundo @endif
                      <span>
                      </div>
                  </div>
                </div>
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Año: </span>
                      <span class="info-box-number text-center text-muted mb-0">{{$oficio->year}}<span>
                      </div>
                  </div>
                </div> 
                <div class="col-6 col-sm-2">
                  <div class="info-box bg-light">
                      <div class="info-box-content">
                      <span class="info-box-text text-center text-muted">Fecha aprobación:  </span>
                      <span class="info-box-number text-center text-muted mb-0">{{date('d-m-Y', strtotime($oficio->f_oficio))}}</span>
                      </div>
                  </div>
                </div>
              </div> 
              <!-- /.FIN ROW 1 -->

              <dl class="row">
                <dd class="col-sm-12 mb-n1"> <b>Empresa: </b> {{$oficio->empresa}}</dd>
                <dd class="col-sm-6 "> <b>Dirección: </b> {{$oficio->direccion}}</dd>
                <dd class="col-sm-6 "> <b>Ubicación: </b> {{$oficio->ubicacion}}</dd>
                <dd class="col-sm-4 "> <b>Estudiante: </b> {{$oficio->estudiante}}</dd>
                <dd class="col-sm-3 "> <b>Carne: </b> {{$oficio->carne}}</dd>
                <dd class="col-sm-3 "> <b>Registro: </b> {{$oficio->registro}}</dd>       

                <dd class="col-sm-6 mb-n1"> <b>Destinatario: </b> {{$oficio->destinatario}}</dd>      
                <dd class="col-sm-6 mb-n1"> <b>Saludo: </b> {{$oficio->encabezado}}</dd>     
                @if($oficio->tipo == 1) 
                <dd class="col-sm-10 mb-n1"> <b>Curso: </b> {{$oficio->curso}}</dd>
                <dd class="col-sm-2 mb-n1"> <b>Código: </b> {{$oficio->codigo_curso}}</dd>
                @elseif($oficio->tipo == 2) 
                <dd class="col-sm-10 mb-n1"> <b>Tema o investigación: </b>"{{$oficio->curso}}"</dd>
                @else
                <dd class="col-sm-10 mb-n1"> <b>Puesto: </b>{{$oficio->puesto}}</dd>
                @endif
              </dl>                   

              <div class="row"> 
                <div class="callout callout-success">
                  <h5 > <i class="icon fas fa-check"></i> La solicitud de prácticas ya fue aprobada y revisada.</h5>
                  @if($oficio->ruta_pdf)
                  <p>Para ver la respuesta de la contraparte institucional, click <a href="{{route('oficio.respuesta', $oficio->id)}}">aquí</a> </p>
                  @endif
                </div>   
              </div>
              <!-- /.FIN ROW 3 -->

            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
    @endempty <!-- FIN CON/SIN BITACORA -->    
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

