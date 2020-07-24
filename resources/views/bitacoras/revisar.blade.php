@extends('plantilla.plantilla',['sidebar'=>62])

@section('titulo', 'Ver bitácora')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    @if(Auth()->user()->rol->id==2)
    <li class="breadcrumb-item"><a href="{{route('bitacora.individual')}}">Bitácora</a></li>
    <li class="breadcrumb-item"><a href="{{route('bitacora.ver', $bitacora->id)}}">Semestre {{$bitacora->semestre}} ({{$bitacora->year}})</a></li>
    @else
    <li class="breadcrumb-item"><a href="{{route('bitacora.index')}}">Bitácora</a></li>
    <li class="breadcrumb-item"><a href="{{route('bitacora.ver', $bitacora->id)}}">{{$estudiante->nombre}} {{$estudiante->apellido}} ({{$estudiante->registro}})</a></li>
    <li class="breadcrumb-item active">Revisar</li>
    @endif    
@endsection

@section('alerta')
  @if (session('revision')>0)
  <script> alerta_create('Revisión creada exitosamente.')</script>
  @endif  
  @if (session('valido')>0)
  <script> alerta_info('La bitácora ya está validada.')</script>
  @endif
@endsection

@section('contenido')
<div class="card card-primary card-outline">
    <input type="hidden" value="{{$bitacora->id}}" id="bitacora_id">
        <div class="card-header">
        @if($bitacora->semestre==1) @php $semestre='Primer semestre'; @endphp @else @php $semestre='Segundo semestre'; @endphp @endif
        <h4 class="">
            Revisar folios - {{$semestre}} - {{$bitacora->year}}
        </h4>
        </div>
        <div class="card-body">
        @if($bitacora->oficio && Auth()->user()->rol->id !=2)
        <div class="callout callout-info row mx-1">
        <h5 class="col-sm-6 mb-n1"><b>Oficio: </b>{{$bitacora->no_oficio}}</h5>
        <h5 class="col-sm-6 mb-n1"><b>No. de bitácora: </b>{{$bitacora->codigo}}</h5>
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
        </div>
        <div class="row">
          <div class="col-12">
            <!-- Custom Tabs -->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">Horas: {{$bitacora->horas}}</h3>
                <ul class="nav nav-pills mr-auto p-2">
                  <li class="nav-item"><a class="nav-link active" href="#tab_1" data-toggle="tab">Revisiones</a></li>
                  <li class="nav-item"><a class="nav-link" href="#tab_2" data-toggle="tab">Nueva revisión</a></li>     
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content ">
                  <div class="tab-pane active" id="tab_1">
                    @empty($revisiones)
                    <div class="callout callout-danger">
                    <h4><i class="fas fa-exclamation"></i> No hay revisiones de folios para esta bitácora</h4>
                    </div>
                    @else
                    <div id="accordion">
                        <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                        @foreach($revisiones as $r)
                        <div class="card card-primary">
                            <div class="card-header">
                            <h4 class="card-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse-{{$r->id}}">
                                {{date('d-M-Y', strtotime($r->fecha))}} - Ponderación: {{$r->ponderacion}}
                                </a>
                            </h4>
                            </div>
                            <div id="collapse-{{$r->id}}" class="panel-collapse collapse in">
                                <div class="card-body">
                                    <div class="row">
                                        @if($r->folio_inicial == $r->folio_final)
                                        <p class="col-sm-4 mb-n1 mt-1"><b>Folio: </b>{{$r->folio_final}}</p>
                                        @else
                                        <p class="col-sm-4 mb-n1 mt-1"><b>Folios: </b>Del {{$r->folio_inicial}} al {{$r->folio_final}}</p>
                                        @endif
                                        <p class="col-sm-4 mb-n1 mt-1"><b>Ponderacion:  </b> {{$r->ponderacion}}</p>
                                        <p class="col-sm-4 mb-n1 mt-1"><b>Fecha:  </b> {{date('d-m-Y', strtotime($r->fecha))}}</p>
                                        <p class="col-sm-12 mb-n1 mt-1"><b>Observaciones:  </b> {{$r->observaciones ?? '--'}}</p>
                                    </div>
                                </div>
                                <table class="table table-bordered table-sm">
                                    <thead class="thead-light">                            
                                    <th>Datos</th>
                                    <th>Descripción</th>
                                    <th>Observaciones</th>
                                    </thead>
                                    <tbody>
                                    @foreach($folios as $f)                            
                                        @if($f->revisado && $f->numero >= $r->folio_inicial && $f->numero <= $r->folio_final)
                                        <tr>
                                            <td>
                                            <div class="row" style="font-size: 0.85em;">
                                            <p class="col-sm-12 mb-n1"><b>Folio: </b>{{$f->numero}}</p>
                                            <p class="col-sm-12 mb-n1"><b>Horas: </b>{{$f->horas}}</p>
                                            <p class="col-sm-12 mb-n1"><b>Fecha inicial: </b>({{date('d-m-Y', strtotime($f->fecha_inicial))}}</p>
                                            <p class="col-sm-12 mb-n1"><b>Fecha final: </b>({{date('d-m-Y', strtotime($f->fecha_final))}}</p>
                                            </div>
                                            </td>
                                            <td style="font-size: 0.8em;">{{$f->descripcion}}</td>
                                            <td style="font-size: 0.8em;">{{$f->observaciones}}</td>
                                        </tr>
                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endempty                    
                  </div>
                  <!-- /.tab-pane -->
                  <div class="tab-pane shadow p-3" id="tab_2">
                    @empty($folios)
                    <div class="callout callout-danger">
                    <h4><i class="fas fa-exclamation"></i> No hay folios agregados en esta bitácora</h4>
                    </div>
                    @else
                        @php $todos_revisados = true; @endphp
                        @foreach($folios as $f)
                            @if(!$f->revisado)
                            @php $todos_revisados = false; @endphp
                            @endif
                        @endforeach
                    @if($todos_revisados)
                    <div class="callout callout-warning">
                    <h4><i class="fas fa-exclamation"></i> No hay folios para revisar.</h4>
                    </div>
                    @else                   
                    <form class="needs-validation" method="POST" action="{{route('bitacora.revision', $bitacora->id)}}" novalidate>
                    @csrf
                        <div class="form-row ">
                            <div class="col-md-4">
                                <label for="folio_inicial">Folio inicial</label>
                                <select class="form-control" required name="folio_inicial" onchange="folios()" id="folio_inicial">
                                    <option disabled>Seleccione un número</option>                                   
                                    @foreach($folios as $f)              
                                        @if(!$f->revisado)
                                        <option value="{{$f->numero}}">{{$f->numero}} ({{date('d-M-Y', strtotime($f->fecha_inicial))}} - {{date('d-M-Y', strtotime($f->fecha_final))}})</option>
                                        @endif
                                    @endforeach  
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="folio_final">Folio final</label>
                                <select class="form-control" required name="folio_final" onchange="folios()" id="folio_final">
                                    <option disabled>Seleccione un número</option>
                                    @foreach($folios as $f)              
                                        @if(!$f->revisado)
                                        <option value="{{$f->numero}}">{{$f->numero}} ({{date('d-M-Y', strtotime($f->fecha_inicial))}} - {{date('d-M-Y', strtotime($f->fecha_final))}})</option>
                                        @endif
                                    @endforeach  
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="validationCustom02">Ponderación</label>
                                <input type="text" class="form-control" id="validationCustom03" required name="ponderacion">
                                <div class="invalid-feedback">
                                Por favor ingrese valor numérico
                                </div>      
                            </div>
                            <div class="col-md-2 align-self-end">
                                <button class="btn btn-block bg-orange">Revisar</button>
                            </div>
                            <div class="col-md-12 mt-2" style="font-size: 0.85em;">
                                <label>Observaciones</label>
                                <textarea class="form-control" rows="1" placeholder="Comentario ..." name="observaciones" ></textarea>
                            </div>   
                        </div>
                        <br>
                        <table class="table table-bordered">
                            <thead class="thead-dark">                            
                            <th>Datos</th>
                            <th>Descripción</th>
                            <th>Observaciones</th>
                            </thead>
                            <tbody id="body_table">
                            @foreach($folios as $f)                            
                            @if(!$f->revisado)
                            <tr>
                                <td>
                                <div class="row">
                                <p class="col-sm-12"><b>Folio: </b>{{$f->numero}}</p>
                                <p class="col-sm-12"><b>Horas: </b>{{$f->horas}}</p>
                                <p class="col-sm-12"><b>Fecha inicial: </b>({{date('d-m-Y', strtotime($f->fecha_inicial))}}</p>
                                <p class="col-sm-12"><b>Fecha final: </b>({{date('d-m-Y', strtotime($f->fecha_final))}}</p>
                                </div>
                                </td>
                                <td style="font-size: 0.85em;">{{$f->descripcion}}</td>
                                <td style="font-size: 0.85em;">{{$f->observaciones}}</td>
                            </tr>
                            @endif
                            @endforeach
                            </tbody>
                        </table>
                    </form>
                    @endif
                    @endempty     
                  </div>                  
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- ./card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->        
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

function folios (){
    //e.preventDefault();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });
    jQuery.ajax({
        url: "{{ route('api.folios_revisar') }}",
        method: 'get',
        data: {
            bitacora_id: jQuery('#bitacora_id').val(),
            folio_inicial: jQuery('#folio_inicial').val(),
            folio_final: jQuery('#folio_final').val()
        },
        success: function(result){
            console.log(result['msg']);
            $('#body_table').html(result['msg']);
        }});    
}

$( document ).ready(function() {
    folios();
});
</script>
@endsection


