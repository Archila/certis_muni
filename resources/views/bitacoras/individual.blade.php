@extends('plantilla.plantilla',['sidebar'=>65])

@section('titulo', 'Bitácora')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{route('bitacora.individual')}}">Bitácora</a></li>
@endsection

@section('alerta')
  @if (session('error')=='ERROR')
  <script> alerta_error('Ya existe folio con ese número')</script>
  @endif
@endsection

@section('contenido')
<div class="card">
  <div class="card-header">
    <h3>Mi bitácora</h3> 
  </div>
  <div class="card-body">
  @if($nuevo)
    <div class="col-md-3 col-sm-12">
        <a class="btn btn-block btn-primary btn-sm" href="{{route('bitacora.crear')}}">Nueva bitácora</a>
    </div>
  @else
    <div class="row">
        <div class="col-12 col-md-12 col-lg-4 order-2 order-md-1">
            <h3 class="text-primary"><i class="fas fa-clipboard"></i> 
            @if($bitacora->semestre == 1) Primer semestre - {{$bitacora->year}}
            @else Segundo semestre - {{$bitacora->year}} @endif </h3>
            <div class="text-muted">
                <p class="text-sm">Empresa / Institución
                <b class="d-block">{{$empresa->nombre}} ({{$empresa->alias}})</b>
                </p>
                <p class="text-sm">Encargado
                <b class="d-block">{{$encargado->nombre}} {{$encargado->apellido}}</b>
                </p>
            </div>
            <h5 class="mt-2 text-muted">Estado de la bitácora</h5>
            @if($bitacora->oficio || $bitacora->valida)
                @if($bitacora->valida)
                <h5><span class="badge badge-success">Bitácora aprovada.</span></h5>
                <p>
                    Su bitácora ya ha sido aprovada totalmente, ya puede generar los folios e imprimir para llenarlos 
                    manualmente.
                </p>
                <ul class="list-unstyled">
                    <li>
                    <a href="{{route('pdf.caratula', $bitacora->id)}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i> caratula.pdf</a>
                    </li>
                    <li>
                    <a href="{{route('pdf.folios', $bitacora->id)}}" class="btn-link text-secondary"><i class="far fa-fw fa-file-pdf"></i> folios.pdf</a>
                    </li>
                </ul>
                @else 
                <h5><span class="badge badge-info">Oficio generado, esperando por aprovación.</span></h5>
                <p>
                    Se ha generado el oficio para su bitácora, aún no puede generar los fólios hasta recibir la carta correspondiente
                    a la contraparte institucional.
                </p>
                @endif
            
            @else
            <h5><span class="badge badge-secondary">Su bitácora aún no ha sido aprovada.</span></h5>
            <p>
                Por favor espere a que su bitácora sea aprovada o contácte con su supervisor de prácticas finales.
            </p>

            @endif              
            <div class="text-center mb-3">
                <a href="{{route('bitacora.ver', $bitacora->id)}}" class="btn btn-sm btn-primary">Detalle folios</a>
                @if($bitacora->valida)
                <a href="{{route('bitacora.crear_folio', $bitacora->id)}}" class="btn btn-sm btn-success">Agregar folio</a>
                @endif
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
                    @if($bitacora->tipo == 1) Docencia @elseif($bitacora->tipo == 3) Investigación @else Aplicada @endif                    
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
  @endif
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

<script>
function cbxEncargado(){
    var forms = document.getElementsByClassName('needs-validation');
    forms[0].classList.remove('was-validated');
    // Get the checkbox
    var checkBox = document.getElementById("cbx_encargado");    

    // If the checkbox is checked, display the output
    if (checkBox.checked == false){
        $('#div-encargado').show(800);        
        $('.encargado').attr('required',true);
    } else {
        $("#div-encargado").hide(800);
        $('.encargado').removeAttr('required');
    }
}

cbxEncargado();

</script>
@endsection

